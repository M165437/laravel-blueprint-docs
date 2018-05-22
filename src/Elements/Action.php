<?php

namespace M165437\BlueprintDocs\Elements;

use Illuminate\Support\Collection;

class Action extends Base
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $methodLower;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $parameters;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $requestsResponses;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $examples;

    /**
     * @var string
     */
    public $uriTemplate;

    /**
     * @var string
     */
    public $colorizedUriTemplate;

    /**
     * Setup element variables
     *
     * @return void
     */
    public function setup()
    {
        parent::setup();
        $this->method = $this->mapMethod();
        $this->methodLower = strtolower($this->method);
        $this->parameters = $this->mapParameters();
        $this->examples = $this->mapExamples();
        $this->uriTemplate = $this->mapUriTemplate();
        $this->colorizedUriTemplate = $this->mapColorizedUriTemplate();
    }

    /**
     * Map method
     *
     * @return string
     */
    private function mapMethod()
    {
        if(! isset($this->reynaldo->getHttpTransactions()[0])) {
            return '';
        }

        return $this->reynaldo->getHttpTransactions()[0]->getHttpRequest()->getMethod();
    }

    /**
     * Map parameters
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapParameters()
    {
        $resourceParams = new Collection(
            $this->parent->reynaldo->getHrefVariablesElement()->getAllVariables()
        );

        $actionParams = new Collection(
            $this->reynaldo->getHrefVariablesElement()->getAllVariables()
        );

        return $resourceParams->keyBy('name')
            ->merge($actionParams->keyBy('name'))
            ->flatten(1)
            ->map(function($reynaldoHrefVariablesElement) {
                return new HrefVariable($reynaldoHrefVariablesElement, $this);
            });
    }

    /**
     * Map request and response examples
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapExamples()
    {
        return (new Collection($this->reynaldo->getHttpTransactions()))
            ->map(function ($reynaldoTransaction) {
                return new Collection([
                    'request' => new HttpRequest($reynaldoTransaction->getHttpRequest(), $this),
                    'response' => new HttpResponse($reynaldoTransaction->getHttpResponse(), $this)
                ]);
            });
    }

    /**
     * Map URI template
     *
     * @return string
     */
    private function mapUriTemplate()
    {
        return $this->modifyUriTemplate($this->parent->reynaldo->getHref(), $this->parameters, false);
    }

    /**
     * Map colorized URI template
     *
     * @return string
     */
    private function mapColorizedUriTemplate()
    {
        return $this->modifyUriTemplate($this->parent->reynaldo->getHref(), $this->parameters, true);
    }

    /**
     * Modify URI template
     *
     * @param $templateUri
     * @param $parameters
     * @param $colorize
     *
     * @return string
     */
    private function modifyUriTemplate($templateUri, $parameters, $colorize)
    {
        $parameterNames = (new Collection($parameters))->pluck('name')->toArray();
        $parameterBlocks = [];
        $lastIndex = $index = 0;
        while ($index = strpos($templateUri, '{', $index)) {
            $parameterBlocks[] = substr($templateUri, $lastIndex, $index - $lastIndex);
            $closeIndex = strpos($templateUri, '}', $index);
            $block = [
                'querySet' => (strpos($templateUri, '{?', $index) === $index),
                'formSet' => (strpos($templateUri, '{&', $index) === $index),
                'reservedSet' => (strpos($templateUri, '{+', $index) === $index),
            ];
            $lastIndex = $closeIndex + 1;
            $index++;
            if (in_array(true, $block)) {
                $index++;
            }
            $parameterSet = substr($templateUri, $index, $closeIndex - $index);
            $block['parameters'] = array_filter(explode(',', $parameterSet), function($val) use ($parameterNames) {
                return array_search(urldecode(preg_replace('/^\*|\*$/', '', $val)), $parameterNames) !== false;
            });
            if (count($block['parameters'])) {
                $parameterBlocks[] = $block;
            }
        }
        $parameterBlocks[] = substr($templateUri, $lastIndex);
        return preg_replace('/\/+/', '/', array_reduce(
            array_keys($parameterBlocks),
            function($uri, $key) use ($parameters, $colorize, $parameterBlocks, $parameterNames) {
                $block = $parameterBlocks[$key];
                if (is_string($block)) {
                    $uri .= $block;
                } else {
                    $segment = !$colorize ? ['{'] : [];
                    if ($block['querySet']) {
                        $segment[] = '?';
                    }
                    if ($block['formSet']) {
                        $segment[] = '&';
                    }
                    if ($block['reservedSet'] && !$colorize) {
                        $segment[] = '+';
                    }
                    $segment[] = implode($colorize ? '&' : ',', array_map(
                        function($name) use ($block, $parameters, $colorize, $parameterNames) {
                            if (!$colorize) {
                                return $name;
                            } else {
                                $name = preg_replace('/^\*|\*$/', '', $name);
                                $param = $parameters[array_search(urldecode($name), $parameterNames)];
                                if ($block['querySet'] || $block['formSet']) {
                                    $example = isset($param->example) ? is_bool($param->example) ? $param->example ? 'true' : 'false' : $param->example : '';
                                    return '<span class="hljs-attribute">' . $name . '=</span>' . '<span class="hljs-literal">' . $example . '</span>';
                                } else {
                                    $example = isset($param->example) ? is_bool($param->example) ? $param->example ? 'true' : 'false' : $param->example : $name;
                                    return '<span class="hljs-attribute" title="' . $name . '">' . $example . '</span>';
                                }
                            }
                        },
                        $block['parameters']
                    ));
                    if (!$colorize) {
                        $segment[] = '}';
                    }
                    $uri .= implode($segment);
                }
                return $uri;
            }
        ));
    }
}

<?php

namespace M165437\BlueprintDocs;

use Parsedown;

class DescriptionParser extends Parsedown
{
    /**
     * @var string
     */
    protected $markup;

    /**
     * @var array
     */
    protected $headings = [];

    /**
     * Parse markdown.
     *
     * @param string $text
     *
     * @return \M165437\BlueprintDocs\MarkdownParser
     */
    public function parse($text)
    {
        $this->headings = [];
        $this->markup = parent::text($text);

        return $this;
    }

    /**
     * Get HTML markup from parsed markdown.
     *
     * @return string
     */
    public function getCopyText()
    {
        return $this->markup;
    }

    /**
     * Get headings from parsed markdown.
     * 
     * @return array
     */
    public function getHeadings()
    {
        return $this->headings;
    }

    /**
     * Handle markdown elements.
     *
     * @param array $Element
     *
     * @return string
     */
    protected function element(array $Element)
    {
        if ($this->isHeader($Element)) {
            $Element['attributes']['id'] = 'description-' . str_slug($Element['text'], '-');
            $Element['level'] = $Element['name'][1];
            array_push($this->headings, $Element);
        }

        return parent::element($Element);
    }

    /**
     * Evaluate header tag.
     *
     * @param array $Element
     *
     * @return boolean
     */
    protected function isHeader(array $Element)
    {
        return preg_match('/^[hH][1-6]$/', $Element['name']) ? true : false;
    }
}
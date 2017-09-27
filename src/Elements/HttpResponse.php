<?php

namespace M165437\BlueprintDocs\Elements;

use Illuminate\Support\Collection;

class HttpResponse extends Mapping
{
    /**
     * @return int
     */
    public $statusCode;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $headers;

    /**
     * @var string
     */
    public $messageBody;

    /**
     * @var string
     */
    public $messageBodySchema;

    /**
     * @var string
     */
    public $dataStructure;

    /**
     * @var boolean
     */
    public $hasContent;

    /**
     * Response constructor
     *
     * @param mixed $element
     * @param mixed $parent
     */
    public function __construct($element, $parent = null)
    {
        parent::__construct($element, $parent);
        $this->setup();
    }

    /**
     * Setup element variables
     *
     * @return void
     */
    public function setup()
    {
        $this->statusCode = $this->reynaldo->getStatusCode();
        $this->headers = new Collection($this->reynaldo->getHeaders());
        $this->messageBody = $this->mapMessageBody();
        $this->messageBodySchema = $this->mapMessageBodySchema();
        $this->dataStructure = $this->reynaldo->getDataStructure();
        $this->hasContent = $this->headers->count() || $this->messageBody || $this->messageBodySchema;
    }

    /**
     * Map message body
     *
     * @return mixed
     */
    private function mapMessageBody()
    {
        return $this->reynaldo->hasMessageBody() ?
            new Asset($this->reynaldo->getMessageBodyAsset(), $this) :
            null;
    }

    /**
     * Map message body schema
     *
     * @return mixed
     */
    private function mapMessageBodySchema()
    {
        return $this->reynaldo->hasMessageBodySchema() ?
            new Asset($this->reynaldo->getMessageBodySchemaAsset(), $this) :
            null;
    }
}
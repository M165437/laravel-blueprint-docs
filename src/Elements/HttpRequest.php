<?php

namespace M165437\BlueprintDocs\Elements;

use Illuminate\Support\Collection;

class HttpRequest extends Mapping
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $headers;

   /**
     * @var string
     */
    public $contentType;

    /**
     * @var string
     */
    public $messageBody;

    /**
     * @var string
     */
    public $messageBodySchema;

    /**
     * @var boolean
     */
    public $hasContent;

	/**
	 * @var string
	 */
	public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * Request constructor
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
        $this->method = $this->reynaldo->getMethod();
        $this->headers = new Collection($this->reynaldo->getHeaders());
        $this->contentType = $this->reynaldo->getContentType();
        $this->messageBody = $this->mapMessageBody();
        $this->messageBodySchema = $this->mapMessageBodySchema();
        $this->hasContent = $this->headers->count() || $this->messageBody || $this->messageBodySchema;
	    $this->title = $this->reynaldo->getTitle();
        $this->description = $this->reynaldo->getCopyText();
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

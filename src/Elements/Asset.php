<?php

namespace M165437\BlueprintDocs\Elements;

class Asset extends Mapping
{
    /**
     * @var string
     */
    public $contentType;

    /**
     * @var string
     */
    public $body;

    /**
     * Asset constructor
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
        $this->contentType = $this->reynaldo->getContentType();
        $this->body = $this->reynaldo->getBody();
    }
}
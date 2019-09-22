<?php

namespace M165437\BlueprintDocs\Elements;

use Illuminate\Support\Str;

abstract class Base extends Mapping
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $elementId;

    /**
     * @var string
     */
    public $elementLink;

    /**
     * @var string
     */
    public $descriptionHtml;

    /**
     * Base constructor
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
    protected function setup()
    {
        $this->name = $this->reynaldo->getTitle();
        $this->elementId = $this->mapElementId();
        $this->elementLink = '#' . $this->elementId;
        $this->descriptionHtml = resolve('Parsedown')->parse($this->reynaldo->getCopyText());
    }

    /**
     * Map element id
     *
     * @return string
     */
    private function mapElementId()
    {
        $class = $this;
        $elementId = Str::slug($this->name, '-');

        while ($parent = $class->parent) {
            $elementId = Str::slug($parent->name, '-') . '-' . $elementId;
            $class = $parent;
        }

        return $elementId;
    }
}
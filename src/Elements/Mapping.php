<?php

namespace M165437\BlueprintDocs\Elements;

use Exception;
use ReflectionClass;

abstract class Mapping
{
    /**
     * @var mixed
     */
    protected $reynaldo;

    /**
     * @var mixed
     */
    protected $parent;

    /**
     * Mapping constructor
     *
     * @param mixed $element
     * @param mixed $parent
     */
    public function __construct($element, $parent = null)
    {
        $this->reynaldo = $element;
        $this->parent = $parent;
    }

    /**
     * Find parent element
     *
     * @param string $parentClassName
     *
     * @return mixed
     * @throws Exception
     */
    protected function findParent($parentClassName)
    {
        $class = $this;

        while ($parent = $class->parent) {
            if ((new ReflectionClass($parent))->getShortName() === $parentClassName) {
                return $parent;
            }

            $class = $parent;
        }

        throw new Exception('Couldn\'t find desired parent.');
    }
}

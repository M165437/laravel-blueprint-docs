<?php

namespace M165437\BlueprintDocs\Elements;

class Attribute extends Mapping
{
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 */
	public $descriptionHtml;

	/**
	 * @var string
	 */
	public $type;

	/**
	 * @var string
	 */
	public $example;

	/**
	 * HrefVariable constructor
	 *
	 * @param array $element
	 * @param mixed $parent
	 */
	public function __construct(array $element, $parent = null)
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
		$this->description = $this->reynaldo['meta']['description'];
		$this->descriptionHtml = resolve('Parsedown')->parse($this->description);

		$this->name = $this->reynaldo['content']['key']['content'];
		$this->type = $this->reynaldo['content']['value']['element'];
		$this->example = $this->reynaldo['content']['value']['content'];
	}
}

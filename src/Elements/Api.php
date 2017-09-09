<?php

namespace M165437\BlueprintDocs\Elements;

use Hmaus\Reynaldo\Elements\ApiDescriptionRoot;
use M165437\BlueprintDocs\DescriptionParser;

class Api
{
    /**
     * @var \Hmaus\Reynaldo\Elements\ApiDescriptionRoot
     */
    protected $reynaldo;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $meta;

    /**
     * @var string
     */
    public $format;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $descriptionHtml;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $descriptionHeadings;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $resourceGroups;

    /**
     * Api constructor
     * 
     * @param ApiDescriptionRoot $reynaldoApiDescriptionRoot
     */
    public function __construct(ApiDescriptionRoot $reynaldoApiDescriptionRoot)
    {
        $this->reynaldo = $reynaldoApiDescriptionRoot;
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
        $this->meta = collect($this->reynaldo->getApiMetaData());
        $this->format = !empty($this->meta['FORMAT']) ? $this->meta['FORMAT'] : '';
        $this->host = !empty($this->meta['HOST']) ? $this->meta['HOST'] : '';
        $this->resourceGroups = $this->mapResourceGroups();
        $this->parseDescription();
    }

    /**
     * Parse description to markup and get headings
     * 
     * @return void
     */
    private function parseDescription()
    {
        $descriptionParser = new DescriptionParser();
        $descriptionParser->parse($this->reynaldo->getApiDocumentDescription());
        
        $this->descriptionHtml = $descriptionParser->getCopyText();
        $this->descriptionHeadings = collect($descriptionParser->getHeadings())
            ->map(function ($heading) {
                return (object) [
                    'id' => $heading['attributes']['id'],
                    'name' => $heading['name'],
                    'text' => $heading['text'],
                    'level' => $heading['level']
                ];
            })->values();
    }

    /**
     * Map resource Groups
     * 
     * @return \Illuminate\Support\Collection
     */
    private function mapResourceGroups()
    {
        return collect($this->reynaldo->getResourceGroups())->map(function ($reynaldoResourceGroup) {
            return new ResourceGroup($reynaldoResourceGroup);
        });
    }
}
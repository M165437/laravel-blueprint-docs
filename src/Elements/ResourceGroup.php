<?php

namespace M165437\BlueprintDocs\Elements;

class ResourceGroup extends Base
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public $resources;

    /**
     * Setup element variables
     *
     * @return void
     */
    protected function setup()
    {
        parent::setup();
        $this->resources = $this->mapRecources();
    }

    /**
     * Map resources
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapRecources()
    {
        return collect($this->reynaldo->getResources())
            ->map(function ($reynaldoResource) {
                return new Resource($reynaldoResource, $this);
            });
    }
}
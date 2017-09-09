<?php

namespace M165437\BlueprintDocs\Elements;

class Resource extends Base
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public $actions;

    /**
     * Setup element variables
     *
     * @return void
     */
    public function setup()
    {
        parent::setup();
        $this->actions = $this->mapActions();
    }

    /**
     * Map actions
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapActions()
    {
        return collect($this->reynaldo->getTransitions())
            ->map(function ($reynaldoTransition) {
                return new Action($reynaldoTransition, $this);
            });
    }
}
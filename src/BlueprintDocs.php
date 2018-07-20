<?php

namespace M165437\BlueprintDocs;

use Hmaus\DrafterPhp\Drafter;
use Hmaus\Reynaldo\Parser\RefractParser;
use M165437\BlueprintDocs\Elements\Api;

class BlueprintDocs
{
    /**
     * @var \Hmaus\DrafterPhp\Drafter
     */
    protected $drafter;

    /**
     * @var \Hmaus\Reynaldo\Parser\RefractParser
     */
    protected $refractParser;

    /**
     * @var array
     */
    protected $refract;

    /**
     * @var \Hmaus\Reynaldo\Elements\ApiDescriptionRoot
     */
    protected $reynaldo;

    /**
     * @var object
     */
    protected $api;

    /**
     * Create a new controller instance.
     *
     * @param Drafter $drafter
     */
    public function __construct(Drafter $drafter)
    {
        $this->drafter = $drafter;
        $this->refractParser = new RefractParser();
    }

    /**
     * Parse API Blueprint file
     *
     * @param string $apib_file
     *
     * @return BlueprintDocs
     */
    public function parse($apib_file)
    {
        $refract = $this->drafter
            ->input($apib_file)
            ->format('json')
            ->run();

        $this->refract = json_decode($refract, true);
        $this->reynaldo = $this->parseRefract($this->refract);

        return $this;
    }

    /**
     * Parse Reynaldo's traversable PHP data structure
     *
     * @param $refract
     *
     * @return \Hmaus\Reynaldo\Elements\ApiDescriptionRoot
     */
    private function parseRefract($refract)
    {
        return $this->refractParser
            ->parse($refract)
            ->getApi();
    }

    /**
     * Get BlueprintDocs api object for rendering
     *
     * @return Api
     */
    public function getApi()
    {
        return new Api($this->reynaldo);
    }

    /**
     * Get API Elements JSON representation
     *
     * @return array
     */
    public function getRefract()
    {
        return $this->refract;
    }

    /**
     * Get Reynaldo's traversable PHP data structure
     *
     * @return \Hmaus\Reynaldo\Elements\ApiDescriptionRoot
     */
    public function getReynaldo()
    {
        return $this->reynaldo;
    }
}

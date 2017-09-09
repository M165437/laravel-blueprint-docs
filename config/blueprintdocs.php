<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Blueprint Docs
    |--------------------------------------------------------------------------
    |
    | Find your rendered docs at the given route or set route to false if you
    | want to use your own route and controller. Provide a fully qualified
    | path to your API blueprint as well as to the required Drafter CLI.
    |
    */

    'route' => 'api-documentation',

    'blueprint_file' => base_path('blueprint.apib'),

    'drafter' => base_path('vendor/bin/drafter')

];
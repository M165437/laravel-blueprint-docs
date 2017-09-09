<?php

namespace M165437\BlueprintDocs;

use Illuminate\Routing\Controller;

class BlueprintDocsController extends Controller
{
    /**
     * Show the API Blueprint documentation.
     *
     * @param BlueprintDocs $blueprintDocs
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlueprintDocs $blueprintDocs)
    {
        $api = $blueprintDocs
            ->parse(config('blueprintdocs.blueprint_file'))
            ->getApi();
        
        return view('blueprintdocs::index', compact('api'));
    }
}

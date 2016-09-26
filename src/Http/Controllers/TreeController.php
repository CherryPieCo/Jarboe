<?php 

namespace Yaro\Jarboe\Http\Controllers;


class TreeController extends \App\Http\Controllers\Controller
{

    protected $node;

    public function init($node)
    {
        // FIXME: move paramter to config
        if (!$node->isActive(app()->getLocale()) && !request()->has('show') && !$node->hasTableDefinition()) {
            abort(404);
        }
        $this->node = $node;
        
        return $this;
    } // end init

    public function showThemeMain()
    {
        return view('admin::welcome');
    } // end showThemeMain

}

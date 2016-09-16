<?php 

namespace Yaro\Jarboe\Http\Controllers;


class TreeController extends \App\Http\Controllers\Controller
{

    protected $node;

    public function init($node, $method)
    {
        // FIXME: move paramter to config
        if (!$node->isActive(app()->getLocale()) && !request()->has('show')) {
            abort(404);
        }
        $this->node = $node;

        return $this->$method();
    } // end init

    public function showThemeMain()
    {
        return view('admin::welcome');
    } // end showThemeMain

}

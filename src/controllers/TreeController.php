<?php 

namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;


class TreeController extends \Controller
{

    protected $node;

    public function init($node, $method)
    {
        if (!$node->isActive() && !Input::has('show')) {
            \App::abort(404);
        }

        $this->node = $node;

        return $this->$method();
    } // end init

    public function showThemeMain()
    {
        return View::make('admin::demo.main');
    } // end showThemeMain

}
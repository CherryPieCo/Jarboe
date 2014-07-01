<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class ViewHandler {

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    public function showList()
    {
        $table = View::make('tb::table_builder');
        $table->def  = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;

        return $table;
    } // end showList

    public function showEditForm($id = false)
    {
        $table = View::make('tb::form_body');
        $table->def = $this->controller->getDefinition();
        $table->controller = $this->controller;

        $table->is_blank = true;
        if ($id) {
            $table->row = $this->controller->query->getRow($id);
            $table->is_blank = false;
        }

        return $table->render();
    } // end showEditForm

}

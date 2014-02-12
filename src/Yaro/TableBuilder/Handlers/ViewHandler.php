<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\View;


class ViewHandler {

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    public function showList()
    {
        $table = View::make($this->controller->getOption('tpl_path') .'.table_builder');
        $table->def  = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;

        return $table;
    } // end showList

    public function getUpdatedTable()
    {
        $table = View::make($this->controller->getOption('tpl_path') .'.table_tbody');
        $table->def = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;

        return $table->render();
    } // end getUpdatedTable

}

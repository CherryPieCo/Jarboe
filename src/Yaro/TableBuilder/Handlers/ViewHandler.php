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
        $table = View::make($this->controller->getOption('tpl_path') .'.table_builder');
        $table->def  = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;

        return $table;
    } // end showList

    public function showEditForm($id)
    {
        $table = View::make($this->controller->getOption('tpl_path') .'.form_body');
        $table->def = $this->controller->getDefinition();
        $table->row = $this->controller->query->getRow($id);
        $table->controller = $this->controller;
        $table->is_blank = false;

        return $table->render();
    } // end showEditForm

    public function showBlankForm()
    {
        $table = View::make($this->controller->getOption('tpl_path') .'.form_body');
        $table->def = $this->controller->getDefinition();
        $table->controller = $this->controller;
        $table->is_blank = true;

        return $table->render();
    } // end showBlankForm
/*
    public function getUpdatedTable()
    {
        $table = View::make($this->controller->getOption('tpl_path') .'.table_tbody');
        $table->def  = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;

        $res = array(
            $table->render(),
            $this->getPagination($table->rows)
        );
        return $res;
    } // end getUpdatedTable

    public function getPagination($rows)
    {
        $pagination = View::make($this->controller->getOption('tpl_path') .'.table_pagination');
        $pagination->rows = $rows;

        return $pagination->render();
    } // end getPagination
*/
}

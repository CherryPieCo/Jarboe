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
        $table = View::make('admin::tb.table_builder');
        $table->def  = $this->controller->getDefinition();
        $table->rows = $this->controller->query->getRows();
        $table->controller = $this->controller;
        
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.per_page';
        $table->per_page = Session::get($sessionPath);

        return $table;
    } // end showList

    public function showEditForm($id = false)
    {
        $table = View::make('admin::tb.modal_form');
        if ($id) {
            $table = View::make('admin::tb.modal_form_edit');
        }
        
        $table->def = $this->controller->getDefinition();
        $table->controller = $this->controller;

        $table->is_blank = true;
        if ($id) {
            $table->row = $this->controller->query->getRow($id);
            $table->is_blank = false;
        }

        return $table->render();
    } // end showEditForm
    
    public function getRowHtml($data)
    {
        // FIXME: primary key
        $data['values'] = $this->controller->query->getRow($data['id']);
        
        $row = View::make('admin::tb.single_row');
        $row->controller = $this->controller;
        $row->actions    = $this->controller->actions;
        $row->def        = $this->controller->getDefinition();
        $row->row        = $data['values'];
        
        return $row->render();
    } // end getRowHtml
    
    public function fetchActions(array $row)
    {
        $actions = View::make('admin::tb.single_row_actions');
        $actions->row = $row;
        $actions->def = $this->controller->getDefinition();
        $actions->actions = $this->controller->actions;
        
        return $actions->render();
    } // end fetchActions

}

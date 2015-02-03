<?php

class TableAdminController extends BaseController
{
    
    public function showSettings()
    {
        $options = array(
            'url'      => '/admin/settings',
            'def_name' => 'settings',
        );
        list($table, $form) = TableBuilder::create($options);

        $view = View::make('admin::table', compact('table', 'form'));

        return $view;
    } // end showSettings
    
    public function handleSettings()
    {
        $options = array(
            'url'      => '/admin/settings',
            'def_name' => 'settings',
        );
        return TableBuilder::create($options);
    } // end handleSettings  
    
    public function showTree()
    {
        $controller = TableBuilder::tree();
        
        return $controller->handle();
    } // end showTree
    
    public function handleTree()
    {
        $controller = TableBuilder::tree();
        
        return $controller->process();
    } // end handleTree    
        
}

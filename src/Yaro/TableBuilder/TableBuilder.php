<?php namespace Yaro\TableBuilder;


class TableBuilder {

    protected $controller;

    protected function onInit($options)
    {
        $this->controller = new TableBuilderController($options);
    } // end onInit

    public function create($options)
    {
        $this->onInit($options);
        
        return $this->controller->request->process();
    } // end create

}

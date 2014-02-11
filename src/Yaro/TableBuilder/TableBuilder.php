<?php namespace Yaro\TableBuilder;


class TableBuilder {

    protected $controller;

    protected function onInit($options)
    {
        $this->controller = new TableBuilderController($options);
    } // end onInit

    public function handle($options)
    {
        $this->onInit($options);
        return $this->controller->request->process();
    } // end handle

    public function show($options)
    {
        $this->onInit($options);
        return $this->controller->view->showList();
    } // end show

}

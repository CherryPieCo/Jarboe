<?php namespace Yaro\TableBuilder;


class TableBuilder {

    protected $handler;
    protected $view;

    public function __construct()
    {
        $this->handler = new Handlers\BaseHandler();
        $this->view = new Handlers\ViewHandler();
    } // end __construct

    public function ohHai()
    {
        return $this->handler->gg();
    } // end ohHai

    public function show($table)
    {
        return $this->view->create($table);
    } // end show

}

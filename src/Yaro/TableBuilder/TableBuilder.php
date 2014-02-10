<?php namespace Yaro\TableBuilder;


class TableBuilder {

    protected $view;

    public function __construct()
    {
        $this->view = new Handlers\ViewHandler();
    } // end __construct

    public function handle($table)
    {
        $definition = $this->view->getTableDefinition($table);
        
        $requestHandler = new Handlers\RequestHandler($definition);
        return $requestHandler->process();
    } // end handle

    public function create($table)
    {
        return $this->view->create($table);
    } // end create

}

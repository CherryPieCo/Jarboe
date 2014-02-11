<?php namespace Yaro\TableBuilder\Handlers;

abstract class CustomHandler {

    protected $controller;


    public function __construct($controller)
    {
        $this->controller = $controller;
    } // end __construct

    protected function getOption($ident)
    {
        return $this->controller->getOption($ident);
    } // end getOption

}

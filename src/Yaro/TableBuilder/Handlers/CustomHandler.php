<?php namespace Yaro\TableBuilder\Handlers;

abstract class CustomHandler {

    protected $controller;


    public function __construct($controller)
    {
        $this->controller = $controller;
    } // end __construct

}

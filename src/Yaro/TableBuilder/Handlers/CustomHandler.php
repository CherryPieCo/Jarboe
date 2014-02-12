<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;


abstract class CustomHandler {

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    protected function getOption($ident)
    {
        return $this->controller->getOption($ident);
    } // end getOption


    public function onGetValue($formField, array &$row)
    {
        return false;
    } // end onGetValue

    public function onGetEditInput($formField, array &$row)
    {
        return false;
    } // end onGetEditInput

    public function onPrepareSearchFilters(&$filters)
    {
    } // end onPrepareSearchFilters
    
    public function onSearchFilter(&$db, $name, $value)
    {
        return false;
    } // end onSearchFilter

    public function onUpdateRowResponse(array &$response)
    {
    } // end onUpdateRowResponse
}

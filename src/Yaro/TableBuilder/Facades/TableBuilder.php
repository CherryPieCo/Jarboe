<?php namespace Yaro\TableBuilder\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class TableBuilder extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() 
    {
        return 'tablebuilder'; 
    } // end getFacadeAccessor
 
}
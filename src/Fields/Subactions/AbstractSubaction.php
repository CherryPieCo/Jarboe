<?php

namespace Yaro\Jarboe\Fields\Subactions;


abstract class AbstractSubaction 
{
    protected $attributes;


    public function __construct($attributes)
    {
       $this->attributes = $attributes;
    } // end __construct
    
    public function getAttribute($ident)
    {
        return isset($this->attributes[$ident]) ? $this->attributes[$ident] : false;
    } // end getAttribute
    
}
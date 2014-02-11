<?php namespace Yaro\TableBuilder\Fields;


abstract class AbstractField {

    protected $def;
    protected $attributes;

    public function __construct($definition, $field)
    {
       $this->def = $definition;
       $this->attributes = $this->loadAttributes();
    } // end __construct
        
    protected function loadAttributes()
    {
    } // end getAttributes

    abstract public function getValue()
    {
    } // end getValue
}

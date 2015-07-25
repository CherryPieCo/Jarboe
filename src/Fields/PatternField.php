<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\View;


class PatternField 
{
    
    protected $fieldName;
    protected $attributes;
    protected $options;
    protected $definition;
    protected $calls;

    protected $handler;


    public function __construct($fieldName, $attributes, $options, $definition, $handler)
    {
        $this->attributes = $attributes;
        $this->options    = $options;
        $this->definition = $definition;
        $this->fieldName  = $fieldName;
        
        $this->handler = &$handler;
        
        $patternName = preg_replace('~^pattern\.~', '', $fieldName);
        $path = base_path('resources/definitions/patterns/'. $patternName .'.php');
        if (!file_exists($path)) {
            throw new \RuntimeException("No pattern definition - [{$patternName}].");
        }
        $this->calls = require($path);
    } // end __construct
    
    public function renderForm(array $row = array())
    {
        $view = $this->calls['view']['form'];
        return $view($row);
    } // end renderForm
    
    public function renderList(array $row)
    {
        $view = $this->calls['view']['list'];
        return $view($row);
    } // end renderList
    
    public function update($values, $idRow)
    {
        $call = $this->calls['handle']['update'];
        return $call($values, $idRow);
    } // end update    
    
    public function insert($values, $idRow)
    {
        $call = $this->calls['handle']['insert'];
        return $call($values, $idRow);
    } // end insert    
    
    public function delete($idRow)
    {
        $call = $this->calls['handle']['delete'];
        return $call($idRow);
    } // end delete
    
    public function isPattern()
    {
        return true;
    } // end isPattern
    
    public function getAttribute($ident, $default = false)
    {
        return array_key_exists($ident, $this->attributes) ? $this->attributes[$ident] : $default;
    } // end getAttribute
    
    public function isHidden()
    {
        return $this->getAttribute('hide');
    } // end isHidden
    
    // HACK: for create from
    public function isReadonly()
    {
        return false; 
    } // end isReadonly
    
}

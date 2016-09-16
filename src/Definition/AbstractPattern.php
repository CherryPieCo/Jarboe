<?php

namespace Yaro\Jarboe\Definition;

abstract class AbstractPattern
{
    protected $definition;
    
    public function __construct($definition)
    {
        $this->definition = $definition;
    } // end __construct
    
    public function viewList($row)
    {
        
    } // end viewList
    
    public function viewForm($row)
    {
        
    } // end viewForm
    
    public function handleInsert($idRow, $patternValue, $values)
    {
        
    } // end handleInsert
    
    public function handleUpdate($idRow, $patternValue, $values)
    {
        
    } // end handleUpdate
    
    public function handleDelete($idRow)
    {
        
    } // end handleDelete
}

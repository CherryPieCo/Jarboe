<?php 

namespace Yaro\Jarboe\Fields;


class PatternField 
{
    
    protected $fieldName;
    protected $patternName;
    protected $attributes;
    protected $options;
    protected $definition;
    protected $pattern;

    protected $handler;


    public function __construct($fieldName, $attributes, $options, $definition, $handler, $patternsNamespace)
    {
        $this->attributes = $attributes;
        $this->options    = $options;
        $this->definition = $definition;
        $this->fieldName  = $fieldName;
        
        $this->handler = &$handler;
        
        $this->patternName = preg_replace('~^pattern\.~', '', $fieldName);
        $patternClass = $patternsNamespace .'\\'. ucfirst(camel_case($this->patternName));
        $this->pattern = new $patternClass($this->definition);
    } // end __construct
    
    public function getFieldName()
    {
        return $this->fieldName;
    } // end getFieldName
    
    /*
     * Dummy
     */
    public function afterInsert()
    {
        
    } // end afterInsert
    
    /*
     * Dummy
     */
    public function afterUpdate()
    {
        
    } // end afterUpdate
    
    private function getPatternValues($values)
    {
        return array_get($values, 'pattern.'. $this->patternName);
    } // end getPatternValues
    
    public function renderForm($row = false)
    {
        return $this->pattern->viewForm($row);
    } // end renderForm
    
    public function renderList($row)
    {
        return $this->pattern->viewList($row);
    } // end renderList
    
    public function update($values, $idRow)
    {
        return $this->pattern->handleUpdate($idRow, $this->getPatternValues($values), $values);
    } // end update    
    
    public function insert($values, $idRow)
    {
        return $this->pattern->handleInsert($idRow, $this->getPatternValues($values), $values);
    } // end insert    
    
    public function delete($idRow)
    {
        return $this->pattern->handleDelete($idRow);
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

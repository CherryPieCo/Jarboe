<?php

namespace Yaro\Jarboe\Definition;


abstract class AbstractDefinition
{
    protected $patternsNamespace = '\\App\\Definitions\\Patterns';
    
    private $database;
    private $options;
    private $fields = [];
    private $patterns = [];
    private $position;
    private $filters;
    private $actions;
    private $isSearchable = null;
    
    
    public function init()
    {
        $this->database = collect();
        $this->initDatabase($this->database);
        
        $this->options = collect();
        $this->initOptions($this->options);
        
        $this->initFields();
        
        $this->position = collect();
        $this->initPosition($this->position);
        
        $this->filters = collect();
        $this->initFilters($this->filters);
        
        $this->actions = [];
        $this->initActions($this->actions);
    } // end init
    
    protected function initPosition($container)
    {
        
    } // end initPosition
    
    protected function initFilters($container)
    {
        
    } // end initFilters
    
    public function getName()
    {
        return static::class;
    } // end getName
    
    public function isSearchable()
    {
        if (!is_null($this->isSearchable)) {
            return $this->isSearchable;
        }
        
        $this->isSearchable = false;
        foreach ($this->getFields() as $field) {
            if ($field->getAttribute('filter')) {
                $this->isSearchable = true;
                break;
            }
        }
        
        return $this->isSearchable;
    } // end _isSearchable
    
    public function getActions()
    {
        return $this->actions;
    } // end getActions
    
    public function getFilters()
    {
        return $this->filters;
    } // end getFilters
    
    public function getOptions()
    {
        return $this->options; 
    } // end getOptions
    
    public function getOption($ident)
    {
        return $this->options->get($ident); 
    } // end getOption
    
    public function getDatabaseOption($ident)
    {
        return $this->database->get($ident);
    } // end getDatabaseOption
    
    public function hasDatabaseOption($ident)
    {
        return $this->database->has($ident);
    } // end hasDatabaseOption
    
    public function getField($ident)
    {
        if (isset($this->fields[$ident])) {
            return $this->fields[$ident];
        // FIXME:
        } elseif (isset($this->patterns[$ident])) {
            return $this->fields[$ident];
        }

        throw new \RuntimeException(sprintf('Field [%s] does not exist for current scheme.', $ident));
    } // end getFields
    
    public function getFields()
    {
        return $this->fields;
    } // end getFields
    
    public function getPosition()
    {
        return $this->position;
    } // end getPosition
    
    protected function isPatternField($name)
    {
        return preg_match('~^pattern\.~', $name);
    } // end isPatternField
    
    protected function createField($name, $info) 
    {
        if ($this->isPatternField($name)) {
            $this->fields[$name] = $this->createPatternInstance($name, $info);
        } else {
            $this->fields[$name] = $this->createFieldInstance($name, $info);
        }
    } // end createField

    private function createPatternInstance($name, $info)
    {
        return new \Yaro\Jarboe\Fields\PatternField(
            $name, 
            $info, 
            $this->options, 
            $this, 
            null,
            $this->patternsNamespace
        );
    } // end createPatternInstance
    
    private function createFieldInstance($name, $info)
    {
        $className = 'Yaro\\Jarboe\\Fields\\'. ucfirst(camel_case($info['type'])) .'Field';

        return new $className(
            $name, 
            $info, 
            $this->options, 
            $this, 
            null
        );
    } // end createFieldInstance
    

    
    
         
    /*
     * Calls before deleting row
     */
    protected function callbackDeleteRow($id) 
    {
        // return will skip delete logic
        /*
        return [
            'id'     => $id,
            'status' => $res
        ];
        */
    } // end callbackDeleteRow
    
    
}

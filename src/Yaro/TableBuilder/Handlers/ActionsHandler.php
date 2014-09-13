<?php

namespace Yaro\TableBuilder\Handlers;

class ActionsHandler 
{
    
    protected $def;

    public function __construct(array $actionsDefinition)
    {
        $this->def = $actionsDefinition;
    } // end __construct
    
    public function fetch($type, $row = array(), $buttonDefinition = array())
    {
        switch ($type) {
            case 'insert':
                return $this->onInsertButton();
                
            case 'update':
                return $this->onUpdateButton($row);
                
            case 'delete':
                return $this->onDeleteButton($row);
                
            case 'custom':
                return $this->onCustomButton($row, $buttonDefinition);
            
            default:
                throw new \RuntimeException('Not implemented row action');
        }
    } // end fetch
    
    private function onCustomButton($row, $button)
    {
        if (!$this->isAllowed('custom', $button)) {
            return '';
        }
        
        $action = \View::make('admin::tb.action_custom');
        $action->row = $row;
        $action->def = $button;
        
        return $action;
    } // end onCustomButton    
    
    private function onInsertButton()
    {
        if (!$this->isAllowed('insert')) {
            return '';
        }
        
        $action = \View::make('admin::tb.action_insert');
        $action->def = $this->def['insert'];
        
        return $action;
    } // end onInsertButton
    
    private function onUpdateButton($row)
    {
        if (!$this->isAllowed('update')) {
            return '';
        }
        
        $action = \View::make('admin::tb.action_update');
        $action->row = $row;
        $action->def = $this->def['update'];
        
        return $action;
    } // end onUpdateButton
    
    private function onDeleteButton($row)
    {
        if (!$this->isAllowed('delete')) {
            return '';
        }
        
        $action = \View::make('admin::tb.action_delete');
        $action->row = $row;
        $action->def = $this->def['delete'];
        
        return $action;
    } // end onDeleteButton
    
    public function isAllowed($type, $buttonDefinition = array())
    {
        $def = $buttonDefinition ? $buttonDefinition : $this->def[$type];
        
        if (isset($def)) {
            if (array_key_exists('check', $def)) {
                return $def['check']();
            }
            
            return true;
        }
        
        return false;
    } // end isAllowed
    
}
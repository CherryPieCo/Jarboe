<?php

namespace Yaro\Jarboe\Handlers;

class ActionsHandler 
{
    
    protected $def;
    protected $controller;

    public function __construct(array $actionsDefinition, &$controller)
    {
        $this->def = $actionsDefinition;
        $this->controller = $controller;
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
                
            case 'restore':
                return $this->onRestoreButton($row);
                
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
        
        $action = \View::make('admin::tb.action.custom');
        $action->row = $row;
        $action->def = $button;
        $action->definition = $this->controller->getDefinition();
        
        return $action;
    } // end onCustomButton    
    
    private function onInsertButton()
    {
        if (!$this->isAllowed('insert')) {
            return '';
        }
        
        if ($this->controller->hasCustomHandlerMethod('onInsertButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onInsertButtonFetch($this->def['insert']);
            if ($res) {
                return $res;
            }
        }
        
        $action = \View::make('admin::tb.action.insert');
        $action->def = $this->def['insert'];
        $action->definition = $this->controller->getDefinition();
        
        return $action;
    } // end onInsertButton
    
    private function onUpdateButton($row)
    {
        if (!$this->isAllowed('update')) {
            return '';
        }
        
        if ($this->controller->hasCustomHandlerMethod('onUpdateButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onUpdateButtonFetch($this->def['update']);
            if ($res) {
                return $res;
            }
        }
        
        $action = \View::make('admin::tb.action.update');
        $action->row = $row;
        $action->def = $this->def['update'];
        $action->definition = $this->controller->getDefinition();
        
        return $action;
    } // end onUpdateButton
    
    private function onDeleteButton($row)
    {
        if (!$this->isAllowed('delete')) {
            return '';
        }
        
        if ($this->controller->hasCustomHandlerMethod('onDeleteButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onDeleteButtonFetch($this->def['delete']);
            if ($res) {
                return $res;
            }
        }
        
        $action = \View::make('admin::tb.action.delete');
        $action->row = $row;
        $action->def = $this->def['delete'];
        $action->definition = $this->controller->getDefinition();
        
        return $action;
    } // end onDeleteButton
    
    private function onRestoreButton($row)
    {
        if (!$this->isAllowed('restore')) {
            return '';
        }
        
        if ($this->controller->hasCustomHandlerMethod('onRestoreButtonFetch')) {
            $res = $this->controller->getCustomHandler()->onRestoreButtonFetch($this->def['restore']);
            if ($res) {
                return $res;
            }
        }
        
        $action = \View::make('admin::tb.action.restore');
        $action->row = $row;
        $action->def = $this->def['restore'];
        $action->definition = $this->controller->getDefinition();
        
        return $action;
    } // end onRestoreButton
    
    public function isAllowed($type, $buttonDefinition = array())
    {
        $def = isset($this->def[$type]) ? $this->def[$type] : false;
        if ($buttonDefinition) {
            $def = $buttonDefinition;
        }
        
        if ($def) {
            if (array_key_exists('check', $def)) {
                return $def['check']();
            }
            
            return true;
        }
        
        return false;
    } // end isAllowed
    
}
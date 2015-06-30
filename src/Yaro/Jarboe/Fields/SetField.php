<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class SetField extends AbstractField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        // FIXME: add multiple search attributes
        $table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'. $value .'%');
    } // end onSearchFilter

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $table = View::make('admin::tb.filter_set');
        $table->filter  = $filter;
        $table->name    = $this->getFieldName();
        $table->options = $this->getAttribute('options');

        return $table->render();
    } // end getFilterInput

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res; 
            }
        }

        $input = View::make('admin::tb.input_set');
        $input->selected = explode(',', $this->getValue($row));
        $input->name     = $this->getFieldName();
        $input->options  = $this->getAttribute('options');

        return $input->render();
    } // end getEditInput
    
    public function getInlineEditInput($row)
    {
        $input = View::make('admin::tb.input_inline_set');
        $input->row      = $row;
        $input->name     = $this->getFieldName();
        $input->options  = $this->getRequiredAttribute('options');
        $input->selected = explode(',', $this->getValue($row));
        
        return $input->render();
    } // end getInlineEditInput
    
    public function doSaveInlineEditForm($idRow, $values)
    {
        if (!$this->isInlineEdit()) {
            throw new RuntimeException('No inline editing is allowed for ['. $this->getFieldName() .']');
        }
        
        $errors = array();
        
        // FIXME: validation, etc
        $table = $this->getDefinitionOption('db.table');
        $value = $this->getValue($values) ? : array();
        $value = array_keys($value);
        \DB::table($table)->where('id', $idRow)->update(array(
            $this->getFieldName() => $this->prepareQueryValue($value)
        ));
        
        return $errors;
    } // end doSaveInlineEditForm

    public function getRowColor($row)
    {
        // FIXME:
        $colors = $this->getAttribute('colors');
        if ($colors) {
            return isset($colors[$this->getValue($row)]) ? $colors[$this->getValue($row)] : '';
        }
    } // end getRowColor
    
    //
    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row, $postfix);
            if ($res) {
                return $res;
            }
        }
        
        $fieldName = $this->getFieldName() . $postfix;
        // postfix used for getting values for form - tabs loop
        // so there is no need to force appending postfix
        if ($this->getAttribute('tabs') && !$postfix) {
            $tabs = $this->getAttribute('tabs');
            $fieldName = $fieldName . $tabs[0]['postfix'];
        }
        $value = isset($row[$fieldName]) ? $row[$fieldName] : '';
        
        return $value;
    } // end getValue
    
    public function prepareQueryValue($value)
    {
        if (!$value) {
            if ($this->getAttribute('is_null')) {
                return null;
            }
        }

        return implode(',', $value);
    } // end prepareQueryValue
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $values = array_filter(explode(',', $this->getValue($row)));
        $options = $this->getAttribute('options');
        $prepared = array();
        foreach ($values as $value) {
            $prepared[] = $options[$value];
        }
        
        return implode(', ', $prepared);
    } // end getListValue
    
}

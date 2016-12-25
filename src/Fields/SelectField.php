<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class SelectField extends AbstractField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition->getDatabaseOption('table');
        $db->where($table .'.'. $this->getFieldName(), '=', $value);
    } // end onSearchFilter

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->definition->getName();
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = session()->get($sessionPath, '');

        $table = view('admin::tb.filter.select');
        $table->filter = $filter;
        $table->name  = $this->getFieldName();
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

        $table = view('admin::tb.input.select');
        $table->selected = $this->getValue($row);
        $table->name  = $this->getFieldName();
        $table->options = $this->getAttribute('options');

        return $table->render();
    } // end getEditInput
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $val = $this->getValue($row);
        $options = $this->getAttribute('options');
        
        return $options[$val];
    } // end getListValue

    public function getRowColor($row)
    {
        $colors = $this->getAttribute('colors');
        if ($colors) {
            return isset($colors[$this->getValue($row)]) ? $colors[$this->getValue($row)] : '';
        }
    }
}

<?php 

namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class CheckboxField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable
    
    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), '=', $value);
    } // end onSearchFilter

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.filter_checkbox');
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

        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.input_checkbox');
        $table->value = $this->getValue($row);
        $table->name  = $this->getFieldName();
        $table->caption = $this->getAttribute('caption');

        return $table->render();
    } // end getEditInput
    
    public function getListValue($row)
    {
        $tplPath = $this->getOption('tpl_path');
        
        return View::make($tplPath .'.input_checkbox_list')->with('is_checked', $this->getValue($row));
    } // end getListValue
    
}

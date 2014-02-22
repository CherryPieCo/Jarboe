<?php namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class SelectField extends AbstractField {

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

        $table = View::make($tplPath .'.filter_select');
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

        $table = View::make($tplPath .'.input_select');
        $table->value = $this->getValue($row);
        $table->name  = $this->getFieldName();
        $table->options = $this->getAttribute('options');

        return $table->render();
    } // end getEditInput

}

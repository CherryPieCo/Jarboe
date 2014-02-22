<?php namespace Yaro\TableBuilder\Fields;


class TextField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $type = $this->getAttribute('type');
        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.input_'. $type);
        $table->value = $this->getValue($row);
        $table->name  = $this->getFieldName();

        return $table->render();
    } // end getEditInput

}

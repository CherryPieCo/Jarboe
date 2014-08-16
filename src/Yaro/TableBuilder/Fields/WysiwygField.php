<?php namespace Yaro\TableBuilder\Fields;


class WysiwygField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        return substr($this->getValue($row), 0, 300);
    } // end getListValue

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

}

<?php namespace Yaro\TableBuilder\Fields;


class ReadonlyField extends AbstractField {

    public function getEditInput($row)
    {
        return '';
    } // end getEditInput

    public function isEditable()
    {
        return false;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
}

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

}

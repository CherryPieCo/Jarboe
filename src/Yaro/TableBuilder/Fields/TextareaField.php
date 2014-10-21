<?php namespace Yaro\TableBuilder\Fields;


class TextareaField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
    	$table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getLabelClass()
    {
        return 'textarea';
    } // end getLabelClass

}

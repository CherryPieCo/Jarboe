<?php 

namespace Yaro\Jarboe\Fields;


class ReadonlyField extends AbstractField 
{

    public function getEditInput($row = array())
    {
        return e($this->getValue($row));
    } // end getEditInput
    
    public function isReadonly()
    {
        return true;
    } // end isReadonly

    public function isEditable()
    {
        return false;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
}

<?php namespace Yaro\TableBuilder\Fields;


class WysiwygField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
    	if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
		
        return substr(strip_tags($this->getValue($row)), 0, 300) . '...';
    } // end getListValue

    public function onSearchFilter(&$db, $value)
    {
    	$table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

}

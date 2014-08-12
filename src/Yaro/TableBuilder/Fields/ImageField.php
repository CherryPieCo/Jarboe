<?php namespace Yaro\TableBuilder\Fields;


class ImageField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        $html = '<img src="'
              . $this->getAttribute('before_link')
              . $this->getValue($row)
              . $this->getAttribute('after_link')
              . '" />';
        return $html;
    } // end getListValue

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

}

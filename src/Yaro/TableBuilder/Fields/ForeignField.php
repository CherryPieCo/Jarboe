<?php namespace Yaro\TableBuilder\Fields;


class ForeignField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

    public function onSelectValue(&$db)
    {
        $internalSelect = $this->definition['db']['table'] .'.'. $this->getFieldName();

        $db->addSelect($internalSelect);

        $foreignTable = $this->getAttribute('foreign_table');
        $foreignKeyField = $foreignTable .'.'. $this->getAttribute('foreign_key_field');
        $db->join(
            $foreignTable, 
            $foreignKeyField, '=', $internalSelect
        );

        $db->addSelect($foreignTable .'.'. $this->getAttribute('foreign_value_field'));
    } // end onSelectValue

    public function getValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row);
            if ($res) {
                return $res;
            }
        }

        $fieldName = $this->getAttribute('foreign_value_field');
        $value = isset($row[$fieldName]) ? $row[$fieldName] : '';
        
        return $value;
    } // end getValue

}

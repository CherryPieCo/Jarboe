<?php 
namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ForeignField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $foreignTable = $this->getAttribute('foreign_table');
        $foreignValueField = $foreignTable .'.'. $this->getAttribute('foreign_value_field');

        $db->where($foreignValueField, 'LIKE', '%'.$value.'%');
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

        if ($this->getAttribute('is_select_all')) {
            $db->addSelect($foreignTable .'.*');
        } else {
            $db->addSelect($foreignTable .'.'. $this->getAttribute('foreign_value_field'));
        }
    } // end onSelectValue

    public function getValue($row, $postfix = '')
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

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        if ($this->getAttribute('is_readonly')) {
            return $this->getValue($row);
        }

        $table = View::make('admin::tb.input_foreign');
        $table->selected = $this->getValue($row);
        $table->name     = $this->getFieldName();
        $table->options  = $this->getForeignKeyOptions();

        return $table->render();
    } // end getEditInput

    protected function getForeignKeyOptions()
    {
        $res = DB::table($this->getAttribute('foreign_table'))
                     ->select($this->getAttribute('foreign_value_field'))
                     ->addSelect($this->getAttribute('foreign_key_field'))
                     ->get();

        $options = array();
        $foreignKey = $this->getAttribute('foreign_key_field');
        $foreignValue = $this->getAttribute('foreign_value_field');
        foreach ($res as $val) {
            $options[$val[$foreignKey]] = $val[$foreignValue];
        }

        return $options;
    } // end getForeignKeyOptions

}

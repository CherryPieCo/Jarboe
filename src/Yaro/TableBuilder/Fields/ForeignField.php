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
        $foreignTableName = $foreignTable;
        if ($this->getAttribute('alias')) {
            $foreignTable = $this->getAttribute('alias');
        }
		$foreignValueField = $foreignTable .'.'. $this->getAttribute('foreign_value_field');

        $db->where($foreignValueField, 'LIKE', '%'.$value.'%');
    } // end onSearchFilter

    public function onSelectValue(&$db)
    {
    	if ($this->hasCustomHandlerMethod('onAddSelectField')) {
            $res = $this->handler->onAddSelectField($this, $db);
            if ($res) {
                return $res;
            }
        }
		
        $internalSelect = $this->definition['db']['table'] .'.'. $this->getFieldName();

        $db->addSelect($internalSelect);

        $foreignTable = $this->getAttribute('foreign_table');
        $foreignTableName = $foreignTable;
        if ($this->getAttribute('alias')) {
            $foreignTableName .= ' as '. $this->getAttribute('alias');
            $foreignTable = $this->getAttribute('alias');
        }
        $foreignKeyField = $foreignTable .'.'. $this->getAttribute('foreign_key_field');
        
        $join = $this->getAttribute('is_null') ? 'leftJoin' : 'join';
        $db->$join(
            $foreignTableName, 
            $foreignKeyField, '=', $internalSelect
        );

        if ($this->getAttribute('is_select_all')) {
            $db->addSelect($foreignTable .'.*');
        } else {
            $fieldAlias = ' as '. $foreignTable.'_'.$this->getAttribute('foreign_value_field');
            $db->addSelect($foreignTable .'.'. $this->getAttribute('foreign_value_field') . $fieldAlias);
        }
    } // end onSelectValue

    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row, $postfix);
            if ($res) {
                return $res;
            }
        }

        $foreignTableName = $this->getAttribute('foreign_table');
        if ($this->getAttribute('alias')) {
            $foreignTableName = $this->getAttribute('alias');
        }
        $fieldName = $foreignTableName .'_'. $this->getAttribute('foreign_value_field');
        
        $value = isset($row[$fieldName]) ? $row[$fieldName] : '';
        
        if (!$value && $this->getAttribute('is_null')) {
            // FIXME:
            $value = '<i class="fa fa-minus"></i>';
        }

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

        $input = View::make('admin::tb.input_foreign');
        $input->selected = $this->getValue($row);
        $input->name     = $this->getFieldName();
        $input->options  = $this->getForeignKeyOptions();
        $input->is_null  = $this->getAttribute('is_null');
        $input->null_caption = $this->getAttribute('null_caption');

        return $input->render();
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

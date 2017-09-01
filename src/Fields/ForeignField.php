<?php

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Jarboe;


class ForeignField extends AbstractField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable
    
    protected function onAssets()
    {
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/select2/select2.min.js');
    } // end onAssets

        
    public function getExportValue($type, $row, $postfix = '')
    {
        $value = $this->getValue($row, $postfix);
        // FIXME:
        if ($value == '<i class="fa fa-minus"></i>') {
            $value = '';
        }
        
        // cuz double quotes is escaping by more double quotes in csv
        $escapedValue = preg_replace('~"~', '""', $value);
        
        return $escapedValue;
    } // end getExportValue
    
    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $type = $this->getAttribute('filter');

        $input = View::make('admin::tb.filter.'. $type);
        $input->name = $this->getFieldName();
        $input->selected = $filter;
        // FIXME:
        $input->value = $filter;
        $input->options = $this->getForeignKeyOptions();

        return $input->render();
    } // end getFilterInput

    public function onSearchFilter(&$db, $value)
    {
        $foreignTable = $this->getAttribute('foreign_table');
        if ($this->getAttribute('alias')) {
            $foreignTable = $this->getAttribute('alias');
        }
        $foreignValueField = $foreignTable .'.'. $this->getAttribute('foreign_value_field');
        
        // FIXME:
        if ($this->getAttribute('filter') == 'foreign') {
            $foreignValueField = $foreignTable .'.'. $this->getAttribute('foreign_key_field');
            $db->where($foreignValueField , $value);
            return;
        }

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

        $internalSelect = $this->definition->getDatabaseOption('table') .'.'. $this->getFieldName();

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

        $value = isset($row->$fieldName) ? $row->$fieldName : '';

        if (!$value && $this->getAttribute('is_null')) {
            // FIXME:
            $value = $this->getAttribute('null_caption', '<i class="fa fa-minus"></i>');
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

        $selectType = $this->getAttribute('select_type', 'simple');
        
        $input = View::make('admin::tb.input.foreign_'. $selectType);
        $input->selected = $this->getValue($row);
        $input->name     = $this->getFieldName();
        $input->options  = $this->getForeignKeyOptions();
        $input->is_null  = $this->getAttribute('is_null');
        $input->null_caption = $this->getAttribute('null_caption');
        $input->postfix = $row ? 'e' : 'c';

        return $input->render();
    } // end getEditInput
    
    protected function getForeignKeyOptions()
    {
        $db = DB::table($this->getAttribute('foreign_table'))
                     ->select($this->getAttribute('foreign_value_field'))
                     ->addSelect($this->getAttribute('foreign_key_field'));
                     
                     
        $additionalWheres = $this->getAttribute('additional_where');
        if ($additionalWheres) {
            foreach ($additionalWheres as $key => $opt) {
                $db->where($key, $opt['sign'], $opt['value']);
            }
        }
        $res = $db->get();

        $options = array();
        $foreignKey = $this->getAttribute('foreign_key_field');
        $foreignValue = $this->getAttribute('foreign_value_field');
        foreach ($res as $val) {
            $options[$val->$foreignKey] = $val->$foreignValue;
        }
        
        

        return $options;
    } // end getForeignKeyOptions

}

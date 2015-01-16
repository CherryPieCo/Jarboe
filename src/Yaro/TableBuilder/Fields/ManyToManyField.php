<?php 
namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ManyToManyField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $externalTable = $this->getAttribute('mtm_external_table');
    } // end onSearchFilter
    
    public function onPrepareRowValues(array $values, $id)
    {
        DB::table($this->getAttribute('mtm_table'))
          ->where($this->getAttribute('mtm_key_field'), $id)
          ->delete();
          
        $data = array();
        $values = array_filter($values);
        // HACK: in checkbox we have id as key of element, in select - as value
        $isInValueElement = ($this->getAttribute('show_type', 'checkbox') == 'select2');
        foreach ($values as $key => $val) {
            $externalID = $isInValueElement ? $val : $key;
            $data[] = array(
                $this->getAttribute('mtm_key_field')          => $id,
                $this->getAttribute('mtm_external_key_field') => $externalID
            );
        }
        
        if ($data) {
            DB::table($this->getAttribute('mtm_table'))->insert($data);
        }
    } // end onPrepareRowValues

    public function onSelectValue(&$db)
    {
        // HACK: we dont need this method to be called for many2many field
    } // end onSelectValue

    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row, $postfix);
            if ($res) {
                return $res;
            }
        }

        $fieldName = $this->getAttribute('foreign_value_field');
        $value = isset($row[$fieldName]) ? $row[$fieldName] : '';

        return $value;
    } // end getValue
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        return implode(', ', $this->getRelatedExternalFieldOptions($row));
    } // end getListValue

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $showType = $this->getAttribute('show_type', 'checkbox');
        $input = View::make('admin::tb.input_many2many_'. $showType);
        $input->selected = array();
        if ($row) {
            $input->selected = $this->getRelatedExternalFieldOptions($row);
        }
        
        $input->name    = $this->getFieldName();
        $input->divide  = $this->getAttribute('divide_columns', 2);
        $input->options = $this->doDivideOnParts(
            $this->getAllExternalFieldOptions(), 
            $this->getAttribute('divide_columns', 2)
        );

        return $input->render();
    } // end getEditInput
    
    private function doDivideOnParts($array, $segmentCount)
    {
        $dataCount = count($array);
        if ($dataCount === 0) {
            // HACK: when there is no many2many options 
            return array(array());
        }
        
        $segmentLimit = ceil($dataCount / $segmentCount);
        $outputArray  = array_chunk($array, $segmentLimit, true);
     
        return $outputArray;
    } // end doDivideOnParts

    protected function getRelatedExternalFieldOptions($row)
    {
        $keyField = $this->getAttribute('mtm_table') .'.'. $this->getAttribute('mtm_external_key_field');
        $valueField = $this->getAttribute('mtm_external_table') .'.'. $this->getAttribute('mtm_external_value_field');
        $externalTable = $this->getAttribute('mtm_external_table');
        $externalForeignKey = $externalTable .'.'. $this->getAttribute('mtm_external_foreign_key_field');
        
        $options = DB::table($this->getAttribute('mtm_table'))
                     ->select($keyField, $valueField)
                     ->join($externalTable, $keyField, '=', $externalForeignKey);
        
        $additionalWheres = $this->getAttribute('additional_where');
        if ($additionalWheres) {
            foreach ($additionalWheres as $key => $opt) {
                $options->where($key, $opt['sign'], $opt['value']);
            }
        }

        $options->where($this->getAttribute('mtm_key_field'), $row['id']);

        $res = $options->get();
        $options = array();
        foreach ($res as $opt) {
            $id = $opt[$this->getAttribute('mtm_external_key_field')];
            $value = $opt[$this->getAttribute('mtm_external_value_field')];
            
            $options[$id] = $value;
        }

        return $options;
    } // end getRelatedExternalFieldOptions
    
    protected function getAllExternalFieldOptions()
    {
        $valueField = $this->getAttribute('mtm_external_table') .'.'. $this->getAttribute('mtm_external_value_field');
        $externalTable = $this->getAttribute('mtm_external_table');
        $externalForeignKey = $externalTable .'.'. $this->getAttribute('mtm_external_foreign_key_field');
        
        $options = DB::table($externalTable)->select($externalForeignKey, $valueField);
        
        $additionalWheres = $this->getAttribute('additional_where');
        if ($additionalWheres) {
            foreach ($additionalWheres as $key => $opt) {
                $options->where($key, $opt['sign'], $opt['value']);
            }
        }
        
        $res = $options->get();
        $options = array();
        foreach ($res as $opt) {
            $id = $opt[$this->getAttribute('mtm_external_foreign_key_field')];
            $value = $opt[$this->getAttribute('mtm_external_value_field')];
            
            $options[$id] = $value;
        }

        return $options;
    } // end getAllExternalFieldOptions

}

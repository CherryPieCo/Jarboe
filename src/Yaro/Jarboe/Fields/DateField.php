<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class DateField extends AbstractField 
{

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        if ($this->getAttribute('is_range')) {
            if (!isset($value['from']) && !isset($value['to'])) {
                return;
            }
            
            $dateFrom = isset($value['from']) ? $this->getTimestamp($value['from']) : '28800';
            $dateTo = isset($value['to']) ? $this->getTimestamp($value['to']) : '2146939932';
            $db->whereBetween(
                $table .'.'. $this->getFieldName(), 
                array(
                    date('Y-m-d', $dateFrom), 
                    date('Y-m-d', $dateTo)
                )
            );
        } else {
            $db->where(
                $table .'.'. $this->getFieldName(), 
                date('Y-m-d', $this->getTimestamp($value))
            );
        }
    } // end onSearchFilter
    
    public function prepareQueryValue($value)
    {
        if (!$value) {
            if ($this->getAttribute('is_null')) {
                return null;
            }
        }

        return date('Y-m-d', $this->getTimestamp($value));
    } // end prepareQueryValue
    
    private function getTimestamp($date)
    {
        return strtotime(str_replace('/', '-', $date));
    } // end getTimestamp
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        if (!$this->getValue($row)) {
            return '';
        }
        
        $timestamp = $this->getTimestamp($this->getValue($row));
        
        // FIXME:
        return date('d/m/Y', $timestamp);
    } // end getListValue

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        // FIXME:
        $value = $this->getValue($row);
        $value = $value ? date('d/m/Y', $this->getTimestamp($value)) : '';

        $input = View::make('admin::tb.input_date');
        $input->value  = $value;
        $input->name   = $this->getFieldName();
        $input->months = $this->getAttribute('months');
        $input->prefix = $row ? 'e-' : 'c-';

        return $input->render();
    } // end getEditInput
    
    
    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }
        
        if ($this->getAttribute('is_range')) {
            return $this->getFilterRangeInput();
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $input = View::make('admin::tb.filter_date');
        $input->name = $this->getFieldName();
        $input->value = $filter;
        $input->months = $this->getAttribute('months');

        return $input->render();
    } // end getFilterInput
    
    private function getFilterRangeInput()
    {
        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, array());

        $input = View::make('admin::tb.filter_date_range');
        $input->name = $this->getFieldName();
        $input->valueFrom = isset($filter['from']) ? $filter['from'] : false;
        $input->valueTo = isset($filter['to']) ? $filter['to'] : false;
        $input->months = $this->getAttribute('months');

        return $input->render();
    } // end getFilterRangeInput
    
}

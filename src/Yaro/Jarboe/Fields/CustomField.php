<?php 

namespace Yaro\Jarboe\Fields;


class CustomField extends AbstractField 
{

    public function onSearchFilter(&$db, $value)
    {
        if ($this->hasCustomHandlerMethod('onSearchCustomFilter')) {
            $res = $this->handler->onSearchCustomFilter($this, $db, $value);
            if ($res) {
                return $res;
            }
        }
    } // end onSearchFilter
    
    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetCustomValue')) {
            $res = $this->handler->onGetCustomValue($this, $row, $postfix);
            if ($res) {
                return $res;
            }
        }
    } // end getValue
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetCustomListValue')) {
            $res = $this->handler->onGetCustomListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
    } // end getListValue

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetCustomEditInput')) {
            $res = $this->handler->onGetCustomEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
    } // end getEditInput
    
    public function onSelectValue(&$db)
    {
        if ($this->hasCustomHandlerMethod('onSelectCustomValue')) {
            $this->handler->onSelectCustomValue($db);
        }
    } // end onSelectValue

}

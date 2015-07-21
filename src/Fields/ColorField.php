<?php 

namespace Yaro\Jarboe\Fields;

use View;
use Jarboe;


class ColorField extends AbstractField 
{

    protected function onAssets()
    {
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/colorpicker/bootstrap-colorpicker.min.js');
    } // end onAssets
    
    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        return '<div style="height: 20px; background-color: '. $this->getValue($row) .';"></div>';
    } // end getListValue

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $input = View::make('admin::tb.input.color');
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->type  = $this->getAttribute('color_type', 'hex');
        $input->default = $this->getAttribute('default', '');

        return $input->render();
    } // end getEditInput
    
}

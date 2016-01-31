<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\URL;


class FileField extends AbstractField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
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
        
        // FIXME: move to template
        $src = URL::to($this->getValue($row));
        $html = '<a href="'. $src .'" target="_blank">'. $src .'</a>';
        
        return $html;
    } // end getListValue

}

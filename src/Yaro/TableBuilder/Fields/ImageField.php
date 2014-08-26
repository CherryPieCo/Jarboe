<?php 

namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;


class ImageField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        if ($this->getAttribute('is_multiple')) {
            return $this->getListMultiple($row);
        }
        
        return $this->getListSingle($row);
    } // end getListValue
    
    private function getListSingle($row)
    {
        if (!$this->getValue($row)) {
            return '';
        }
        
        $src = $this->getAttribute('before_link')
              . $this->getValue($row)
              . $this->getAttribute('after_link');
              
        $src = $this->getAttribute('is_remote') ? $src : URL::to($src);
        $html = '<img height="'.$this->getAttribute('img_height').'" src="'
              . $src
              . '" />';
        return $html;
    } // end getListSingle    
    
    private function getListMultiple($row)
    {
        $value = $this->getValue($row);
        
        $images = explode(',', $value);
        // FIXME: 
        return count($images);
    } // end getListMultiple

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        if (!$this->getAttribute('is_upload')) {
            return parent::getEditInput($row);
        }

        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.input_image_upload');
        $table->value = $this->getValue($row);
        $table->name  = $this->getFieldName();
        $table->caption = $this->getAttribute('caption');
        $table->is_multiple = $this->getAttribute('is_multiple');
        $table->delimiter   = $this->getAttribute('delimiter');

        return $table->render();
    } // end getEditInput

}

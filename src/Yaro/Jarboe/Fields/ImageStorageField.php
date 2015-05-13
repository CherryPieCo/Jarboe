<?php 

namespace Yaro\Jarboe\Fields;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;


class ImageStorageField extends AbstractField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        // TODO:
    } // end getListValue
    

    public function onSearchFilter(&$db, $value)
    {
        // FIXME: how? title
    } // end onSearchFilter
    
    public function getEditInput($row = array())
    {
        // FIXME: storage methods
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $input = View::make('admin::tb.storage.image.input');
        $input->value = $this->getValue($row);
        $input->row   = $row;
        $input->name  = $this->getFieldName();
        $input->caption = $this->getAttribute('caption');
        $input->placeholder = $this->getAttribute('placeholder');
        $input->type = $this->getRequiredAttribute('storage_type');

        if ($row) {
            $model = '\\' . \Config::get('jarboe::images.models.image');
            $input->entity = $model::find($this->getValue($row));
        }
        
        return $input->render();
    } // end getEditInput
    
    
    public function prepareQueryValue($value)
    {
        return $value;
    } // end prepareQueryValue

}

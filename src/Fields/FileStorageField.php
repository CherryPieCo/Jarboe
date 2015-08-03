<?php 

namespace Yaro\Jarboe\Fields;

use Image;
use View;
use URL;
use Jarboe;


class FileStorageField extends AbstractField 
{

    protected function onAssets()
    {
        Jarboe::addAsset('js', 'packages/yaro/jarboe/file_storage.js');
    } // end onAssets
    
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
        
        $input = View::make('admin::tb.storage.file.input');
        $input->value = $this->getValue($row);
        $input->row   = $row;
        $input->name  = $this->getFieldName();
        $input->caption = $this->getAttribute('caption');
        $input->placeholder = $this->getAttribute('placeholder');

        return $input->render();
    } // end getEditInput
    
    
    public function prepareQueryValue($value)
    {
        
        return $value;
    } // end prepareQueryValue

}

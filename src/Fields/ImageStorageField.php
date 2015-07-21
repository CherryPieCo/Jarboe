<?php 

namespace Yaro\Jarboe\Fields;

use Image;
use View;
use URL;
use Jarboe;


class ImageStorageField extends AbstractField 
{
    
    protected function onAssets()
    {
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/superbox/superbox.js');
        Jarboe::addAsset('js', 'packages/yaro/jarboe/superbox.js');
    } // end onAssets
    
    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        $html = '<span class="glyphicon glyphicon-minus"></span>';
        
        $type = $this->getRequiredAttribute('storage_type');
        $model = '\\' . config('jarboe.images.models.'. $type);
        $entity = $model::find($this->getValue($row));
        if ($entity) {
            if ($entity->isImage() && $entity->getSource()) {
                $html = '<img style="height: 90px;" src="'. cropp($entity->getSource())->fit(90) .'">';
            } elseif ($entity->isGallery()) {
                $html = $entity->title .' | '. $entity->created_at;
            } elseif ($entity->isTag()) {
                $html = $entity->title .' | '. $entity->created_at;
            }
        }
        
        return $html;
    } // end getListValue
    
    public function onSearchFilter(&$db, $value)
    {
        // TODO:
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
        
        $type = $this->getRequiredAttribute('storage_type');
        
        $input = View::make('admin::tb.storage.image.input');
        $input->type  = $type;
        $input->value = $this->getValue($row);
        $input->row   = $row;
        $input->name  = $this->getFieldName();
        $input->caption = $this->getAttribute('caption');
        $input->placeholder = $this->getAttribute('placeholder');

        if ($row) {
            $model = '\\' . config('jarboe.images.models.'. $type);
            $input->entity = $model::find($this->getValue($row));
        }
        
        return $input->render();
    } // end getEditInput
    
    public function prepareQueryValue($value)
    {
        return (!$value && $this->getAttribute('is_null')) ? null : $value;
    } // end prepareQueryValue

}

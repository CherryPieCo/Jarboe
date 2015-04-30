<?php

namespace Yaro\Jarboe\Helpers\Traits;


trait ImageStorage
{

    public function getStorageImagesFrom($field)
    {
        preg_match_all('~\[\|image::(\d+)\|\]~', $this->$field, $matches);
        
        if (!isset($matches[1]) || !$matches[1]) {
            return false;
        }
        
        $model = \Config::get('jarboe::images.models.image');
        return $model::whereIn('id', $matches[1])->get();
    } // end getStorageImagesFrom
    
    public function getStorageImage($field = 'image')
    {
        preg_match('~\[\|image::(\d+)\|\]~', $this->$field, $matches);
        
        if (!isset($matches[1]) || !$matches[1]) {
            return false;
        }
        
        $model = \Config::get('jarboe::images.models.image');
        return $model::find($matches[1]);
    } // end getStorageImage

}

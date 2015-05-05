<?php

namespace Yaro\Jarboe\Helpers\Traits;


trait ImageStorageTrait
{

    public function getStorageImage($field = 'image')
    {
        $model = \Config::get('jarboe::images.models.image');
        
        return $model::find(trim($this->$field));
    } // end getStorageImage

}

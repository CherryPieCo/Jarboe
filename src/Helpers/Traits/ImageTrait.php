<?php

namespace Yaro\Jarboe\Helpers\Traits;

use Yaro\Jarboe\Helpers\Image;


trait ImageTrait
{

    public function getImage($field = 'image')
    {
        return new Image($this->$field);
    } // end getImage
    
    public function getImages($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return [];
        }
        
        return array_map(function($image) {
            return new Image($image);
        }, $info);
    } // end getImages

    public function getFirstImage($field = 'images')
    {
        $images = json_decode($this->$field, true) ?: [];
        $image = !is_null(key($images)) ? $images[key($images)] : [];
        
        return new Image($image);
    } // end getFirstImage

    public function getImagesCount($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return 0;
        }

        return count($info);
    } // end getImagesCount

}

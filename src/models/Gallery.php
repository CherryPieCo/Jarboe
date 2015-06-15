<?php

namespace Yaro\Jarboe;


class Gallery extends AbstractImageStorage
{
    
    protected $table = 'j_galleries';

    
    public static function flushCache()
    {
        \Cache::tags('j_galleries')->flush();
    } // end flushCache
    
    public function images()
    {
        $model = \Config::get('jarboe::images.models.image');
        
        return $this->belongsToMany($model, 'j_galleries2images', 'id_gallery', 'id_image');
    } // end images
    
    public function tags()
    {
        $model = \Config::get('jarboe::images.models.tag');
        
        return $this->belongsToMany($model, 'j_galleries2tags', 'id_gallery', 'id_tag');
    } // end tags
    
    public function isGallery()
    {
        return true;
    } // end isGallery
    
}
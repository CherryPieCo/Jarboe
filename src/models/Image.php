<?php

namespace Yaro\Jarboe;


class Image extends \Eloquent
{
    
    protected $table = 'j_images';
    
    public function getInfo($values = false)
    {
        $info = $values ? : $this->info;
        return preg_replace('~"~', "~", $info);
    } // end getInfo
    
    public function tags()
    {
        $model = \Config::get('jarboe::images.models.tag');
        
        return $this->belongsToMany($model, 'j_images2tags', 'id_image', 'id_tag');
    } // end tags

}
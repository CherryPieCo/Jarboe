<?php

namespace Yaro\TableBuilder\Helpers\Traits;


trait ImageTrait 
{
    
    public function getImage($ident, $field = 'image')
    {
        $res = array();
        $info = json_decode($this->$field, true);
        if (!$info) {
            return $res;
        }
        
        $res['src']   = $info['sizes'][$ident];
        $res['alt']   = $info['alt'];
        $res['title'] = $info['title'];
        
        return $res;
    } // end getImage
    
    public function getImageAlt($field = 'image')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return '';
        }
        
        return $info['alt'];
    } // end getImageAlt    
    
    public function getImageTitle($field = 'image')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return '';
        }
        
        return $info['title'];
    } // end getImageTitle
        
    public function getImageSource($ident, $field = 'image', $default = '')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return $default;
        }
        
        return $info['sizes'][$ident];
    } // end getImageSource
    
    public function getFirstImage($ident, $field = 'images')
    {
        $res = array();
        $info = json_decode($this->$field, true);
        if (!$info) {
            return $res;
        }
        // HACK: cuz we need only first element
        $info = $info[0];
        
        $res['src']   = $info['sizes'][$ident];
        $res['alt']   = $info['alt'];
        $res['title'] = $info['title'];
        
        return $this->$ident;
    } // end getFirstImage
    
    public function getFirstImageAlt($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return '';
        }
        
        return $info[0]['alt'];
    } // end getFirstImageAlt    
    
    public function getFirstImageTitle($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return '';
        }
        
        return $info[0]['title'];
    } // end getFirstImageTitle
        
    public function getFirstImageSource($ident, $field = 'images', $default = '')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return $default;
        }
        
        return $info[0]['sizes'][$ident];
    } // end getFirstImageSource
        
    public function getImages($field = 'images')
    {
        $res = array();
        $info = json_decode($this->$field, true);
        if (!$info) {
            return $res;
        }
        
        return $info;
    } // end getImages
    
}

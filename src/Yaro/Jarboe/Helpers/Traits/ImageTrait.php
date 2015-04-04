<?php

namespace Yaro\Jarboe\Helpers\Traits;


trait ImageTrait
{

    public function getImage($ident = 'original', $field = 'image')
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

    public function getImageSource($ident = 'original', $field = 'image', $default = '')
    {
        $info = json_decode($this->$field, true);
        if (!$info || !isset($info['sizes'][$ident]) || empty($info['sizes'][$ident])) {
            return $default;
        }

        return $info['sizes'][$ident];
    } // end getImageSource

    public function getFirstImage($ident = 'original', $field = 'images')
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

        return $res;
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

    public function getFirstImageSource($ident = 'original', $field = 'images', $default = '')
    {
        $info = json_decode($this->$field, true);
        if (!$info || !isset($info[0]['sizes'][$ident]) || empty($info[0]['sizes'][$ident])) {
            return $default;
        }

        return $info[0]['sizes'][$ident];
    } // end getFirstImageSource

    public function getImages($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return array();
        }

        return $info;
    } // end getImages
    
    public function getImagesCount($field = 'images')
    {
        $info = json_decode($this->$field, true);
        if (!$info) {
            return 0;
        }

        return count($info);
    } // end getImagesCount

}

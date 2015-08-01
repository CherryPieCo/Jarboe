<?php

namespace Yaro\Jarboe\Models;

use Eloquent;


class AbstractImageStorage extends Eloquent
{
    
    public function isImage()
    {
        return false;
    } // end isImage
    
    public function isGallery()
    {
        return false;
    } // end isGallery
    
    public function isTag()
    {
        return false;
    } // end isTag
    
}
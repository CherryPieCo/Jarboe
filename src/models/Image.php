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

}
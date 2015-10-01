<?php

namespace Yaro\Jarboe\Helpers;

use Illuminate\Support\Facades\App;


class Image 
{
    
    private $image = [];
    
    
    public function __construct($json)
    {
        $image = is_array($json) ? $json : json_decode($json, true);
        
        $this->image = $image ?: [];
    } // end __construct
    
    public function src($ident = 'original', $default = null)
    {
        $source = array_get($this->image, 'sizes.'. $ident);
        
        return $source ?: $default;
    } // end src
    
    public function info($ident, $container = null, $default = null)
    {
        if (is_null($container)) {
            $container = App::getLocale();
        }
        
        $value = array_get($this->image, 'info.'. $container .'.'. $ident);
        
        return $value ?: $default;
    } // end info
    
}

<?php

namespace Yaro\Jarboe\Helpers;

use Intervention\Image\Facades\Image;


class Cropp
{
    
    private $source    = '';
    private $fileHash  = '';
    private $extension = '';
    private $methods   = array();
    
    private $isSkip = false;
    
    private function __construct($source)
    {
        $source = public_path(ltrim($source, '/'));
        if (!is_readable($source)) {
            $noImageSource = \Config::get('jarboe::cropp.no_image');
            if (!$noImageSource) {
                $this->isSkip = true;
                return;
            }
            $source = public_path(ltrim($noImageSource, '/'));
        }
        
        $this->fileHash = md5($source);
        
        preg_match('/\.[^\.]+$/i', $source, $matches);
        if (isset($matches[0])) {
            $this->extension = $matches[0];
        }
        $this->source = $source;
    } // end __construct
    
    public static function make($source)
    {
        return new Cropp($source);
    } // end make
    
    public function __call($name, $arguments)
    {
        $this->methods[] = compact('name', 'arguments');
        
        return $this;
    } // end __call 
    
    public function __toString()
    {
        if ($this->isSkip) {
            return '';
        }
        
        $methodsHash = md5(serialize($this->methods));
        $hash = md5($this->fileHash . $methodsHash);
        $source = 'storage/cropp/'. $hash . $this->extension;
        
        if (file_exists(public_path($source))) {
            return $source;
        }
        
        $image = Image::make($this->source);
        
        foreach ($this->methods as $method) {
            call_user_func_array(array($image, $method['name']), $method['arguments']);
        }
        
        $res = $image->save(public_path($source));
        if (!$res) {
            throw new RuntimeException('Do you have writeable [public/storage/cropp/] directory?');
        }
        
        return $source;
    } // end __toString

}
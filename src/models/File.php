<?php

namespace Yaro\Jarboe;


class File extends \Eloquent
{
    
    protected $table = 'j_files';
    
    public function get($ident, $localePostfix = false)
    {
        $postfix = $localePostfix ? '_'. \App::getLocale() : '';
        $ident = $ident . $postfix;
        
        $info = json_decode($this->info, true);
        
        if (!$info || !array_key_exists($ident, $info)) {
            return '';
        }
        
        return $info[$ident];
    } // end get
    
    public function getSize()
    {
        return $this->size;
    } // end getSize
    
    public function getExtension()
    {
        return $this->extension;
    } // end getExtension
    
    public function getMimeType()
    {
        return $this->mime;
    } // end getMimeType
    
}
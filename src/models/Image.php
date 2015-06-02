<?php

namespace Yaro\Jarboe;


class Image extends \Eloquent
{
    
    protected $table = 'j_images';
    
    public static function flushCache()
    {
        \Cache::tags('j_images')->flush();
    } // end flushCache
    
    public function scopePriority($query, $direction = 'asc')
    {
        return $query->orderBy('priority', $direction);
    } // end priority
    
    public function getInfo($values = false)
    {
        $info = $values ? : $this->info;
        return preg_replace('~"~', "~", $info);
    } // end getInfo
    
    public function getSource($ident = '')
    {
        $ident = $ident ? '_' . $ident : '';
        $source = 'source' . $ident;

        
        return $this->$source;
    } // end getSource
    
    public function tags()
    {
        $model = \Config::get('jarboe::images.models.tag');
        
        return $this->belongsToMany($model, 'j_images2tags', 'id_image', 'id_tag');
    } // end tags
    
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

}
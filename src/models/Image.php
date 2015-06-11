<?php

namespace Yaro\Jarboe;


class Image extends AbstractImageStorage
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
    
    public function scopeSearch($query)
    {
        $search = \Session::get('_jsearch_images', array());
        foreach ($search as $column => $value) {
            if (!$value) {
                continue;
            }
            
            if (is_array($value)) {
                $value['to']   = $value['to'] ? : '12/12/2222';
                $value['from'] = $value['from'] ? : '12/12/1971';
                
                // HACK: MariaDB date() hack for timestamp
                $from = date('Y-m-d H:i:s', strtotime(preg_replace('~/~', '-', $value['from'])));
                $to   = date('Y-m-d H:i:s', strtotime(preg_replace('~/~', '-', $value['to'])));
                
                $query->whereBetween($column, array($from, $to));
            } else {
                $query->where($column, 'like', '%'. $value .'%');
            }
        }
        
        return $query;
    } // end scopeSearch
    
    public function isImage()
    {
        return true;
    } // end isImage

}
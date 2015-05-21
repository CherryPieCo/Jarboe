<?php

namespace Yaro\Jarboe\Helpers\Traits;


trait ImageStorageTrait
{

    public function doImagesParse($value)
    {
        $model = \Config::get('jarboe::images.models.image');
        $images = \Cache::tags('images', 'jarboe')->get('images', function() use($model) {
            return $model::all(); 
        });
        
        preg_match_all('~<img[^>]+data-j_images_id="(\d+)"[^>]*>~', $value, $matches);
        list($html, $ids) = $matches;
        
        $patterns = array();
        $replacements = array();
        foreach ($ids as $index => $id) {
            $image = $food->filter(function($item) use($id) {
                return $item->id == $id;
            })->first();
            
            $patterns[] = '~'. preg_quote($html[$index]) .'~';
            $replacements[] = $image ? $this->fetchImage($image) : '';
        }
        preg_replace($patterns, $replacements, $value);
        
        return $value;
    } // end doImagesParse
    
    public function fetchImage($image)
    {
        $html = '<img class="j-image"';
        $info = json_encode($image->info, true) ? : array();
        foreach ($info as $key => $val) {
            $html .= ' data-'. $key .'="'. $val .'"';
        }
        $html .= '>';
        
        return $html;
    } // end fetchImage

}

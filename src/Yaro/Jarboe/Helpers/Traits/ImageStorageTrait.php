<?php

namespace Yaro\Jarboe\Helpers\Traits;


trait ImageStorageTrait
{

    public function doImagesParse($value)
    {
        $model = \Config::get('jarboe::images.models.image');
        $images = \Cache::tags('j_images', 'jarboe')->rememberForever('j_images', function() use($model) {
            return $model::all(); 
        });
        
        preg_match_all('~<img[^>]+data-j_images_id="(\d+)"[^>]*>~', $value, $matches);
        list($html, $ids) = $matches;
        
        $patterns = array();
        $replacements = array();
        foreach ($ids as $index => $id) {
            $image = $images->filter(function($item) use($id) {
                return $item->id == $id;
            })->first();

            $patterns[] = '~'. preg_quote($html[$index]) .'~';
            $replacements[] = $image ? $this->fetchImage($image) : '';
        }

        return preg_replace($patterns, $replacements, $value);
    } // end doImagesParse
    
    public function fetchImage($image)
    {
        $wysiwygSource = \Config::get('jarboe::images.wysiwyg_image_type');
        $html = '<img class="j-image" src="'. asset($image->$wysiwygSource) 
              . '" data-source="'. asset($image->source) .'"';

        $info = $image->info ? json_decode($image->info, true) : array();

        foreach ($info as $key => $val) {
            $html .= ' data-'. $key .'="'. $val .'"';
        }
        $html .= '>';

        return $html;
    } // end fetchImage

}
<?php

if (!function_exists('__'))
{
    function __($key, $namespace = 'messages', $locale = null)
    {
        /*
        $res = DB::table('translations')->get();
        $locale = $locale ? $locale : Lang::getlocale();
        
        $translations = array();
        foreach ($res as $item) {
            $translations[$item['locale']][$item['namespace']][$item['key']] = $item['value'];
        }
        // TODO: cache result
        
        if (isset($translations[$locale][$namespace][$key])) {
            return $translations[$locale][$namespace][$key];
        }
        
        return $key;
        */
        
        $locale = $locale ? $locale : Lang::getlocale();
        return Translate::get($key, $namespace, $locale);
    } // end __
}


if (!function_exists('dr'))
{
    function dr($array)
    {
        echo '<pre>';
        die(print_r($array));
    } // end dr
}
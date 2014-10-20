<?php

if (!function_exists('__'))
{
    function __()
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
        $args = func_get_args();
	    if (!isset($args[0])) {
	        return false;
	    }
	
	    $word = Yaro\TableBuilder\Helpers\Translate::get($args[0], \Lang::getlocale());
	    if (!$word) {
	        $word = $args[0];
	    }
	
	    $params = array_slice($args, 1);
	    if ($params) {
	        $word = vsprintf($word, $params);
	    }
	
        return $word;
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

if (!function_exists('cartesian'))
{
    function cartesian($arr, $isElementsDuplicated = false) 
    {
        $variant = array();
        $result  = array();
        $arrayCount = sizeof($arr);
        
            function recurseIt($arr, $variant, $level, $result, $arrayCount, $isElementsDuplicated) {
                $level++;
                if ($level < $arrayCount) {
                    foreach ($arr[$level] as $val) {
                        $variant[$level] = $val;
                        $result = recurseIt($arr, $variant, $level, $result, $arrayCount, $isElementsDuplicated);
                    }
                } else {
                    if (!$isElementsDuplicated) {
                        $result[] = $variant;
                    } else {
                        if (sizeof(array_flip(array_flip($variant))) == $arrayCount) {
                            $result[] = $variant;
                        }
                    }
                }        
                return $result;
            }
        
        return recurseIt($arr, $variant, -1, $result, $arrayCount, $isElementsDuplicated);
    } // end cartesian
}
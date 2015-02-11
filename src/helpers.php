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

        $word = Yaro\TableBuilder\Helpers\Translate::get($args[0], \App::getlocale());
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

        return cartesianRecurseIt($arr, $variant, -1, $result, $arrayCount, $isElementsDuplicated);
    } // end cartesian
}

if (!function_exists('cartesianRecurseIt'))
{
    function cartesianRecurseIt($arr, $variant, $level, $result, $arrayCount, $isElementsDuplicated)
    {
        $level++;
        if ($level < $arrayCount) {
            foreach ($arr[$level] as $val) {
                $variant[$level] = $val;
                $result = cartesianRecurseIt($arr, $variant, $level, $result, $arrayCount, $isElementsDuplicated);
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
    } // end cartesianRecurseIt
}

if (!function_exists('remove_bom'))
{
    function remove_bom($val)
    {
        if (substr($val, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
            $val = substr($val, 3);
        }
        return $val;
    } // end remove_bom
}

if (!function_exists('img'))
{
    function img($source, $options = array())
    {
        return GlideImage::setImagePath($source)->setConversionParameters($options);
    } // end img
}



<?php

namespace Yaro\Jarboe\Helpers;


class Registry
{

    private static $instance = null;
    private $registry = array();
    private $css = array();
    private $js = array();

    private function __construct() {} // end __construct

    private function __clone() {} // end __clone

    private static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    } // end getInstance
    
    private function getStatic($ident, $default = 'DEFAULT_VALUE_FOR_FALSE_AND_NULL_ETC_FALLBACK')
    {
        if (!$this->hasOffset($ident)) {
            if ($default !== 'DEFAULT_VALUE_FOR_FALSE_AND_NULL_ETC_FALLBACK') {
                return is_callable($default) ? $default() : $default;
            }
            return null;
        }
        return $this->registry[$ident];
    } // end get
    
    private function addStatic($ident, $value, $isForceReplace = false)
    {
        if (!$this->hasOffset($ident) || $isForceReplace) {
            $this->registry[$ident] = $value;
        }
    } // end add
    
    private function addCssStatic($value)
    {
        $this->css[] = '/'. ltrim($value, '/');
    } // end addCss
    
    private function addJsStatic($value)
    {
        $this->js[] = '/'. ltrim($value, '/');
    } // end addJs
    
    private function getJsStatic()
    {
        return $this->filter($this->js);
    } // end getJs
    
    private function getCssStatic()
    {
        return $this->filter($this->css);
    } // end getCss
    
    private function filter($array)
    {
        return array_unique(array_filter($array));
    } // end filter
    
    private function hasOffset($ident)
    {
        return array_key_exists($ident, $this->registry);
    } // end hasOffset

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        $method = $name.'Static';
        
        return call_user_func_array(array($instance, $method), $arguments);
    } // end __callStatic
    
}


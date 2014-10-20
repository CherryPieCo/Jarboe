<?php

namespace Yaro\TableBuilder\Helpers;


class Translate
{

    private static $instance = null;
    private $translates      = array();
    private $locales         = array();

    private function __construct($locales)
    {
        $this->locales    = $locales;
        $this->translates = $this->getAllStatic();
    } // end __construct

    protected function __clone()
    {
    } // end __clone

    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self(\Config::get('app.locales'));
        }

        return self::$instance;
    } // end getInstance

    public function getAllStatic()
    {
        if ($this->translates) {
            return $this->translates;
        }

        $cachedVal = \Cache::get('translations');
        if ($cachedVal) {
            return $cachedVal;
        }
        
        $all = \DB::table('translations')->get();
        
        $translations = array();
        foreach ($all as $item) {
            foreach ($this->locales as $locale) {
                $translations[$locale][$item['namespace']][$item['key']] = $item['value_'.$locale];
            }
        }
        
        \Cache::forever('translations', $translations);

        $this->translates = $translations;
        
        return $translations;
    } // end getAll
    
    protected function getStatic($ident, $locale, $namespace)
    {
        if (!$this->hasTranslate($ident, $locale, $namespace)) {
            return false;
        }
        return $this->translates[$locale][$namespace][$ident];
    } // end get
    
    protected function hasTranslate($ident, $locale, $namespace)
    {
        return isset($this->translates[$locale][$namespace][$ident]);
    } // end hasTranslate

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        
        $method = $name.'Static';
        if (!$arguments) {
            return $instance->$method();
        }
        
        $locale    = isset($arguments[1]) ? $arguments[1] : Lang::getlocale();
        $namespace = isset($arguments[2]) ? $arguments[2] : 'messages';
        return $instance->$method($arguments[0], $locale, $namespace);
    } // end __callStatic
    
}
<?php

namespace Yaro\TableBuilder\Helpers;


class Settings
{

    private static $instance = null;
    private $settings = array();

    private function __construct()
    {
        $this->settings = $this->getAllStatic();
    } // end __construct

    protected function __clone()
    {
    } // end __clone

    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    } // end getInstance

    public function getAllStatic()
    {
        if ($this->settings) {
            return $this->settings;
        }

        $cachedVal = \Cache::get('settings');
        if ($cachedVal) {
            return $cachedVal;
        }
        
        $all = \DB::table('settings')->get();
        $settings = array();
        array_walk($all, function($val) use(&$settings) {
            $settings[$val['name']] = $val['value'];
        });
        
        \Cache::forever('settings', $settings);

        $this->settings = $settings;
        
        return $settings;
    } // end getAll
    
    protected function getStatic($ident)
    {
        if (!$this->hasSetting($ident)) {
            throw new \RuntimeException("There is no setting for [{$ident}].");
        }
        return $this->settings[$ident];
    } // end get
    
    protected function getChunksStatic($ident, $delimiter = ',')
    {
        if (!$this->hasSetting($ident)) {
            throw new \RuntimeException("There is no setting for [{$ident}].");
        }
        $result = array_filter(explode($delimiter, $this->settings[$ident]));
        
        return array_map('trim', $result);
    } // end getChunks
    
    protected function getFirstChunkStatic($ident, $delimiter = ',')
    {
        if (!$this->hasSetting($ident)) {
            throw new \RuntimeException("There is no setting for [{$ident}].");
        }
        $chunks = array_filter(explode($delimiter, $this->settings[$ident]));
        
        return trim($chunks[0]);
    } // end getFirstChunk
    
    protected function hasSetting($ident)
    {
        return isset($this->settings[$ident]);
    } // end hasSetting
    
    protected function hasStatic($ident)
    {
        return array_key_exists($ident, $this->settings);
    } // end hasStatic

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        
        $method = $name.'Static';
        if (!$arguments) {
            return $instance->$method();
        }
        
        if (count($arguments) > 1) {
            return $instance->$method($arguments[0], $arguments[1]);
        }
        return $instance->$method($arguments[0]);
    } // end __callStatic
}
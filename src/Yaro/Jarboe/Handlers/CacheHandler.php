<?php 

namespace Yaro\Jarboe\Handlers;

use Yaro\Jarboe\JarboeController;
use Illuminate\Support\Facades\Cache;


class CacheHandler 
{

    protected $controller;


    public function __construct(JarboeController $controller)
    {
        $this->controller = $controller;
    } // end __construct
    
    public function flush()
    {
        $this->onKeysFlush();
        $this->onTagsFlush();
    } // end flush
    
    public function onKeysFlush()
    {
        $keys = $this->controller->getDefinitionOption('cache.keys', array());
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    } // end onKeysFlush
    
    public function onTagsFlush()
    {
        $tags = $this->controller->getDefinitionOption('cache.tags', array());
        foreach ($tags as $tag) {
            Cache::tags($tag)->flush();
        }
    } // end onTagsFlush

}

<?php 

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Helpers\URLify;
use Yaro\TableBuilder\NavigationMenu;
use Yaro\TableBuilder\TableBuilderValidationException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;


class TableBuilder {

    protected $controller;
    protected $default;

    protected function onInit($options)
    {
        $this->controller = new TableBuilderController($options);

        $this->default = array(
            'pagination' => Config::get('view.pagination'),
            'fetch' => Config::get('database.fetch')
        );
        Config::set('view.pagination', 'admin::tb.pagination');
        Config::set('database.fetch', \PDO::FETCH_ASSOC);
    } // end onInit

    protected function onFinish()
    {
        Config::set('view.pagination', $this->default['pagination']);
        Config::set('database.fetch', $this->default['fetch']);
    } // end onFinish

    public function create($options)
    {
        $this->onInit($options);
        DB::beginTransaction();
        
        try {
            $result = $this->controller->handle();
        } catch (TableBuilderValidationException $e) {
            DB::rollback();
            
            $data = array(
                'status' => false,
                'errors' => explode('|', $e->getMessage())
            );
            return Response::json($data);
        }
        
        DB::commit();
        $this->onFinish();

        return $result;
    } // end create
    
    public function fetchNavigation()
    {
        $menu = new NavigationMenu();
        return $menu->fetch();
    } // end fetchNavigation
    
    public function checkNavigationPermissions()
    {   
        $menu = new NavigationMenu();
        $menu->checkPermissions();
    } // end checkNavigationPermissions
    
    public function urlify($string)
    {   
        return URLify::filter($string);
    } // end urlify
    
    public function translate($text, $language, $isHtml = false, $options = 0)
    {
        $key = Config::get('table-builder::admin.yandex_api_translation_key');
        if (!$key) {
            throw new \RuntimeException('Yandex api key for translations is not set');
        }
        
        $translator = new Translator($key);
        $translation = $translator->translate($text, $language, $isHtml, $options);
        
        // FIXME: 
        return $translation->__toString();
    } // end translate

}


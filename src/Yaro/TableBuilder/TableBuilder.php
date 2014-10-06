<?php 

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Helpers\URLify;
use Yaro\TableBuilder\NavigationMenu;
use Yaro\TableBuilder\CatalogController;
use Yaro\TableBuilder\Exceptions\TableBuilderValidationException;
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
    
    public function catalog($name, $options = array())
    {
        $model = ucfirst(camel_case($name));
        if (!class_exists($model)) {
            throw new \RuntimeException('Model "'. $model .'" is not defined');
        }
        
        $controller = new CatalogController($model, $options);
        
        return $controller->handle();
    } // end catalog
    
    public static function geo($ip = false)
    {
        if (!$ip) {
            $ip = \Request::getClientIp();
        }
        
        $info = \DB::table('ip_geo_locations')->where('ip', $ip)->first();
        if ($info) {
            unset($info['id']);
            return $info;
        }
        
        $url = 'http://geoip.elib.ru/cgi-bin/getdata.pl?ip=';
        $xmlInfo = file_get_contents($url . $ip);
        // easy-breezy lol
        $xml  = simplexml_load_string($xmlInfo);
        $json = json_encode($xml);
        
        $info = json_decode($json, true);
        
        $data = array(
            'ip'        => $ip,
            'town'      => $info['GeoAddr']['Town'],
            'latitude'  => $info['GeoAddr']['Lat'],
            'longitude' => $info['GeoAddr']['Lon'],
        );
        \DB::table('ip_geo_locations')->insert($data);
        
        return $data;
    } // end geo

}


<?php

namespace Yaro\Jarboe\Helpers;


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

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self(\Config::get('jarboe::translate.locales'));
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
        if ($this->hasTranslate($ident, $locale, $namespace)) {
            return $this->translates[$locale][$namespace][$ident];
        }
        
        $translateFrom = \Config::get('jarboe::translate.auto_translate_from');
        $adminUriTemplate = ltrim(\Config::get('jarboe::admin.uri') .'/*', '/');
        $adminDashboardUriTemplate = ltrim(\Config::get('jarboe::admin.uri'), '/');
        if (\Request::is($adminUriTemplate) || \Request::is($adminDashboardUriTemplate)) {
            $translateFrom = 'ru';
        }
        
        if ($this->isAutoTranslate($locale)) {
            // HACK: ua to uk for yandex translate api
            $yandexTranslateFrom = $translateFrom == 'ua' ? 'uk' : $translateFrom;
            $yandexTranslateTo = $locale;
            if (\Request::is($adminUriTemplate) || \Request::is($adminDashboardUriTemplate)) {
                $yandexTranslateTo = $yandexTranslateTo == 'ua' ? 'uk' : $yandexTranslateTo;
            }
            // HACK: for admin-panel translates
            $language = $yandexTranslateFrom .'-'. $yandexTranslateTo;
            
            $res = \Jarboe::translate($ident, $language);

            $id = \DB::table('translations')->where('key', $ident)->where('namespace', $namespace)->pluck('id');
            if ($id) {
                \DB::table('translations')->where('id', $id)->update(array(
                    'value_'. $translateFrom => $ident,
                    'value_'. $locale        => $res,
                ));
            } else {
                \DB::table('translations')->insert(array(
                    'namespace' => $namespace,
                    'key'       => $ident,
                    'value_'. $translateFrom => $ident,
                    'value_'. $locale        => $res,
                ));
            }
            
            \Cache::forget('translations');

            return $res;
        }

        // FIXME: possible bad logic
        $id = \DB::table('translations')->where('key', $ident)->where('namespace', $namespace)->pluck('id');
        if (!$id) {
            \DB::table('translations')->insert(array(
                'namespace' => $namespace,
                'key'       => $ident,
                'value_'. $translateFrom => $ident
            ));
            \Cache::forget('translations');
        }
        
        return false;
    } // end get

    private function isAutotranslate($locale)
    {
        $isAutotranslate = \Config::get('jarboe::translate.is_auto_translate');

        return $isAutotranslate; //  && (\Config::get('jarboe::translate.auto_translate_from') != $locale)
    } // end

    protected function hasTranslate($ident, $locale, $namespace)
    {
        return isset($this->translates[$locale][$namespace][$ident]) && !empty($this->translates[$locale][$namespace][$ident]);
    } // end hasTranslate

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();

        $method = $name.'Static';
        if (!$arguments) {
            return $instance->$method();
        }

        $locale    = isset($arguments[1]) ? $arguments[1] : \App::getLocale();
        $namespace = isset($arguments[2]) ? $arguments[2] : 'messages';
        return $instance->$method($arguments[0], $locale, $namespace);
    } // end __callStatic

}
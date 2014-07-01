<?php namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;


class TableBuilder {

    protected $controller;
    protected $default;

    protected function onInit($options)
    {
        $this->setupViewsPath();
        $this->controller = new TableBuilderController($options);

        $this->default = array(
            'pagination' => Config::get('view.pagination')
        );
        Config::set('view.pagination', 'tb::pagination');
    } // end onInit

    protected function onFinish()
    {
        Config::set('view.pagination', $this->default['pagination']);
    } // end onFinish

    protected function setupViewsPath()
    {
        View::addNamespace('tb', __DIR__.'../../../views');
    } // end setupViewsPath

    public function create($options)
    {
        $this->onInit($options);
        $result = $this->controller->handle();
        $this->onFinish();

        return $result;
    } // end create

}

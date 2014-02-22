<?php namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\Config;


class TableBuilder {

    protected $controller;
    protected $default;

    protected function onInit($options)
    {
        $this->controller = new TableBuilderController($options);

        $this->default = array(
            'pagination' => Config::get('view.pagination')
        );
        Config::set('view.pagination', $this->controller->getOption('tpl_path').'/pagination');
    } // end onInit

    protected function onFinish()
    {
        Config::set('view.pagination', $this->default['pagination']);
    } // end onFinish

    public function create($options)
    {
        $this->onInit($options);
        $result = $this->controller->handle();
        $this->onFinish();

        return $result;
    } // end create

}

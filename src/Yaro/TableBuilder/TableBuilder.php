<?php namespace Yaro\TableBuilder;

use Illuminate\Support\Facades\Config;


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
        Config::set('view.pagination', $this->controller->getOption('tpl_path').'/pagination');
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
        $result = $this->controller->handle();
        $this->onFinish();

        return $result;
    } // end create

}


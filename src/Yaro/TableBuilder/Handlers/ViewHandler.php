<?php namespace Yaro\TableBuilder\Handlers;

use Illuminate\Support\Facades\View;


class ViewHandler {

    protected $defPath;


    public function __construct()
    {
        $this->defPath = app_path() . '/views/table_definitions/';
    } // end __construct

    public function create($table)
    {
        $definition = $this->getTableDefinition($table);

        return $this->formTable($definition);
    } // end create

    protected function getTableDefinition($table)
    {
        $path = $this->defPath . $table . '.json';

        if (!file_exists($path)) {
            throw new \RuntimeException("Definition [{$path}] does not exist.");
        }

        $jsonDef = file_get_contents($path);

        $definition = json_decode($jsonDef, true);
        if (!$definition) {
            throw new \RuntimeException("Error in table definition [{$path}].");
        }

        return $definition;
    } // end getTableDefinition

    protected function formTable($definition)
    {
        $dir = 'table_templates';

        // $thead = View::make($dir .'.thead');
        // $tbody = View::make($dir .'.tbody');
        $table = View::make($dir .'.table');
        $table->def = $definition;

        return $table;
    } // end formTable
}

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

    public function getTableDefinition($table)
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

        $definition['is_searchable'] = $this->_isSearchable($definition);
        $this->_prepareFields($definition['fields']);

        return $definition;
    } // end getTableDefinition

    private function _prepareFields(&$fields)
    {
        foreach ($fields as &$field) {
            $field['fast-edit'] = isset($field['fast-edit']) && $field['fast-edit'];
        }
    } // end _prepareFields

    private function _isSearchable($definition)
    {
        $isSearchable = false;

        foreach ($definition['fields'] as $field) {
            if (isset($field['filter'])) {
                $isSearchable = true;
                break;
            }
        }

        return $isSearchable;
    } // end _isSearchable

    protected function formTable($definition)
    {
        $dir = 'table_templates';

        // $thead = View::make($dir .'.thead');
        // $tbody = View::make($dir .'.tbody');
        $table = View::make($dir .'.table');
        $table->def  = $definition;
        $table->rows = (new QueryHandler($definition))->getRows();

        return $table;
    } // end formTable
}

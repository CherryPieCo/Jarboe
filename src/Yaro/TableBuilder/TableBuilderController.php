<?php namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Handlers\ViewHandler;
use Yaro\TableBuilder\Handlers\RequestHandler;
use Yaro\TableBuilder\Handlers\QueryHandler;


class TableBuilderController {

    protected $options;
    protected $definition;

    public $view;
    public $request;
    public $query;

    public function __construct($options)
    {
        $this->options = $this->prepareOptions($options);
        $this->definition = $this->getTableDefinition($options['def_name']);

        $this->view    = new ViewHandler($this);
        $this->request = new RequestHandler($this);
        $this->query   = new QueryHandler($this);
    } // end __construct

    protected function prepareOptions($opt)
    {
        $options = $opt;
        $options['def_path'] = app_path(). $opt['def_path'];

        return $options;
    } // end prepareOptions

    public function getOption($ident)
    {
        if (isset($this->options[$ident])) {
            return $this->options[$ident];
        }

        throw new \RuntimeException("Undefined option [{$ident}].");
    } // end getOption

    public function getDefinition()
    {
        return $this->definition;
    } // end getDefinition

    protected function getTableDefinition($table)
    {
        $path = $this->getOption('def_path'). $table .'.json';

        if (!file_exists($path)) {
            throw new \RuntimeException("Definition \n[{$path}]\n does not exist.");
        }

        $jsonDef = file_get_contents($path);
        $definition = json_decode($jsonDef, true);
        if (!$definition) {
            $error = json_last_error();
            throw new \RuntimeException("Error in table definition \n[{$path}]:\n #{$error}.");
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

}

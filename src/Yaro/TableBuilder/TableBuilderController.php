<?php namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Handlers\ViewHandler;
use Yaro\TableBuilder\Handlers\RequestHandler;
use Yaro\TableBuilder\Handlers\QueryHandler;


class TableBuilderController {

    protected $options;
    protected $definition;

    protected $fields;

    public $view;
    public $request;
    public $query;

    public function __construct($options)
    {
        $this->options = $this->getPreparedOptions($options);
        $this->definition = $this->getTableDefinition($this->getOption('def_name'));
        $this->fields = $this->loadFields();

        $this->view    = new ViewHandler($this);
        $this->request = new RequestHandler($this);
        $this->query   = new QueryHandler($this);
    } // end __construct

    protected function getPreparedOptions($opt)
    {
        // TODO:
        $options = $opt;
        $options['def_path'] = app_path(). $opt['def_path'];

        return $options;
    } // end getPreparedOptions

    public function getField($ident)
    {
        if (isset($this->fields[$ident])) {
            return $this->fields[$ident];
        }

        throw new \RuntimeException("Field [{$ident}] does not exist for current scheme.");
    } // end getField

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

    protected function loadFields()
    {
        $definition = $this->getDefinition();

        $fields = array();
        foreach ($definition['fields'] as $name => $info) {
            $fields[$name] = $this->createFieldInstance($name, $info);
        }

        return $fields;
    } // end loadFields

    protected function createFieldInstance($name, $info)
    {
        $className = 'Yaro\\TableBuilder\\Fields\\'. ucfirst($info['type']) ."Field";

        return new $className($name, $info, $this->options);
    } // end createFieldInstance

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

        return $definition;
    } // end getTableDefinition

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

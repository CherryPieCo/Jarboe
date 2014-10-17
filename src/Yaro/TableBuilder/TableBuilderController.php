<?php 

namespace Yaro\TableBuilder;

use Yaro\TableBuilder\Handlers\ViewHandler;
use Yaro\TableBuilder\Handlers\RequestHandler;
use Yaro\TableBuilder\Handlers\QueryHandler;
use Yaro\TableBuilder\Handlers\ActionsHandler;
use Yaro\TableBuilder\Handlers\ExportHandler;
use Illuminate\Support\Facades\Session;


class TableBuilderController {

    protected $options;
    protected $definition;

    protected $handler;
    protected $fields;

    public $view;
    public $request;
    public $query;
    public $actions;
    public $export;

    protected $allowedIds;

    public function __construct($options)
    {
        $this->options = $options; //$this->getPreparedOptions($options);
        $this->definition = $this->getTableDefinition($this->getOption('def_name'));
        $this->doPrepareDefinition();

        $this->handler = $this->createCustomHandlerInstance();
        $this->fields  = $this->loadFields();

        $this->actions = new ActionsHandler($this->definition['actions'], $this);
        $this->export  = new ExportHandler($this->definition['export'], $this);
        $this->query   = new QueryHandler($this);
        $this->allowedIds = $this->query->getTableAllowedIds();
        $this->view    = new ViewHandler($this);
        $this->request = new RequestHandler($this);
    } // end __construct
    
    private function doPrepareDefinition()
    {
        if (!isset($this->definition['export'])) {
            $this->definition['export'] = array();
        }
    } // end doPrepareDefinition

    public function handle()
    {
        if ($this->hasCustomHandlerMethod('handle')) {
            $res = $this->getCustomHandler()->handle();
            if ($res) {
                return $res;
            }
        }

        return $this->request->handle();
    } // end handle

    public function isAllowedID($id)
    {
        return in_array($id, $this->allowedIds);
    } // end isAllowedID
    
    protected function getPreparedOptions($opt)
    {
        // TODO:
        $options = $opt;
        $options['def_path'] = app_path(). $opt['def_path'];

        return $options;
    } // end getPreparedOptions

    protected function createCustomHandlerInstance()
    {
        if (isset($this->definition['options']['handler'])) {
            $handler = '\\'. $this->definition['options']['handler'];
            return new $handler($this);
        }

        return false;
    } // end createCustomHandlerInstance

    public function hasCustomHandlerMethod($methodName)
    {
        return $this->getCustomHandler() && method_exists($this->getCustomHandler(), $methodName);
    } // end hasCustomHandlerMethod

    public function &getCustomHandler()
    {
        return $this->handler;
    } // end getCustomHandler

    public function getField($ident)
    {
        if (isset($this->fields[$ident])) {
            return $this->fields[$ident];
        }

        throw new \RuntimeException("Field [{$ident}] does not exist for current scheme.");
    } // end getField

    public function getFields()
    {
        return $this->fields;
    } // end getFields

    public function getOption($ident)
    {
        if (isset($this->options[$ident])) {
            return $this->options[$ident];
        }

        throw new \RuntimeException("Undefined option [{$ident}].");
    } // end getOption
    
    public function getAdditionalOptions()
    {
        if (isset($this->options['additional'])) {
            return $this->options['additional'];
        }
        
        return array();
    } // end getAdditionalOptions

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
        $className = 'Yaro\\TableBuilder\\Fields\\'. ucfirst(camel_case($info['type'])) ."Field";

        return new $className(
            $name, 
            $info, 
            $this->options, 
            $this->getDefinition(), 
            $this->handler
        );
    } // end createFieldInstance

    protected function getTableDefinition($table)
    {
        $path = app_path() .'/tb-definitions/'. $table .'.php';

        if (!file_exists($path)) {
            throw new \RuntimeException("Definition \n[{$path}]\n does not exist.");
        }

        $options = $this->getAdditionalOptions();
        $definition = require($path);
        if (!$definition) {
            throw new \RuntimeException("Empty definition?");
        }

        $definition['is_searchable'] = $this->_isSearchable($definition);
        $definition['options']['admin_uri'] = \Config::get('table-builder::admin.uri');

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

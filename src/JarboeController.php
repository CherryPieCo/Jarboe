<?php 

namespace Yaro\Jarboe;

use Session;
use Request;
use Yaro\Jarboe\Handlers\ViewHandler;
use Yaro\Jarboe\Handlers\CacheHandler;
use Yaro\Jarboe\Handlers\RequestHandler;
use Yaro\Jarboe\Handlers\QueryHandler;
use Yaro\Jarboe\Handlers\ActionsHandler;
use Yaro\Jarboe\Handlers\ExportHandler;
use Yaro\Jarboe\Handlers\ImportHandler;
use Yaro\Jarboe\Handlers\CustomClosureHandler;
use Yaro\Jarboe\Storage\Image as ImageStorage;
use Yaro\Jarboe\Storage\File  as FileStorage;


class JarboeController 
{


    protected $options;
    protected $definition;

    protected $handler;
    protected $callbacks;
    protected $fields;
    protected $patterns = array();

    public $view;
    public $request;
    public $query;
    public $cache;
    public $actions;
    public $export;
    public $import;
    public $imageStorage;
    public $fileStorage;

    protected $allowedIds;

    public function __construct($options)
    {
        $this->options = $options; //$this->getPreparedOptions($options);
        $this->definition = $this->getTableDefinition($this->getOption('def_name'));
        $this->doPrepareDefinition();

        $this->handler = $this->createCustomHandlerInstance();
        if (isset($this->definition['callbacks'])) {
            $this->callbacks = new CustomClosureHandler($this->definition['callbacks'], $this);
        }
        $this->fields  = $this->loadFields();

        $this->actions      = new ActionsHandler($this->definition['actions'], $this);
        $this->export       = new ExportHandler($this->definition['export'], $this);
        $this->import       = new ImportHandler($this->definition['import'], $this);
        $this->query        = new QueryHandler($this);
        $this->view         = new ViewHandler($this);
        $this->request      = new RequestHandler($this);
        $this->cache        = new CacheHandler($this);
        $this->imageStorage = new ImageStorage($this);
        $this->fileStorage  = new FileStorage($this);
        
        $this->allowedIds = $this->query->getTableAllowedIds();
    } // end __construct
    
    private function doPrepareDefinition()
    {
        if (!isset($this->definition['export'])) {
            $this->definition['export'] = array();
        }
        if (!isset($this->definition['import'])) {
            $this->definition['import'] = array();
        }
        
        if (!isset($this->definition['db']['pagination']['uri'])) {
            $this->definition['db']['pagination']['uri'] = $this->options['url'];
        }
        
        //
        if (!isset($this->definition['options']['action_url'])) {
            $this->definition['options']['action_url'] = '/'. Request::path();
            // for structure current node resolver
            $requestValues = Request::only('node');
            if ($requestValues['node']) {
                $this->definition['options']['action_url'] .'?node='. $requestValues['node'];
            }
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
        return $this->getCustomHandler() && is_callable(array($this->getCustomHandler(), $methodName));
    } // end hasCustomHandlerMethod
    
    public function isSetDefinitionCallback($methodName)
    {
        //
    } // end isSetDefinitionCallback

    public function getCustomHandler()
    {
        return $this->handler ? : $this->callbacks;
    } // end getCustomHandler

    public function getField($ident)
    {
        if (isset($this->fields[$ident])) {
            return $this->fields[$ident];
        // FIXME:
        } else if (isset($this->patterns[$ident])) {
            return $this->patterns[$ident];
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
    
    public function getDefinitionOption($ident, $default = null)
    {
        $value = array_get($this->getDefinition(), $ident);
        if (!$value && !is_null($default)) {
            return $default;
        }
        
        return $value;
    } // end getDefinitionOption

    protected function loadFields()
    {
        $definition = $this->getDefinition();

        $fields = array();
        foreach ($definition['fields'] as $name => $info) {
            if ($this->isPatternField($name)) {
                $this->patterns[$name] = $this->createPatternInstance($name, $info);
            } else {
                $fields[$name] = $this->createFieldInstance($name, $info);
            }
        }

        return $fields;
    } // end loadFields
    
    public function getPatterns()
    {
        return $this->patterns;
    } // end getPatterns
    
    public function isPatternField($name)
    {
        return preg_match('~^pattern\.~', $name);
    } // end isPatternField

    protected function createPatternInstance($name, $info)
    {
        return new Fields\PatternField(
            $name, 
            $info, 
            $this->options, 
            $this->getDefinition(), 
            $this->getCustomHandler()
        );
    } // end createPatternInstance
    
    protected function createFieldInstance($name, $info)
    {
        $className = 'Yaro\\Jarboe\\Fields\\'. ucfirst(camel_case($info['type'])) ."Field";

        return new $className(
            $name, 
            $info, 
            $this->options, 
            $this->getDefinition(), 
            $this->getCustomHandler()
        );
    } // end createFieldInstance

    protected function getTableDefinition($table)
    {
        $table = preg_replace('~\.~', '/', $table);
        $path = base_path('resources/definitions/'. $table .'.php');

        if (!file_exists($path)) {
            throw new \RuntimeException("Definition \n[{$path}]\n does not exist.");
        }

        $options = $this->getAdditionalOptions();
        $definition = require($path);
        if (!$definition) {
            throw new \RuntimeException("Empty definition?");
        }

        $definition['is_searchable'] = $this->_isSearchable($definition);
        $definition['options']['admin_uri'] = config('jarboe.admin.uri');

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

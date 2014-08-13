<?php namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


abstract class AbstractField {

    protected $fieldName;
    protected $attributes;
    protected $options;
    protected $definition;

    protected $handler;


    public function __construct($fieldName, $attributes, $options, $definition, &$handler)
    {
       $this->attributes = $this->_prepareAttributes($attributes);
       $this->options    = $options;
       $this->definition = $definition;
       $this->fieldName  = $fieldName;

       $this->handler = &$handler;
    } // end __construct

    public function getFieldName()
    {
        return $this->fieldName;
    } // end getFieldName

    private function _prepareAttributes($attributes)
    {
        // TODO:
        $attributes['fast-edit'] = isset($attributes['fast-edit']) && $attributes['fast-edit'];
        $attributes['filter'] = isset($attributes['filter']) ? $attributes['filter'] : false;
        $attributes['hide'] = isset($attributes['hide']) ? $attributes['hide'] : false;
        $attributes['is_null'] = isset($attributes['is_null']) ? $attributes['is_null'] : false;

        return $attributes;
    } // end _prepareAttributes

    protected function getOption($ident)
    {
        return $this->options[$ident];
    } // end getOption

    public function getAttribute($ident)
    {
        return isset($this->attributes[$ident]) ? $this->attributes[$ident] : false;
    } // end getAttribute
    
    public function isHidden()
    {
        return $this->getAttribute('hide');
    } // end isHidden

    public function getValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row);
            if ($res) {
                return $res;
            }
        }

        $value = isset($row[$this->getFieldName()]) ? $row[$this->getFieldName()] : '';
        return $value;
    } // end getValue

    public function getListValue($row)
    {
        return $this->getValue($row);
    } // end getListValue

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $type = $this->getAttribute('type');
        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.input_'. $type);
        $table->value = $this->getValue($row);
        $table->name  = $this->getFieldName();

        return $table->render();
    } // end getEditInput

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $type = $this->getAttribute('filter');
        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.filter_'. $type);
        $table->name = $this->getFieldName();
        $table->value = $filter;

        return $table->render();
    } // end getFilterInput

    protected function hasCustomHandlerMethod($methodName)
    {
        return $this->handler && method_exists($this->handler, $methodName);
    } // end hasCustomHandlerMethod

    public function prepareQueryValue($value)
    {
        if (!$value) {
            if ($this->getAttribute('is_null')) {
                return null;
            }
        }

        return $value;
    } // end prepareQueryValue

    public function onSelectValue(&$db)
    {
        $db->addSelect($this->definition['db']['table'] .'.'. $this->getFieldName());
    } // end onSelectValue

    abstract public function onSearchFilter(&$db, $value);
    
    abstract public function isEditable();

}

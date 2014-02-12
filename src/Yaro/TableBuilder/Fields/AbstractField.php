<?php namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;


abstract class AbstractField {

    protected $fieldName;
    protected $attributes;
    protected $options;

    protected $handler;


    public function __construct($fieldName, $attributes, $options, &$handler)
    {
       $this->attributes = $this->_prepareAttributes($attributes);
       $this->options    = $options;
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

        return $attributes;
    } // end _prepareAttributes

    protected function getOption($ident)
    {
        return $this->options[$ident];
    } // end getOption

    public function getAttribute($ident)
    {
        return $this->attributes[$ident];
    } // end getAttribute

    public function getValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row);
            if ($res) {
                return $res;
            }
        }

        return $row[$this->getFieldName()];
    } // end getValue

    public function getEditInput($row)
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

        return $table->render();
    } // end getEditInput

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $type = $this->getAttribute('type');
        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.filter_'. $type);
        $table->name = $this->getFieldName();

        return $table->render();
    } // end getFilterInput

    protected function hasCustomHandlerMethod($methodName)
    {
        return $this->handler && method_exists($this->handler, $methodName);
    } // end hasCustomHandlerMethod


    abstract public function onSearchFilter(&$db, $value);
    
    abstract public function isEditable();

}

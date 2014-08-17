<?php 

namespace Yaro\TableBuilder\Fields;

use Yaro\TableBuilder\TableBuilderValidationException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


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

        $input = View::make($tplPath .'.input_'. $type);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->placeholder = $this->getAttribute('placeholder');
        

        return $input->render();
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

        $input = View::make($tplPath .'.filter_'. $type);
        $input->name = $this->getFieldName();
        $input->value = $filter;

        return $input->render();
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
    
    public function isReadonly()
    {
        return false;
    } // end isReadonly
    
    public function getClientsideValidatorRules()
    {
        $tplPath = $this->getOption('tpl_path');
        
        $validation = $this->getAttribute('validation');
        if (!isset($validation['client'])) {
            return;
        }
        $validation = $validation['client'];
        
        $rules      = isset($validation['rules']) ? $validation['rules'] : array();
        $name       = $this->getFieldName();
        
        $data = compact('rules', 'name');
        return View::make($tplPath .'.validator_rules', $data)->render();
    } // end getClientsideValidatorRules
    
    public function getClientsideValidatorMessages()
    {
        $tplPath = $this->getOption('tpl_path');
        
        $validation = $this->getAttribute('validation');
        if (!isset($validation['client'])) {
            return;
        }
        $validation = $validation['client'];
        
        $messages   = isset($validation['messages']) ? $validation['messages'] : array();
        $name       = $this->getFieldName();
        
        $data = compact('messages', 'name');
        return View::make($tplPath .'.validator_messages', $data)->render();
    } // end getClientsideValidatorMessages
    
    public function doValidate($value)
    {
        $validation = $this->getAttribute('validation');
        if (!isset($validation['server'])) {
            return;
        }
        
        $rules = $validation['server']['rules'];
        $messages = isset($validation['server']['messages']) ? $validation['server']['messages'] : array();
        $name = $this->getFieldName();
        
        $validator = Validator::make(
            array(
                $name => $value,
            ),
            array(
                $name => $rules,
            ),
            $messages
        );
        
        if ($validator->fails()) {
            $errors = implode('|', $validator->messages()->all());
            throw new TableBuilderValidationException($errors);
        }
    } // end doValidate

    abstract public function onSearchFilter(&$db, $value);
    
    abstract public function isEditable();

}

<?php 

namespace Yaro\TableBuilder\Fields;

use Yaro\TableBuilder\TableBuilderPreValidationException;
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

    public function getValue($row, $postfix = '')
    {
        if ($this->hasCustomHandlerMethod('onGetValue')) {
            $res = $this->handler->onGetValue($this, $row, $postfix);
            if ($res) {
                return $res;
            }
        }
        
        $fieldName = $this->getFieldName() . $postfix;
        $value = isset($row[$fieldName]) ? $row[$fieldName] : '';
        
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

        $input = View::make('admin::tb.input_'. $type);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->rows  = $this->getAttribute('rows');
        $input->mask  = $this->getAttribute('mask');
        $input->placeholder = $this->getAttribute('placeholder');

        return $input->render();
    } // end getEditInput
    
    public function getTabbedEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetTabbedEditInput')) {
            $res = $this->handler->onGetTabbedEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $type = $this->getAttribute('type');
        
        $input = View::make('admin::tb.tab_input_'. $type);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->rows  = $this->getAttribute('rows');
        $input->mask  = $this->getAttribute('mask');
        $input->placeholder = $this->getAttribute('placeholder');
        $input->caption = $this->getAttribute('caption');
        $input->tabs = $this->getPreparedTabs($row);
        
        
        return $input->render();
    } // end getTabbedEditInput
    
    protected function getPreparedTabs($row)
    {
        $tabs = $this->getAttribute('tabs');
        $required = array(
            'placeholder',
            'postfix'
        );
        foreach ($tabs as &$tab) {
            foreach ($required as $option) {
                if (!isset($tab[$option])) {
                    $tab[$option] = '';
                }
            }
            
            $tab['value'] = $this->getValue($row, $tab['postfix']);
        }
        
        return $tabs;
    } // end getPreparedTabs

    public function getFilterInput()
    {
        if (!$this->getAttribute('filter')) {
            return '';
        }

        $definitionName = $this->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters.'.$this->getFieldName();
        $filter = Session::get($sessionPath, '');

        $type = $this->getAttribute('filter');

        $input = View::make('admin::tb.filter_'. $type);
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
        $tabs = $this->getAttribute('tabs');
        if ($tabs) {
            foreach ($tabs as $tab) {
                $name = $this->definition['db']['table'] .'.'. $this->getFieldName() . $tab['postfix'];
                $db->addSelect($name);
            }
        } else {
            $db->addSelect($this->definition['db']['table'] .'.'. $this->getFieldName());
        }
    } // end onSelectValue
    
    public function isReadonly()
    {
        return false;
    } // end isReadonly
    
    public function getClientsideValidatorRules()
    {
        $validation = $this->getAttribute('validation');
        if (!isset($validation['client'])) {
            return;
        }
        $validation = $validation['client'];
        
        $rules = isset($validation['rules']) ? $validation['rules'] : array();
        $name  = $this->getFieldName();
        $tabs  = $this->getAttribute('tabs');
        
        $data = compact('rules', 'name', 'tabs');
        return View::make('admin::tb.validator_rules', $data)->render();
    } // end getClientsideValidatorRules
    
    public function getClientsideValidatorMessages()
    {
        $validation = $this->getAttribute('validation');
        if (!isset($validation['client'])) {
            return;
        }
        $validation = $validation['client'];
        
        $messages = isset($validation['messages']) ? $validation['messages'] : array();
        $name     = $this->getFieldName();
        $tabs     = $this->getAttribute('tabs');
        
        $data = compact('messages', 'name', 'tabs');
        return View::make('admin::tb.validator_messages', $data)->render();
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
            throw new TableBuilderPreValidationException($errors);
        }
    } // end doValidate
    
    public function getLabelClass()
    {
        return 'input';
    } // end getLabelClass

    abstract public function onSearchFilter(&$db, $value);
    
    abstract public function isEditable();

}

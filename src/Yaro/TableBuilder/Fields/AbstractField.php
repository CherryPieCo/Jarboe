<?php namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;


abstract class AbstractField {

    protected $fieldName;
    protected $attributes;
    protected $options;


    public function __construct($fieldName, $attributes, $options)
    {
       $this->attributes = $this->_prepareAttributes($attributes);
       $this->options    = $options;
       $this->fieldName  = $fieldName;
    } // end __construct

    protected function getFieldName()
    {
        return $this->fieldName;
    } // end getFieldName

    private function _prepareAttributes($attributes)
    {
        $attributes['fast-edit'] = isset($attributes['fast-edit']) && $attributes['fast-edit'];

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
        return $row[$this->getFieldName()];
    } // end getValue

    public function getEditInput($row)
    {
        $type = $this->getAttribute('type');
        $tplPath = $this->getOption('tpl_path');

        $table = View::make($tplPath .'.input_'. $type);
        $table->value = $this->getValue($row);

        return $table->render();
    } // end getEditInput

    abstract public function isEditable();

}

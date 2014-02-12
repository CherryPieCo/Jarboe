<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class QueryHandler {

    protected $controller;

    protected $db;
    protected $dbOptions;

    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;

        $definition = $controller->getDefinition();

        $this->dbOptions = $definition['db'];
        $this->db = DB::table($definition['db']['table']);
    } // end __construct

    protected function getOption($ident)
    {
        return $this->dbOptions[$ident];
    } // end getOption

    protected function hasOption($ident)
    {
        return isset($this->dbOptions[$ident]);
    } // end hasOption

    public function getRows()
    {
        $filters = $this->_prepareSearchFilters();
        foreach ($filters as $name => $value) {
            if ($this->controller->hasCustomHandlerMethod('onSearchFilter')) {
                $res = $this->controller->getCustomHandler()->onSearchFilter($this->db, $name, $value);
                if ($res) {
                    continue;
                }
            }

            $this->controller->getField($name)->onSearchFilter($this->db, $value);
        }

        if ($this->hasOption('order')) {
            $order = $this->getOption('order');
            foreach ($order as $field => $direction) {
                $this->db->orderBy($field, $direction);
            }
        }

        return $this->db->get();
    } // end getRows

    public function updateRow($values)
    {
        $this->_checkFastSaveValues($values);
        $this->_checkField($values);

        $updateData = array(
            $values['name'] => $values['value']
        );
        $updateResult = $this->db->where('id', $values['id'])->update($updateData);

        $res = array(
            'status' => $updateResult,
            'id'     => $values['id'],
            'value'  => $values['value']
        );
        if ($this->controller->hasCustomHandlerMethod('onUpdateRowResponse')) {
            $this->controller->getCustomHandler()->onUpdateRowResponse($res);
        }

        return $res;
    } // end updateRow

    private function _checkField($values)
    {
        $field = $this->controller->getField($values['name']);

        if (!$field->isEditable()) {
            throw new \RuntimeException("Field [{$values['name']}] is not editable");
        }


    } // end _checkField

    private function _checkFastSaveValues($values)
    {
        $required = array(
            'id', 'name', 'value'
        );

        foreach ($required as $ident) {
            if (!isset($values[$ident])) {
                throw new \RuntimeException("FastSave ident [{$ident}] does not pass.");
            }
        }
    } // end _checkFastSaveValues

    private function _prepareSearchFilters()
    {
        $filters = Input::get('filter', array());

        $newFilters = array();
        foreach ($filters as $key => $value) {
            if ($value) {
                $newFilters[$key] = $value;
            }
        }

        if ($this->controller->hasCustomHandlerMethod('onPrepareSearchFilters')) {
            $this->controller->getCustomHandler()->onPrepareSearchFilters($newFilters);
        }

        return $newFilters;
    } // end _prepareSearchFilters
        
}

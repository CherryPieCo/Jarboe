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
        $this->db = DB::table($this->dbOptions['table']);

        $this->onSearchFilterQuery();

        if ($this->hasOption('order')) {
            $order = $this->getOption('order');
            foreach ($order as $field => $direction) {
                $this->db->orderBy($field, $direction);
            }
        }

        if ($this->hasOption('pagination')) {
            $pagination = $this->getOption('pagination');
            return $this->db->paginate($pagination['per_page']);
        }
        return $this->db->get();
    } // end getRows

    public function getRow($id)
    {
        $this->db = DB::table($this->dbOptions['table']);

        $this->db->where('id', $id);

        return $this->db->get();
    } // end getRows

    public function getTableAllowedIds()
    {
        $this->db = DB::table($this->dbOptions['table']);

        $this->db->select('id');
        $res = $this->db->get();

        $ids = array();
        foreach ($res as $row) {
            $ids[$row['id']] = $row['id'];
        }
        return $ids;
    } // end getTableAllowedIds

    protected function onSearchFilterQuery()
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
    } // end onSearchFilterQuery

    public function updateFastRow($values)
    {
        $this->_checkFastSaveValues($values);
        $this->_checkField($values, $values['name']);

        $updateData = array(
            $values['name'] => $values['value']
        );
        $updateResult = $this->db->where('id', $values['id'])->update($updateData);

        $res = array(
            'status' => $updateResult,
            'id'     => $values['id'],
            'value'  => $values['value']
        );
        if ($this->controller->hasCustomHandlerMethod('onUpdateFastRowResponse')) {
            $this->controller->getCustomHandler()->onUpdateFastRowResponse($res);
        }

        return $res;
    } // end updateFastRow

    public function updateRow($values)
    {
        $updateData = $this->_getRowUpdateValues($values);
        $this->_checkFields($updateData);

        $updateResult = $this->db->where('id', $values['id'])->update($updateData);

        $res = array(
            'status' => $updateResult,
            'id'     => $values['id'],
            'values' => $updateData
        );
        if ($this->controller->hasCustomHandlerMethod('onUpdateRowResponse')) {
            $this->controller->getCustomHandler()->onUpdateRowResponse($res);
        }

        return $res;
    } // end updateRow

    private function _getRowUpdateValues($values)
    {
        unset($values['id']);
        unset($values['query_type']);

        return $values;
    } // end _getRowUpdateValues

    private function _checkFields($values)
    {
        foreach ($values as $ident => $value) {
            $this->_checkField($values, $ident);
        }
    } // end _checkFields

    private function _checkField($values, $ident = 'name')
    {
        $field = $this->controller->getField($ident);
        
        if (!$field->isEditable()) {
            throw new \RuntimeException("Field [{$ident}] is not editable");
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

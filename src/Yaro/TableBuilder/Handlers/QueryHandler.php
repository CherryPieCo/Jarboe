<?php namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;


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

    protected function getOptionDB($ident)
    {
        return $this->dbOptions[$ident];
    } // end getOptionDB

    protected function hasOptionDB($ident)
    {
        return isset($this->dbOptions[$ident]);
    } // end hasOptionDB

    public function getRows()
    {
        $this->db = DB::table($this->dbOptions['table']);

        $this->prepareSelectValues();

        $this->onSearchFilterQuery();

        if ($this->hasOptionDB('order')) {
            $order = $this->getOptionDB('order');
            foreach ($order as $field => $direction) {
                $this->db->orderBy($field, $direction);
            }
        }

        if ($this->hasOptionDB('pagination')) {
            $pagination = $this->getOptionDB('pagination');
            $paginator = $this->db->paginate($pagination['per_page']);
            $paginator->setBaseUrl($pagination['uri']);
            return $paginator;
        }
        return $this->db->get();
    } // end getRows

    protected function prepareSelectValues()
    {
        $this->db->select($this->getOptionDB('table') .'.id');

        $fields = $this->controller->getFields();
        foreach ($fields as $name => $field) {
            $field->onSelectValue($this->db);
        }
    } // end prepareSelectValues

    public function getRow($id)
    {
        $this->db = DB::table($this->getOptionDB('table'));
        $this->db->where('id', $id);

        return $this->db->first();
    } // end getRow

    public function getTableAllowedIds()
    {
        $this->db = DB::table($this->getOptionDB('table'));
        $ids = $this->db->lists('id');

        return $ids;
    } // end getTableAllowedIds

    protected function onSearchFilterQuery()
    {
        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.filters';

        $filters = Session::get($sessionPath, array());
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

        $value = $this->controller->getField($values['name'])->prepareQueryValue($values['value']);
        $updateData = array(
            $values['name'] => $value
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
        $updateData = $this->_getRowQueryValues($values);
        $this->_checkFields($updateData);

        $this->db->where('id', $values['id'])->update($updateData);

        $res = array(
            'id'     => $values['id'],
            'values' => $updateData
        );
        if ($this->controller->hasCustomHandlerMethod('onUpdateRowResponse')) {
            $this->controller->getCustomHandler()->onUpdateRowResponse($res);
        }

        return $res;
    } // end updateRow

    public function deleteRow($id)
    {
        $this->db->where('id', $id)->delete();

        $res = array(
            'id' => $id
        );
        if ($this->controller->hasCustomHandlerMethod('onDeleteRowResponse')) {
            $this->controller->getCustomHandler()->onDeleteRowResponse($res);
        }

        return $res;
    } // end deleteRow

    public function insertRow($values)
    {
        $insertData = $this->_getRowQueryValues($values);
        $this->_checkFields($insertData);

        $id = $this->db->insertGetId($insertData);

        $res = array(
            'id'     => $id,
            'values' => $insertData
        );
        if ($this->controller->hasCustomHandlerMethod('onInsertRowResponse')) {
            $this->controller->getCustomHandler()->onInsertRowResponse($res);
        }

        return $res;
    } // end insertRow

    private function _getRowQueryValues($values)
    {
        $values = $this->_unsetFutileFields($values);
        array_walk($values, function(&$value, $ident) { 
            $value = $this->controller->getField($ident)->prepareQueryValue($value);
        }); 

        return $values;
    } // end _getRowQueryValues

    private function _unsetFutileFields($values)
    {
        unset($values['id']);
        unset($values['query_type']);

        return $values;
    } // end _unsetFutileFields

    private function _checkFields($values)
    {
        foreach ($values as $ident => $value) {
            $this->_checkField($values, $ident);
        }
    } // end _checkFields

    private function _checkField($values, $ident)
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

}

<?php

namespace Yaro\Jarboe\Handlers;

use Yaro\Jarboe\JarboeController;
use Yaro\Jarboe\Exceptions\JarboeValidationException as JarboeValidationException;
use Yaro\Jarboe\Exceptions\JarboePreValidationException as JarboePreValidationException;
use DB;
use Session;


class QueryHandler 
{

    protected $controller;

    protected $db;
    protected $dbOptions;

    public function __construct(JarboeController $controller)
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

    public function getRows($isPagination = true, $isUserFilters = true, $betweenWhere = array(), $isSelectAll = false)
    {
        $this->db = DB::table($this->dbOptions['table']);
        
        $isSoftDelete = $this->controller->getDefinitionOption('db.soft_delete', false);
        if ($isSoftDelete) {
            $this->db->whereNull('deleted_at');
        }
        // FIXME: restore action mwaa
        if ($this->controller->getDefinitionOption('actions.restore', false)) {
            $this->db->whereNotNull('deleted_at');
        }

        $this->prepareSelectValues();
        if ($isSelectAll) {
            $this->db->addSelect($this->getOptionDB('table') .'.*');
        }
        
        $this->prepareFilterValues();

        if ($isUserFilters) {
            $this->onSearchFilterQuery();
        }

        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.order';
        $order = Session::get($sessionPath, array());
        if ($order && $isUserFilters) {
            $this->db->orderBy($this->getOptionDB('table') .'.'. $order['field'], $order['direction']);
        } else if ($this->hasOptionDB('order')) {
            $order = $this->getOptionDB('order');
            foreach ($order as $field => $direction) {
                $this->db->orderBy($this->getOptionDB('table') .'.'. $field, $direction);
            }
        }

        // FIXME:
        if ($betweenWhere) {
            $betweenField  = $betweenWhere['field'];
            $betweenValues = $betweenWhere['values'];

            $this->db->whereBetween($betweenField, $betweenValues);
        }


        if ($this->hasOptionDB('pagination') && $isPagination) {
            $pagination = $this->getOptionDB('pagination');
            $perPage = $this->getPerPageAmount($pagination['per_page']);
            $paginator = $this->db->paginate($perPage);
            return $paginator;
        }
        return $this->db->get();
    } // end getRows

    private function getPerPageAmount($info)
    {
        if (!is_array($info)) {
            return $info;
        }

        $definitionName = $this->controller->getOption('def_name');
        $sessionPath = 'table_builder.'.$definitionName.'.per_page';
        $perPage = Session::get($sessionPath);
        if (!$perPage) {
            $keys = array_keys($info);
            $perPage = $keys[0];
        }

        return $perPage;
    } // end getPerPageAmount

    protected function prepareFilterValues()
    {
        $definition = $this->controller->getDefinition();
        $filters = isset($definition['filters']) ? $definition['filters'] : array();
        if (is_callable($filters)) {
            $filters($this->db);
            return;
        }

        foreach ($filters as $name => $field) {
            $this->db->where($name, $field['sign'], $field['value']);
        }
    } // end prepareFilterValues

    protected function doPrependFilterValues(&$values)
    {
        $definition = $this->controller->getDefinition();
        $filters = isset($definition['filters']) ? $definition['filters'] : array();
        if (is_callable($filters)) {
            return;
        }

        foreach ($filters as $name => $field) {
            $values[$name] = $field['value'];
        }
    } // end doPrependFilterValues

    protected function prepareSelectValues()
    {
        $this->db->select($this->getOptionDB('table') .'.id');
        $def = $this->controller->getDefinition();
        if (isset($def['options']['is_sortable']) && $def['options']['is_sortable']) {
            // FIXME: changeable field name
            $this->db->addSelect($this->getOptionDB('table') .'.priority');
        }
        
        if (isset($def['options']['select_all']) && $def['options']['select_all']) {
            $this->db->addSelect($this->getOptionDB('table') .'.*');
        }

        $fields = $this->controller->getFields();
        foreach ($fields as $name => $field) {
            $field->onSelectValue($this->db);
        }
    } // end prepareSelectValues

    public function getRow($id)
    {
        $this->db = DB::table($this->getOptionDB('table'));

        $this->prepareSelectValues();

        $this->db->where($this->getOptionDB('table').'.id', $id);

        return $this->db->first();
    } // end getRow

    public function getTableAllowedIds()
    {
        $this->db = DB::table($this->getOptionDB('table'));

        $this->prepareFilterValues();

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
    
    public function updateRow($values)
    {
        if (!$this->controller->actions->isAllowed('update')) {
            throw new \RuntimeException('Update action is not permitted');
        }

        if ($this->controller->hasCustomHandlerMethod('handleUpdateRow')) {
            $res = $this->controller->getCustomHandler()->handleUpdateRow($values);
            if ($res) {
                return $res;
            }
        }

        $updateData = $this->_getRowQueryValues($values);
        $this->_checkFields($updateData);

        if ($this->controller->hasCustomHandlerMethod('onUpdateRowData')) {
            $this->controller->getCustomHandler()->onUpdateRowData($updateData);
        }
        $this->doValidate($updateData);

        $this->doPrependFilterValues($updateData);

        $this->db->where('id', $values['id'])->update($updateData);

        // FIXME: patterns
        foreach ($this->controller->getPatterns() as $pattern) {
            $pattern->update($values, $values['id']);
        }
        
        // FIXME:
        $fields = $this->controller->getFields();
        foreach ($fields as $field) {
            if (preg_match('~^many2many~', $field->getFieldName())) {
                $this->onManyToManyValues($field->getFieldName(), $values, $values['id']);
            }
        }

        $res = array(
            'id'     => $values['id'],
            'values' => $updateData
        );
        if ($this->controller->hasCustomHandlerMethod('onUpdateRowResponse')) {
            $this->controller->getCustomHandler()->onUpdateRowResponse($res);
        }
            
        $this->controller->cache->flush();

        return $res;
    } // end updateRow

    public function deleteRow($id)
    {
        if (!$this->controller->actions->isAllowed('delete')) {
            throw new \RuntimeException('Delete action is not permitted');
        }

        if ($this->controller->hasCustomHandlerMethod('handleDeleteRow')) {
            $res = $this->controller->getCustomHandler()->handleDeleteRow($id);
            if ($res) {
                return $res;
            }
        }

        foreach ($this->controller->getPatterns() as $pattern) {
            $pattern->delete($id);
        }
        
        $isSoftDelete = $this->controller->getDefinitionOption('db.soft_delete', false);
        if ($isSoftDelete) {
            $res = $this->db->where('id', $id)->update([
                'deleted_at' => DB::raw('NOW()')
            ]);
        } else {
            $res = $this->db->where('id', $id)->delete();
        }
        

        $res = array(
            'id'     => $id,
            'status' => $res
        );
        if ($this->controller->hasCustomHandlerMethod('onDeleteRowResponse')) {
            $this->controller->getCustomHandler()->onDeleteRowResponse($res);
        }
        
        $this->controller->cache->flush();

        return $res;
    } // end deleteRow
    
    public function restoreRow($id)
    {
        if (!$this->controller->actions->isAllowed('restore')) {
            throw new \RuntimeException('Restore action is not permitted');
        }
        
        if ($this->controller->hasCustomHandlerMethod('handleRestoreRow')) {
            $res = $this->controller->getCustomHandler()->handleRestoreRow($id);
            if ($res) {
                return $res;
            }
        }
        
        $res = $this->db->where('id', $id)->update([
            'deleted_at' => null
        ]);
        
        $res = array(
            'id'     => $id,
            'status' => $res
        );
        if ($this->controller->hasCustomHandlerMethod('onRestoreRowResponse')) {
            $this->controller->getCustomHandler()->onRestoreRowResponse($res);
        }
        
        $this->controller->cache->flush();

        return $res;
    } // end restoreRow

    public function insertRow($values)
    {
        if (!$this->controller->actions->isAllowed('insert')) {
            throw new \RuntimeException('Insert action is not permitted');
        }

        if ($this->controller->hasCustomHandlerMethod('handleInsertRow')) {
            $res = $this->controller->getCustomHandler()->handleInsertRow($values);
            if ($res) {
                return $res;
            }
        }

        $insertData = $this->_getRowQueryValues($values);
        $this->_checkFields($insertData);

        $id = false;
        if ($this->controller->hasCustomHandlerMethod('onInsertRowData')) {
            $id = $this->controller->getCustomHandler()->onInsertRowData($insertData);
        }

        if (!$id) {
            $this->doValidate($insertData);
            $this->doPrependFilterValues($insertData);
            $id = $this->db->insertGetId($insertData);
        }
        
        // FIXME: patterns
        foreach ($this->controller->getPatterns() as $pattern) {
            $pattern->insert($values, $id);
        }

        // FIXME:
        $fields = $this->controller->getFields();
        foreach ($fields as $field) {
            if (preg_match('~^many2many~', $field->getFieldName())) {
                $this->onManyToManyValues($field->getFieldName(), $values, $id);
            }
        }

        $res = array(
            'id' => $id,
            'values' => $insertData
        );
        if ($this->controller->hasCustomHandlerMethod('onInsertRowResponse')) {
            $this->controller->getCustomHandler()->onInsertRowResponse($res);
        }
            
        $this->controller->cache->flush();

        return $res;
    } // end insertRow

    private function onManyToManyValues($ident, $values, $id)
    {
        $field = $this->controller->getField($ident);
        $vals = isset($values[$ident]) ? $values[$ident] : array();
        
        $field->onPrepareRowValues($vals, $id);
    } // end onManyToManyValues

    private function doValidate($values)
    {
        $errors = array();

        $definition = $this->controller->getDefinition();
        $fields = $definition['fields'];
        foreach ($fields as $ident => $options) {
            try {
                $field = $this->controller->getField($ident);
                if ($field->isPattern()) {
                    continue;
                }
                
                $tabs = $field->getAttribute('tabs');
                if ($tabs) {
                    foreach ($tabs as $tab) {
                        $fieldName = $ident . $tab['postfix'];
                        $field->doValidate($values[$fieldName]);
                    }
                } else {
                    if (isset($values[$ident])) {
                        $field->doValidate($values[$ident]);
                    }
                }
            } catch (JarboePreValidationException $e) {
                $errors = array_merge($errors, explode('|', $e->getMessage()));
                continue;
            }
        }

        if ($errors) {
            $errors = implode('|', $errors);
            throw new JarboeValidationException($errors);
        }
    } // end doValidate

    private function _getRowQueryValues($values)
    {
        $values = $this->_unsetFutileFields($values);
        $definition = $this->controller->getDefinition();
        $fields = $definition['fields'];
        foreach ($fields as $ident => $options) {
            $field = $this->controller->getField($ident);
            if ($field->isPattern()) {
                continue;
            }
            
            $tabs = $field->getAttribute('tabs');
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $fieldName = $ident . $tab['postfix'];
                    $values[$fieldName] = $field->prepareQueryValue($values[$fieldName]);
                }
            } else {
                if (isset($values[$ident])) {
                    $values[$ident] = $field->prepareQueryValue($values[$ident]);
                }
            }
        }

        return $values;
    } // end _getRowQueryValues

    private function _unsetFutileFields($values)
    {
        unset($values['id']);
        unset($values['query_type']);

        foreach ($values as $key => $val) {
            if (preg_match('~^__~', $key)) {
                unset($values[$key]);
            }
            if (preg_match('~^many2many~', $key)) {
                unset($values[$key]);
            }
        }
        
        // patterns
        unset($values['pattern']);

        // for tree
        unset($values['node']); // with __node

        return $values;
    } // end _unsetFutileFields

    private function _checkFields($values)
    {
        $definition = $this->controller->getDefinition();
        $fields = $definition['fields'];
        foreach ($fields as $ident => $options) {
            $field = $this->controller->getField($ident);
            if ($field->isPattern()) {
                continue;
            }
            
            $tabs = $field->getAttribute('tabs');
            if ($tabs) {
                foreach ($tabs as $tab) {
                    $this->_checkField($values, $ident, $field);
                }
            } else {
                if (isset($values[$ident])) {
                    $this->_checkField($values, $ident, $field);
                }
            }
        }
    } // end _checkFields

    private function _checkField($values, $ident, $field)
    {
        if (!$field->isEditable()) {
            throw new \RuntimeException("Field [{$ident}] is not editable");
        }
    } // end _checkField

}

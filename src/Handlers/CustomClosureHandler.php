<?php

namespace Yaro\Jarboe\Handlers;

use Yaro\Jarboe\JarboeController;
use Yaro\Jarboe\Interfaces\ICustomHandler;


class CustomClosureHandler implements ICustomHandler
{
    
    public $controller;
    private $functions = array();


    public function __construct($functions, JarboeController $controller)
    {
        $this->functions = $functions;
        $this->controller = $controller;
    } // end __construct

    private function getClosure($name)
    {
        return isset($this->functions[$name]) ? $this->functions[$name] : false;
    } // end isExist
    
    //
    public function handle()
    {
        $closure = $this->getClosure('handle');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure();
        }
    } // end handle

    public function onGetValue($formField, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row, $postfix);
        }
    } // end onGetValue
    
    public function onGetExportValue($formField, $type, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetExportValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $type, $row, $postfix);
        }
    } // end onGetExportValue

    public function onGetEditInput($formField, array &$row)
    {
        $closure = $this->getClosure('onGetEditInput');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row);
        }
    } // end onGetEditInput
    
    public function onGetListValue($formField, array &$row)
    {
        $closure = $this->getClosure('onGetListValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row);
        }
    } // end onGetListValue
    
    public function onSelectField($formField, &$db)
    {
        $closure = $this->getClosure('onSelectField');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $db);
        }
    } // end onSelectField

    public function onPrepareSearchFilters(array &$filters)
    {
        $closure = $this->getClosure('onPrepareSearchFilters');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($filters);
        }
    } // end onPrepareSearchFilters
    
    public function onSearchFilter(&$db, $name, $value)
    {
        $closure = $this->getClosure('onSearchFilter');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($db, $name, $value);
        }
    } // end onSearchFilter

    public function onUpdateRowResponse(array &$response)
    {
        $closure = $this->getClosure('onUpdateRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($response);
        }
    } // end onUpdateRowResponse

    public function onInsertRowResponse(array &$response)
    {
        $closure = $this->getClosure('onInsertRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($response);
        }
    } // end onInsertRowResponse

    public function onDeleteRowResponse(array &$response)
    {
        $closure = $this->getClosure('onDeleteRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($response);
        }
    } // end onDeleteRowResponse
    
    public function handleDeleteRow($id)
    {
        $closure = $this->getClosure('handleDeleteRow');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($id);
        }
        /*
        return array(
            'id'     => $id,
            'status' => true|false
        );
        */
    } // end handleDeleteRow
    
    public function handleInsertRow($values)
    {
        $closure = $this->getClosure('handleInsertRow');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($values);
        }
        /*
        return array(
            'id' => $idInsertedRow,
            'values' => $values
        );
        */
    } // end handleInsertRow
    
    public function handleUpdateRow($values)
    {
        $closure = $this->getClosure('handleUpdateRow');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($values);
        }
        /*
        return array(
            'id' => $idUpdatedRow,
            'values' => $values
        );
        */
    } // end handleUpdateRow
    
    public function onUpdateFastRowResponse(array &$response)
    {
        $closure = $this->getClosure('onUpdateFastRowResponse');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($response);
        }
    } // end onUpdateFastRowResponse
    
    public function onInsertRowData(array &$data)
    {
        $closure = $this->getClosure('onInsertRowData');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($data);
        }
    } // end onInsertRowData
    
    public function onUpdateRowData(array &$data)
    {
        $closure = $this->getClosure('onUpdateRowData');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($data);
        }
    } // end onUpdateRowData
    
    public function onSearchCustomFilter($formField, &$db, $value)
    {
        $closure = $this->getClosure('onSearchCustomFilter');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $db, $value);
        }
    } // end onSearchCustomFilter
    
    public function onGetCustomValue($formField, array &$row, &$postfix)
    {
        $closure = $this->getClosure('onGetCustomValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row, $postfix);
        }
    } // end onGetCustomValue
    
    public function onGetCustomEditInput($formField, array &$row)
    {
        $closure = $this->getClosure('onGetCustomEditInput');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row);
        }
    } // end onGetCustomEditInput
        
    public function onGetCustomListValue($formField, array &$row)
    {
        $closure = $this->getClosure('onGetCustomListValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $row);
        }
    } // end onGetCustomListValue
    
    public function onSelectCustomValue(&$db)
    {
        $closure = $this->getClosure('onSelectCustomValue');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($db);
        }
    } // end onSelectCustomValue
    
    public function onFileUpload($file)
    {
        $closure = $this->getClosure('onFileUpload');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($file);
        }
        /*
        $data = array(
            'status'     => true|false,
            'link'       => absolute path,
            'short_link' => relative path,
        );
        return Response::json($data);
        */
    } // end onFileUpload
    
    public function onPhotoUpload($formField, $file)
    {
        $closure = $this->getClosure('onPhotoUpload');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($formField, $file);
        }
        /*
        $data = array(
            'status'     => true|false,
            'link'       => absolute path,
            'short_link' => relative path,
            'delimiter'  => ','
        );
        return Response::json($data);
        */
    } // end onPhotoUpload
    
    public function onPhotoUploadFromWysiwyg($file)
    {
        $closure = $this->getClosure('onPhotoUploadFromWysiwyg');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($file);
        }
        /*
        $data = array(
            'status' => true|false,
            'link'   => absolute path
        );
        return Response::json($data);
        */
    } // end onPhotoUploadFromWysiwyg
    
    
    public function onInsertButtonFetch($def)
    {
        $closure = $this->getClosure('onInsertButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($def);
        }
    } // end onInsertButtonFetch
    
    public function onUpdateButtonFetch($def)
    {
        $closure = $this->getClosure('onUpdateButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($def);
        }
    } // end onUpdateButtonFetch
    
    public function onDeleteButtonFetch($def)
    {
        $closure = $this->getClosure('onDeleteButtonFetch');
        if ($closure) {
            $closure = $closure->bindTo($this);
            return $closure($def);
        }
    } // end onDeleteButtonFetch

}

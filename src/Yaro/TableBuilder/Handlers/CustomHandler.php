<?php 

namespace Yaro\TableBuilder\Handlers;

use Yaro\TableBuilder\TableBuilderController;


abstract class CustomHandler 
{

    protected $controller;


    public function __construct(TableBuilderController $controller)
    {
        $this->controller = $controller;
    } // end __construct

    protected function getOption($ident)
    {
        return $this->controller->getOption($ident);
    } // end getOption

    public function handle()
    {
    } // end handle

    public function onGetValue($formField, array &$row, &$postfix)
    {
    } // end onGetValue
    
    public function onGetExportValue($formField, $type, array &$row, &$postfix)
    {
    } // end onGetExportValue

    public function onGetEditInput($formField, array &$row)
    {
    } // end onGetEditInput
    
    public function onGetListValue($formField, array &$row)
    {
    } // end onGetListValue
    
    public function onSelectField($formField, &$db)
    {
    } // end onSelectField

    public function onPrepareSearchFilters(&$filters)
    {
    } // end onPrepareSearchFilters
    
    public function onSearchFilter(&$db, $name, $value)
    {
    } // end onSearchFilter

    public function onUpdateRowResponse(array &$response)
    {
    } // end onUpdateRowResponse

    public function onInsertRowResponse(array &$response)
    {
    } // end onInsertRowResponse

    public function onDeleteRowResponse(array &$response)
    {
    } // end onDeleteRowResponse
    
    public function handleDeleteRow($id)
    {
        /*
        return array(
            'id'     => $id,
            'status' => true|false
        );
        */
    } // end handleDeleteRow
    
    public function handleInsertRow($values)
    {
        /*
        return array(
            'id' => $idInsertedRow,
        );
        */
    } // end handleInsertRow
    
    public function onUpdateFastRowResponse(array &$response)
    {
    } // end onUpdateFastRowResponse
    
    public function onInsertRowData(array &$data)
    {
    } // end onInsertRowData
    
    public function onUpdateRowData(array &$data)
    {
    } // end onUpdateRowData
    
    public function onSearchCustomFilter($formField, &$db, $value)
    {
    } // end onSearchCustomFilter
    
    public function onGetCustomValue($formField, array &$row, &$postfix)
    {
    } // end onGetCustomValue
    
    public function onGetCustomEditInput($formField, array &$row)
    {
    } // end onGetCustomEditInput
        
    public function onGetCustomListValue($formField, array &$row)
    {
    } // end onGetCustomListValue
    
    public function onSelectCustomValue(&$db)
    {
    } // end onSelectCustomValue
    
    public function onFileUpload($file)
    {
        /*
        $data = array(
            'status'     => true|false,
            'link'       => absolute path,
            'short_link' => relative path,
        );
        return Response::json($data);
        */
    } // end onFileUpload
    
    public function onPhotoUpload($file)
    {
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
    } // end onInsertButtonFetch
    
    public function onUpdateButtonFetch($def)
    {
    } // end onUpdateButtonFetch
    
    public function onDeleteButtonFetch($def)
    {
    } // end onDeleteButtonFetch
}

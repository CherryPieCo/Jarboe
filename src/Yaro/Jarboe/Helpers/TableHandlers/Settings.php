<?php

namespace Yaro\Jarboe\Helpers\TableHandlers;

use Yaro\Jarboe\Handlers\CustomHandler as CustomHandler;


class Settings extends CustomHandler 
{

    public function onGetEditInput($formField, array &$row)
    {
        if ($row && $formField->getFieldName() == 'name') {
            return $formField->getValue($row);
        }

        return false;
    } // end onGetEditInput

    public function onUpdateFastRowResponse(array &$response)
    {
        \Cache::forget('settings');
    } // end onUpdateFastRowResponse

    public function onUpdateRowResponse(array &$response)
    {
        \Cache::forget('settings');
    } // end onUpdateRowResponse

    public function onInsertRowResponse(array &$response)
    {
        \Cache::forget('settings');
    } // end onInsertRowResponse

    public function onDeleteRowResponse(array &$response)
    {
        \Cache::forget('settings');
    } // end onDeleteRowResponse
    
}
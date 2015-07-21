<?php

namespace Yaro\Jarboe\Helpers\TableHandlers;

use Yaro\Jarboe\Handlers\CustomHandler as CustomHandler;


class Slug extends CustomHandler 
{
            
    public function onUpdateRowResponse(array &$response)
    {
        
        if (isset($response['values']['slug'])) {
            $model = '\\'. \config('jarboe::tree.model');
            
            $entity = $model::find($response['id']);
            $entity->slug = $response['values']['slug'];
            $entity->save();
        }
    } // end onUpdateRowResponse
    
}
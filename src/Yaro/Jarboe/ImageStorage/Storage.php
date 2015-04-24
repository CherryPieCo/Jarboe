<?php

namespace Yaro\Jarboe\ImageStorage;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;


class Storage 
{

    public function handle()
    {
        switch (Input::get('storage_type')) {
            case 'show_modal':
                return $this->handleModalContent();
                
            default:
                throw new \RuntimeException('Tadada');
        }
    } // end handle
    
    private function handleModalContent()
    {
        $html = View::make('admin::tb.storage.content')->render();
        
        return Response::json(array(
            'status' => true,
            'html'   => $html
        ));
    } // end handleModalContent

}


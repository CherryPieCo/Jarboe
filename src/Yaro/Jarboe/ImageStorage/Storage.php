<?php

namespace Yaro\Jarboe\ImageStorage;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class Storage 
{

    public function handle()
    {
        switch (Input::get('storage_type')) {
            case 'show_modal':
                return $this->handleModalContent();
                
            case 'upload_image':
                return $this->doUploadImage();
                
            case 'delete_image':
                return $this->doDeleteImage();
                
            case 'save_image_info':
                return $this->doSaveImageInfo();
                
            case 'get_redactor_images_list':
                return $this->getRedactorImagesList();
                
            default:
                throw new \RuntimeException('What are you looking for?');
        }
    } // end handle
    
    private function doDeleteImage()
    {
        $model = '\\' . Config::get('jarboe::images.models.image');
        $model::destroy(Input::get('id'));
        
        return Response::json(array(
            'status' => true
        ));
    } // end doDeleteImage
    
    private function doUploadImage()
    {
        $model = '\\' . Config::get('jarboe::images.models.image');
        
        $entity = new $model;
        $entity->title = Input::get('title');
        $entity->id_catalog = Input::get('id_catalog');
        $entity->save();
        
        $file = Input::file('image');
        
        $extension = $file->guessExtension();
        $rawFileName = md5_file($file->getRealPath()) .'_'. time();
        $fileName = $rawFileName .'.'. $extension;
        
        $prefixPath = '/storage/j-image-storage/';
        
        //
        list($chunks, $postfixPath) = $this->getPathByID($entity->id);
        $tempPath = public_path() . $prefixPath;
        
        foreach ($chunks as $chunk) {
            $tempPath = $tempPath . $chunk;
            
            if (!file_exists($tempPath)) {
                if (!mkdir($tempPath, 0755, true)) {
                    throw new \RuntimeException('Unable to create the directory ['. $tempPath .']');
                }
            }
            $tempPath = $tempPath .'/';
        }
        $destinationPath = $prefixPath . $postfixPath;
        
        $file->move(public_path() . $destinationPath, $fileName);
        
        $entity->source = $destinationPath . $fileName;
        $entity->save();
        
        
        $data = array(
            'status' => true,
            'html'   => View::make('admin::tb.storage.single_image')->with('image', $entity)->render(),
        );
        
        return Response::json($data);
    } // end doUploadImage
    
    private function getPathByID($id)
    {
        $id = str_pad($id, 6, '0', STR_PAD_LEFT);
        $chunks = str_split($id, 2);

        return array(
            $chunks,
            implode('/', $chunks) .'/'
        );
    } // end getPathByID
    
    private function getRedactorImagesList()
    {
        $model = '\\' . Config::get('jarboe::images.models.image');
        $images = $model::all();
        
        $data = array();
        foreach ($images as $image) {
            $data[] = array(
                'id'    => $image->id,
                'thumb' => glide($image->source, ['w' => 100, 'h' => 75, 'fit' => 'crop']),
                'title' => $image->title,
                'info'  => $image->getInfo(),
            );
        }
        
        return Response::json($data);
    } // end getRedactorImagesList
    
    private function handleModalContent()
    {
        $html = View::make('admin::tb.storage.content')->render();
        
        return Response::json(array(
            'status' => true,
            'html'   => $html
        ));
    } // end handleModalContent
    
    private function doSaveImageInfo()
    {
        $model = '\\' . Config::get('jarboe::images.models.image');
        $image = $model::find(Input::get('id'));
        
        $values = $this->getSanitizedValues(Input::all());
        $image->info = json_encode($values);
        $image->save();
        
        return Response::json(array(
            'status' => true,
            'info'   => $image->getInfo($values)
        ));
    } // end doSaveImageInfo
    
    private function getSanitizedValues($values)
    {
        $sanitized = $values;
        
        unset($sanitized['id']);
        unset($sanitized['storage_type']);
        unset($sanitized['query_type']);
        
        return $sanitized;
    } // end getSanitizedValues

}


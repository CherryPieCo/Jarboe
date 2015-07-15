<?php

namespace Yaro\Jarboe\Storage;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;


class File 
{

    public function handle()
    {
        switch (Input::get('storage_type')) {
            case 'show_modal':
                return $this->handleModalContent();
                
            case 'upload_file':
                return $this->doUploadFile();
                
            case 'reupload_file':
                return $this->doReuploadFile();
                
            case 'show_edit_file':
                return $this->getFileEditForm();
                
            case 'save_file_info':
                return $this->doSaveFileInfo();
                
            case 'delete_file':
                return $this->doDeleteFile();
                
            default:
                throw new \RuntimeException('What are you looking for?');
        }
    } // end handle
    
    private function doSaveFileInfo()
    {
        $model = '\\' . Config::get('jarboe::files.models.file');
        $file = $model::find(Input::get('id')); 
        
        $values = $this->getSanitizedValues(Input::all());
        $file->info = json_encode($values);
        $file->save();
        
        return Response::json(array(
            'status' => true,
        ));
    } // end doSaveFileInfo
    
    private function getSanitizedValues($values)
    {
        $sanitized = $values;
        
        unset($sanitized['id']);
        unset($sanitized['node']);
        unset($sanitized['__node']);
        unset($sanitized['storage_type']);
        unset($sanitized['query_type']);
        
        return $sanitized;
    } // end getSanitizedValues
    
    private function getFileEditForm()
    {
        $fields = Config::get('jarboe::images.image.fields');
        $model = '\\' . Config::get('jarboe::files.models.file');
        $file = $model::find(Input::get('id'));
        $html = View::make('admin::tb.storage.file.edit_form', compact('file', 'fields'))->render();
        
        return Response::json(array(
            'status' => true,
            'html'   => $html,
        ));
    } // end getFileEditForm
    
    private function doDeleteFile()
    {
        $model = '\\' . Config::get('jarboe::files.models.file');
        $model::destroy(Input::get('id'));
        
        return Response::json(array(
            'status' => true
        ));
    } // end doDeleteFile
    
    private function handleModalContent()
    {
        $html = View::make('admin::tb.storage.file.content')->render();
        
        return Response::json(array(
            'status' => true,
            'html'   => $html
        ));
    } // end handleModalContent
    
    private function doUploadFile()
    {
        $model = '\\' . Config::get('jarboe::files.models.file');
        
        $html = '';
        $files = Input::file('files');
        
        foreach ($files as $file) {
            $entity = new $model;
            $entity->title = Input::get('title');
            $entity->save();
            
            $mimeType = $file->getMimeType();
            $extension = $file->guessExtension();
            $rawFileName = md5_file($file->getRealPath()) .'_'. time();
            $fileName = $rawFileName .'.'. $extension;
            
            $prefixPath = '/storage/j-files-storage/';
            
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
            $entity->size = $file->getSize();
            $entity->mime = $mimeType;
            $entity->extension = $extension;
            $entity->save();
            
            $html .= View::make('admin::tb.storage.file.file_row')->with('file', $entity)->render();
        }
        
        $data = array(
            'status' => true,
            'html'   => $html,
        );
        
        return Response::json($data);
    } // end doUploadFile
    
    private function doReuploadFile()
    {
        $model = '\\' . Config::get('jarboe::files.models.file');
        
        $file = Input::file('file');
        
        $entity = $model::find(Input::get('id'));
        
        $mimeType = $file->getMimeType();
        $extension = $file->guessExtension();
        $rawFileName = md5_file($file->getRealPath()) .'_'. time();
        $fileName = $rawFileName .'.'. $extension;
        
        $prefixPath = '/storage/j-files-storage/';
        
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
        $entity->size = $file->getSize();
        $entity->mime = $mimeType;
        $entity->extension = $extension;
        $entity->save();
        
        $data = array(
            'status' => true,
        );
        return Response::json($data);
    } // end doReuploadFile
    
    private function getPathByID($id)
    {
        $id = str_pad($id, 6, '0', STR_PAD_LEFT);
        $chunks = str_split($id, 2);

        return array(
            $chunks,
            implode('/', $chunks) .'/'
        );
    } // end getPathByID

}


<?php

namespace Yaro\Jarboe\ImageStorage;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;


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
                
            case 'add_tag':
                return $this->doAddTag();
                
            case 'delete_tag':
                return $this->doDeleteTag();
                
            case 'add_gallery':
                return $this->doAddGallery();
                
            case 'delete_gallery':
                return $this->doDeleteGallery();
                
            case 'get_image_tags_and_galleries':
                return $this->getImageTagsAndGalleries();
                
            default:
                throw new \RuntimeException('What are you looking for?');
        }
    } // end handle
    
    private function getImageTagsAndGalleries()
    {
        $idImage = Input::get('id');
        
        $html = '<fieldset>';
        $html .= $this->fetchTagsSelect($idImage);
        $html .= $this->fetchGalleriesSelect($idImage);
        $html .= '</fieldset>';
        
        return Response::json(array(
            'status' => true,
            'html'   => $html
        ));
    } // end getImageTagsAndGalleries
    
    private function fetchTagsSelect($idImage)
    {
        $html = '<section><label>Теги</label>';
        $html .= '<select id="j-storage-tags" name="j-tags[]" multiple style="width:100%" class="select22">';
        
        $model = '\\' . Config::get('jarboe::images.models.tag');
        $tags = $model::all();
        
        $selectedIds = DB::table('j_images2tags')->where('id_image', $idImage)->lists('id_tag') ? : array();
        foreach ($tags as $tag) {
            $selected = in_array($tag->id, $selectedIds) ? 'selected="selected"' : '';
            $html .= '<option '. $selected .' value="'. $tag->id .'">'. $tag->title .'</option>';
        }
        
        $html .= '</select></section>';
        
        return $html;
    } // end fetchTagsSelect
    
    private function fetchGalleriesSelect($idImage)
    {
        $html = '<section><label>Галереи</label>';
        $html .= '<select id="j-storage-galleries" name="j-galleries[]" multiple style="width:100%" class="select22">';
        
        $model = '\\' . Config::get('jarboe::images.models.gallery'); 
        $galleries = $model::all();
        
        $selectedIds = DB::table('j_galleries2images')->where('id_image', $idImage)->lists('id_gallery') ? : array();
        foreach ($galleries as $gallery) {
            $selected = in_array($gallery->id, $selectedIds) ? 'selected="selected"' : '';
            $html .= '<option '. $selected .' value="'. $gallery->id .'">'. $gallery->title .'</option>';
        }
        
        $html .= '</select></section>';
        
        return $html;
    } // end fetchGalleriesSelect
    
    private function doDeleteGallery()
    {
        $model = '\\' . Config::get('jarboe::images.models.gallery');
        
        $model::destroy(Input::get('id'));
        
        return Response::json(array(
            'status' => true,
        ));
    } // end doDeleteGallery
    
    private function doAddGallery()
    {
        $model = '\\' . Config::get('jarboe::images.models.gallery');
        
        $gallery = new $model();
        $gallery->title = Input::get('title');
        $gallery->save();
        
        return Response::json(array(
            'status' => true,
            'html'   => View::make('admin::tb.storage.gallery_row', compact('gallery'))->render(),
        ));
    } // end doAddGallery
    
    private function doDeleteTag()
    {
        $model = '\\' . Config::get('jarboe::images.models.tag');
        
        $model::destroy(Input::get('id'));
        
        return Response::json(array(
            'status' => true,
        ));
    } // end doDeleteTag
    
    private function doAddTag()
    {
        $model = '\\' . Config::get('jarboe::images.models.tag');
        
        $tag = new $model();
        $tag->title = Input::get('title');
        $tag->save();
        
        return Response::json(array(
            'status' => true,
            'html'   => View::make('admin::tb.storage.tag_row', compact('tag'))->render(),
        ));
    } // end doAddTag
    
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
                'id'     => $image->id,
                'thumb'  => glide($image->source, ['w' => 100, 'h' => 75, 'fit' => 'crop']),
                'source' => URL::to($image->source),
                'title'  => $image->title,
                'info'   => $image->getInfo(),
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
        
        $this->onImageTags();
        $this->onImageGalleries();
        
        $values = $this->getSanitizedValues(Input::all());
        $image->info = json_encode($values);
        $image->save();
        
        return Response::json(array(
            'status' => true,
            'info'   => $image->getInfo($values)
        ));
    } // end doSaveImageInfo
    
    private function onImageTags()
    {
        $idImage = Input::get('id');
        
        $data = array();
        foreach (Input::get('j-tags', array()) as $idTag) {
            $data[] = array(
                'id_image' => $idImage,
                'id_tag'   => $idTag
            );
        }
        
        DB::table('j_images2tags')->where('id_image', $idImage)->delete();
        if ($data) {
            DB::table('j_images2tags')->insert($data);
        }
    } // end onImageTags
    
    private function onImageGalleries()
    {
        $idImage = Input::get('id');
        
        $data = array();
        foreach (Input::get('j-galleries', array()) as $idGallery) {
            $data[] = array(
                'id_image'   => $idImage,
                'id_gallery' => $idGallery
            );
        }
        
        DB::table('j_galleries2images')->where('id_image', $idImage)->delete();
        if ($data) {
            DB::table('j_galleries2images')->insert($data);
        }
    } // end onImageGalleries
    
    private function getSanitizedValues($values)
    {
        $sanitized = $values;
        
        unset($sanitized['id']);
        unset($sanitized['storage_type']);
        unset($sanitized['query_type']);
        unset($sanitized['j-tags']);
        unset($sanitized['j-galleries']);
        
        return $sanitized;
    } // end getSanitizedValues

}


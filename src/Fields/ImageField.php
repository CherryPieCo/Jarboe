<?php 

namespace Yaro\Jarboe\Fields;

use Image;
use View;
use URL;
use DB;
use Jarboe;


class ImageField extends AbstractField 
{
  
    public function isShowRawListValue()
    {
        return true;
    } // end isShowRawListValue
    
    public function isEditable()
    {
        return true;
    } // end isEditable

    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        if ($this->getAttribute('is_multiple')) {
            return $this->getListMultiple($row);
        }
        
        return $this->getListSingle($row);
    } // end getListValue
    
    private function getListSingle($row)
    {
        if (!$this->getValue($row)) {
            return '';
        }
        
        $image = json_decode($this->getValue($row), true);

        $src = $image['sizes']['original'];
        $src = $this->getAttribute('cropp', true) ? cropp($src)->fit(50, 50)->src() : asset($src);
        // FIXME: move to template
        $html = '<img height="50px" width="50px" src="'. $src .'" />';
              
        return $html;
    } // end getListSingle    
    
    private function getListMultiple($row)
    {
        if (!$this->getValue($row)) {
            return '';
        }
        
        $images = json_decode($this->getValue($row), true);
        $isCropp = $this->getAttribute('cropp', true);
        $imgHeight = $this->getAttribute('height', '50px');
        $imgWidth = $this->getAttribute('width', '50px');
        $hideAfter = $this->getAttribute('visible_count', 3);
        
        $i = 1;
        $html = '<ul>';
        foreach ($images as $source) {
            $src = $source['sizes']['original'];
            $src = $isCropp ? cropp($src)->fit(50, 50)->src() : asset($src);
            
            $display = $i > $hideAfter ? 'none' : 'inline';
            $html .= '<li style="display: '. $display .'; margin: 2px;">';
            $html .= '<img height="'. $imgHeight .'" width="'. $imgWidth .'" src="'. $src .'" /></li>';
            
            $i++;
        }
        if ($i > $hideAfter) {
            $html .= '<a onclick="" class="btn btn-default btn-sm" href="javascript:void(0);">...</i></a>';
        }
        $html .= '</ul>';

        return $html;
    } // end getListMultiple

    public function onSearchFilter(&$db, $value)
    {
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        // TODO: review
        // FIXME: separate templates
        $input = view('admin::tb.input.image_upload');
        $input->value   = $this->getValue($row);
        $input->source  = json_decode($this->getValue($row), true);
        $input->attributes = $this->getAttribute('img_attributes', array());
        $input->name    = $this->getFieldName();
        $input->caption = $this->getAttribute('caption');
        $input->is_multiple = $this->getAttribute('is_multiple');
        $input->delimiter   = $this->getAttribute('delimiter');
        

        return $input->render();
    } // end getEditInput
    
    public function doUpload($file)
    {
        $extension = $file->guessExtension();
        $rawFileName = md5_file($file->getRealPath()) .'_'. time();
        $fileName = $rawFileName .'.'. $extension;
        
        $definitionName = $this->definition->getOption('def_name');
        $destinationPath = 'storage/jarboe-temp/';
        
        $status = $file->move($destinationPath, $fileName);
        
        $data = array();
        $data['sizes']['original'] = $destinationPath . $fileName;
        
        $variations = $this->getAttribute('variations', array());
        foreach ($variations as $type => $methods) {
            $img = Image::make($data['sizes']['original']);
            foreach ($methods as $method => $args) {
                call_user_func_array(array($img, $method), $args);
            }
            
            $path = $destinationPath . $rawFileName .'_'. $type .'.'. $extension;
            $quality = $this->getAttribute('quality', 100);
            $img->save(public_path() .'/'. $path, $quality);
            $data['sizes'][$type] = $path;
        }
        
        $html = view('admin::tb.input.image_upload_image')
                    ->with('is_multiple', $this->getAttribute('is_multiple'))
                    ->with('data', $data)
                    ->with('name', $this->getFieldName())
                    ->with('attributes', $this->getAttribute('img_attributes', array()))
                    ->render();
        
        $response = array(
            'data'       => $data,
            'html'       => $html,
            'status'     => $status,
            'link'       => asset($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName,
            // FIXME: naughty hack
            'delimiter' => ','
        );
        return $response;
    } // end doUpload
    
    public function prepareQueryValue($value)
    {
        if (!$value) {
            return '';
        }

        if ($this->getAttribute('is_multiple')) {
            $value = array_values($value);
        }
        
        return json_encode($value);
    } // end prepareQueryValue
    
    public function afterInsert($id, $values) 
    {
        $this->moveImagesFromTempDir($id, $values);
    } // end afterInsert
    
    public function afterUpdate($id, $values) 
    {
        $this->moveImagesFromTempDir($id, $values);
    } // end afterUpdate
    
    private function moveImagesFromTempDir($id, $values) 
    {
        if (!$this->getValue($values)) {
            return;
        }
        
        $images = json_decode($this->getValue($values), true);
        
        if (!$this->getAttribute('is_multiple')) {
            $images = [$images];
        }
        
        $prefixPath = 'storage/'. preg_replace('~\\\~', '_', $this->definition->getName()) .'/';
        foreach ($images as &$image) {
            foreach ($image['sizes'] as &$path) {
                if (preg_match('~storage/jarboe-temp/~', $path)) {
                    $newPath = $prefixPath . get_path_by_id($id);
                    
                    if (!is_dir(public_path($newPath))) {
                        mkdir(public_path($newPath), 0766, true); 
                    }
                    
                    $pathSegments = explode('/', $path);
                    $fileName = end($pathSegments);
                    
                    rename(public_path($path), public_path($newPath . $fileName));
                    
                    $path = $newPath . $fileName;
                }
            }
        }
        
        if (!$this->getAttribute('is_multiple')) {
            $images = $images[0];
        }
        
        // FIXME:
        DB::table($this->definition->getDatabaseOption('table'))->where('id', $id)->update(array(
            $this->getFieldName() => json_encode($images)
        ));
    } // end moveImagesFromTempDir

}

<?php 

namespace Yaro\Jarboe\Fields;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;


class ImageField extends AbstractField 
{

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
        
        $source = json_decode($this->getValue($row), true);
        
        $src = $this->getAttribute('before_link')
              . $source['sizes']['original']
              . $this->getAttribute('after_link');
              
        // FIXME: move to template
        $src = $this->getAttribute('is_remote') ? $src : URL::asset($src);
        $html = '<img height="'.$this->getAttribute('img_height', '50px').'" src="'
              . $src
              . '" />';
        return $html;
    } // end getListSingle    
    
    private function getListMultiple($row)
    {
        if (!$this->getValue($row)) {
            return '';
        }
        
        $images = json_decode($this->getValue($row), true);
        
        // FIXME: fix fixfix
        $html = '<div style="cursor:pointer;height: 50px;overflow: hidden;" onclick="$(this).css(\'height\', \'auto\').css(\'overflow\', \'auto\');">';
        foreach ($images as $source) {
            $src = $this->getAttribute('before_link')
                  . $source['sizes']['original']
                  . $this->getAttribute('after_link');
                  
            // FIXME: move to template
            $src = $this->getAttribute('is_remote') ? $src : URL::asset($src);
            $html .= '<img height="'. $this->getAttribute('img_height', '50px') .'" src="'
                  . $src
                  . '" /><br>';
        }

        $html .= '</div>';

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
        
        if (!$this->getAttribute('is_upload')) {
            return parent::getEditInput($row);
        }
        
        // TODO: review
        // FIXME: separate templates
        $input = View::make('admin::tb.input_image_upload');
        $input->value   = $this->getValue($row);
        $input->source  = json_decode($this->getValue($row), true);
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
        
        $definitionName = $this->getOption('def_name');
        $prefixPath = 'storage/tb-'.$definitionName.'/';
        // FIXME: generate path by hash
        $postfixPath = date('Y') .'/'. date('m') .'/'. date('d') .'/';
        $destinationPath = $prefixPath . $postfixPath;
        
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
        
        $response = array(
            'data'       => $data,
            'status'     => $status,
            'link'       => URL::asset($destinationPath . $fileName),
            'short_link' => $destinationPath . $fileName,
            // FIXME: naughty hack
            'delimiter' => ','
        );
        return $response;
    } // end doUpload
    
    public function prepareQueryValue($value)
    {
        $vals = json_decode($value, true);
        if ($vals && $this->getAttribute('is_multiple')) {
            foreach ($vals as $key => $image) {
                if (isset($image['remove']) && $image['remove']) {
                    unset($vals[$key]);
                }
            }
            // HACK: cuz we have object instead of array
            $value = json_encode(array_values($vals));
        } elseif ($vals) {
            if (isset($vals['remove']) && $vals['remove']) {
                $value = '';
            }
        }
        
        return $value;
    } // end prepareQueryValue

}

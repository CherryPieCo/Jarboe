<?php 

namespace Yaro\Jarboe\Fields;

use Jarboe;


class WysiwygField extends AbstractField 
{

    protected function onAssets()
    {
        $method = 'on_assets_for_'. $this->getAttribute('wysiwyg', 'redactor');
        $method = camel_case($method);
        
        $this->$method();
    } // end onAssets
    
    private function onAssetsForRedactor()
    {
        Jarboe::addAsset('css', 'packages/yaro/jarboe/js/plugin/redactor/redactor.css');
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/redactor/redactor.min.js');
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/redactor/table.js');
        // FIXME: image storage
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/redactor/imagemanager.js');
    } // end onAssetsForRedactor
    
    private function onAssetsForSummernote()
    {
        Jarboe::addAsset('css', 'packages/yaro/jarboe/css/summernote.css');
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/summernote/summernote.min.js');
        // FIXME: translation for js plugins
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/summernote/lang/summernote-ru-RU.js');
    } // end onAssetsForSummernote

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
        
        return mb_substr(strip_tags($this->getValue($row)), 0, 300) . '...';
    } // end getListValue
    
    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }

        $wysiwyg = $this->getAttribute('wysiwyg', 'redactor');

        $input = view('admin::tb.input.wysiwyg' .'_'. $wysiwyg);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->options = $this->getWysiwygOptions();
        $input->extraOptions = $this->getWysiwygOptions();
        
        $action = $this->definition->getOption('action_url') ?: request()->url();
        if ($this->definition->getOption('action_url_tree')) {
            $action = $this->definition->getOption('action_url_tree');
        }
        $input->action = $action;

        return $input->render();
    } // end getEditInput
    
    private function getWysiwygOptions()
    {
        // FIXME:
        $options = $this->getAttribute('editor-options', array());
        
        if ($this->getAttribute('wysiwyg', 'redactor') == 'summernote') {
            if (!array_key_exists('lang', $options)) {
                $options['lang'] = 'ru-RU';
            }
            
            if (!array_key_exists('height', $options)) {
                $options['height'] = 200;
            }
            if (!array_key_exists('minHeight', $options)) {
                $options['minHeight'] = null;
            }
            if (!array_key_exists('maxHeight', $options)) {
                $options['maxHeight'] = null;
            }
        }
        
        
        foreach ($options as &$option) {
            if (preg_match('~^(\d+)$~', $option)) {
                $option = $option;
            } elseif (preg_match('~^(true|false)$~', $option)) {
                $option = $option;
            } elseif (preg_match('~^\[.+\]$~', $option)) {
                $option = $option;
            } else {
                $option = "'". $option ."'";
            }
        }
        
        return $options;
    } // end getWysiwygOptions
    
    public function getTabbedEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetTabbedEditInput')) {
            $res = $this->handler->onGetTabbedEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $wysiwyg = $this->getAttribute('wysiwyg', 'redactor');
        
        $input = view('admin::tb.tab_input_wysiwyg' .'_'. $wysiwyg);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->options = $this->getWysiwygOptions();
        $input->extraOptions = $this->getWysiwygOptions();
        $input->tabs = $this->getPreparedTabs($row);
        $input->caption = $this->getAttribute('caption');
        
        $action = $this->definition->getOption('action_url') ?: request()->url();
        if ($this->definition->getOption('action_url_tree')) {
            $action = $this->definition->getOption('action_url_tree');
        }
        $input->action = $action;
        // HACK: for tabs right behaviour in edit-create modals
        $input->pre = $row ? 'e' : 'c';
        
        
        return $input->render();
    } // end getTabbedEditInput

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition->getDbOption('table');
        $tabs = $this->getAttribute('tabs');
        if ($tabs) {
            $field = $table .'.'. $this->getFieldName();
            $db->where(function($query) use($field, $value, $tabs) {
                foreach ($tabs as $tab) {
                    $query->orWhere($field . $tab['postfix'], 'LIKE', '%'.$value.'%');
                }
            });
        } else {
            $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
        }
    } // end onSearchFilter

}

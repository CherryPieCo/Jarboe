<?php 

namespace Yaro\TableBuilder\Fields;


class WysiwygField extends AbstractField {

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

        $wysiwyg = $this->getAttribute('wysiwyg', 'summernote');

        $input = \View::make('admin::tb.input_wysiwyg' .'_'. $wysiwyg);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->options = $this->getWysiwygOptions();
        
        $input->action = $this->definition['options']['action_url'];

        return $input->render();
    } // end getEditInput
    
    private function getWysiwygOptions()
    {
        $options = $this->getAttribute('editor-options', array());
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
        
        $wysiwyg = $this->getAttribute('wysiwyg', 'summernote');
        
        $input = \View::make('admin::tb.tab_input_wysiwyg' .'_'. $wysiwyg);
        $input->value = $this->getValue($row);
        $input->name  = $this->getFieldName();
        $input->options = $this->getWysiwygOptions();
        $input->tabs = $this->getPreparedTabs($row);
        $input->caption = $this->getAttribute('caption');
        $input->action = $this->definition['options']['action_url'];
        // HACK: for tabs right behaviour in edit-create modals
        $input->pre = $row ? 'e' : 'c';
        
        
        return $input->render();
    } // end getTabbedEditInput

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
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

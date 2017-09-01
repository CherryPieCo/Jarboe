<?php 

namespace Yaro\Jarboe\Fields;

use Jarboe;


class CodeField extends AbstractField 
{

    protected function onAssets()
    {
        $language = $this->getAttribute('language', '');
        $theme = $this->getAttribute('theme', 'darkula');
        
        Jarboe::addAsset('css', 'packages/yaro/jarboe/js/plugin/highlight-8.7/styles/'. $theme .'.css');
        Jarboe::addAsset('js', 'packages/yaro/jarboe/js/plugin/highlight-8.7/highlight.js');
    } // end onAssets

    public function getEditInput($row = array())
    {
        if ($this->hasCustomHandlerMethod('onGetEditInput')) {
            $res = $this->handler->onGetEditInput($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        $value = $this->getValue($row);
        $language = $this->getAttribute('language', '');
        
        return view('admin::tb.input.code', compact('value', 'language'))->render();
    } // end getEditInput
    
    public function getListValue($row)
    {
        if ($this->hasCustomHandlerMethod('onGetListValue')) {
            $res = $this->handler->onGetListValue($this, $row);
            if ($res) {
                return $res;
            }
        }
        
        return mb_substr($this->getValue($row), 0, 300) . '...';
    } // end getListValue
    
    public function isReadonly()
    {
        return true;
    } // end isReadonly

    public function isEditable()
    {
        return false;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
        $table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
}

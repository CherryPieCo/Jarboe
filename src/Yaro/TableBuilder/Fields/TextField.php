<?php 

namespace Yaro\TableBuilder\Fields;

use Illuminate\Support\Facades\View;


class TextField extends AbstractField {

    public function isEditable()
    {
        return true;
    } // end isEditable

    public function onSearchFilter(&$db, $value)
    {
    	$table = $this->definition['db']['table'];
        $db->where($table .'.'. $this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getSubActions()
    {
        $def = $this->getAttribute('subactions');
        if (!$def) {
            return '';
        }
        
        $subactions = array();
        foreach ($def as $options) {
            $class = '\\Yaro\\TableBuilder\\Fields\\Subactions\\'. ucfirst($options['type']);
            $subactions[] = new $class($options);
        }
        
        return View::make('admin::tb.subactions', compact('subactions'))->render();
    } // end getSubActions

}

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
        $db->where($this->getFieldName(), 'LIKE', '%'.$value.'%');
    } // end onSearchFilter
    
    public function getSubActions()
    {
        $subactions = $this->getAttribute('subactions');
        if (!$subactions) {
            return '';
        }
        
        return View::make('admin::tb.subactions', compact('subactions'))->render();
    } // end getSubActions

}

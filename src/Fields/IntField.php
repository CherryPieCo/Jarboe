<?php 

namespace Yaro\Jarboe\Fields;

use Illuminate\Support\Facades\View;


class IntField extends TextField 
{

    public function isEditable()
    {
        return true;
    } // end isEditable

}

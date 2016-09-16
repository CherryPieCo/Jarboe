<?php

namespace Yaro\Jarboe\Models;

use Cartalyst\Sentinel\Users\EloquentUser;


class User extends EloquentUser
{
    
    public function isSuperuser()
    {
        return $this->hasAccess('superuser', false);
    } // end isSuperuser
    
    public function hasAccess($permission, $forceCheckIfSuperuser = true)
    {
        if ($forceCheckIfSuperuser && $this->isSuperuser()) {
            return true;
        }
        
        
        return parent::hasAccess($permission);
    } // end hasAccess

}

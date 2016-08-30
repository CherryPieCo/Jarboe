<?php

namespace Yaro\Jarboe\Http\Controllers;

use Jarboe;


class UsersController extends \App\Http\Controllers\Controller
{
    
    public function users()
    {
        return Jarboe::table([
            'url'      => '/admin/users/users',
            'def_name' => 'users',
        ]);
    } // end users
    
    public function groups()
    {
        return Jarboe::table([
            'url'      => '/admin/users/groups',
            'def_name' => 'groups',
        ]);
    } // end groups
        
}

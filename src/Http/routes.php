<?php

// FIXME: check user permissions
Route::group(array('prefix' => config('jarboe.admin.uri'), 'before' => array('auth_admin', 'check_permissions')), function() {

    // docs page
    Route::get('/', 'Yaro\Jarboe\Http\TBController@showDashboard');

    // logout
    Route::get('logout', 'Yaro\Jarboe\Http\TBController@doLogout');

    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\Jarboe\Http\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\Jarboe\Http\TBController@doEmbedToText');
    
    // elfinder
    //Route::any('tb/elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
    
    
    // informer
    Route::post('tb/informer/get-notification', 'Yaro\Jarboe\Http\TBController@getInformNotification');
    Route::post('tb/informer/get-notification-counts', 'Yaro\Jarboe\Http\TBController@getInformNotificationCounts');
    
    // menu
    Route::post('tb/menu/collapse', 'Yaro\Jarboe\Http\TBController@doSaveMenuPreference');
    
    // structure
    Route::post('tb/structure/save/height', 'Yaro\Jarboe\Http\TBController@doSaveStructureHeight');
    /*
    // FIXME: access permission check
    // users
    //Route::get('tb/users', 'Yaro\Jarboe\Http\TBUsersController@showUsers');
    //Route::post('tb/users/delete', 'Yaro\Jarboe\Http\TBUsersController@doDeleteUser');
    Route::get('tb/users/{id}', 'Yaro\Jarboe\Http\TBUsersController@showEditUser')->where('id', '[0-9]+');
    Route::post('tb/users/update', 'Yaro\Jarboe\Http\TBUsersController@doUpdateUser');
    Route::get('tb/users/create', 'Yaro\Jarboe\Http\TBUsersController@showCreateUser');
    Route::post('tb/users/do-create', 'Yaro\Jarboe\Http\TBUsersController@doCreateUser');
    Route::get('tb/groups/{id}', 'Yaro\Jarboe\Http\TBUsersController@showEditGroup')->where('id', '[0-9]+');
    Route::post('tb/groups/update', 'Yaro\Jarboe\Http\TBUsersController@doUpdateGroup');
    Route::get('tb/groups/create', 'Yaro\Jarboe\Http\TBUsersController@showCreateGroup');
    Route::post('tb/groups/do-create', 'Yaro\Jarboe\Http\TBUsersController@doCreateGroup');
    Route::post('tb/users/upload-image', 'Yaro\Jarboe\Http\TBUsersController@doUploadImage');
    
    // tree
    /*
    Route::get('tb/tree', 'Yaro\Jarboe\Http\TBTreeController@showTree');
    Route::post('tb/tree', 'Yaro\Jarboe\Http\TBTreeController@handleTree');
    Route::post('tb/tree/change-pos', 'Yaro\Jarboe\Http\TBTreeController@changePosition');
    Route::post('tb/tree/change-active', 'Yaro\Jarboe\Http\TBTreeController@changeActive');
    Route::post('tb/tree/node/create', 'Yaro\Jarboe\Http\TBTreeController@doCreateNode');
    Route::post('tb/tree/node/edit', 'Yaro\Jarboe\Http\TBTreeController@doEditNode');
    Route::post('tb/tree/node/delete', 'Yaro\Jarboe\Http\TBTreeController@doDeleteNode');
    Route::post('tb/tree/node/get-edit', 'Yaro\Jarboe\Http\TBTreeController@getEditModalForm');
    Route::post('tb/tree/node/change-inline', 'Yaro\Jarboe\Http\TBTreeController@doUpdateNode');
    */
});

// login
Route::get('/login', 'Yaro\Jarboe\Http\TBController@showLogin');
Route::post('/login', 'Yaro\Jarboe\Http\TBController@postLogin');


Route::get('developed/by/yaro', function() {
    return view('admin::welcome'); 
});

/*
//
function recurse_my_tree($tree, $node, &$slugs = array()) {
    if (!$node['parent_id']) {
        return $node['slug'];
    }

    $slugs[] = $node['slug'];
    $idParent = $node['parent_id'];
    if ($idParent) {
        $parent = $tree[$idParent];
        recurse_my_tree($tree, $parent, $slugs);
    }

    return implode('/', array_reverse($slugs));
}
// tree
if (config('jarboe.tree.is_active')) {
    
    // FIXME: too ugly to execute
    $_tbTree = \Cache::tags(array('jarboe', 'j_tree'))->get('j_tree');
    if ($_tbTree) {
        foreach ($_tbTree as $node) {
            Route::get($node->getUrl(), function() use($node)
            {
                $templates = config('jarboe.tree.templates');
                if (!isset($templates[$node->template])) {
                    // just to be gentle with web crawlers
                    App::abort(404);
                }
                list($controller, $method) = explode('@', $templates[$node->template]['action']);
    
                $app = app();
                $controller = $app->make($controller);
                return $controller->callAction('init', array($node, $method));
            });
        }
    } else {
        $_model = config('jarboe.tree.model');
        $_nodeUrl = '';
        $_tbTree  = $_model::all();
        $_clone   = clone $_tbTree;
        $_clone   = $_clone->toArray();
        //
        $_ids = array();
        foreach ($_clone as $cl) {
            $_ids[] = $cl['id'];
        }
        $_clone = array_combine($_ids, $_clone);
        //$clone = array_combine(array_column($_clone, 'id'), $_clone);
    
        foreach ($_tbTree as $node) {
            $_nodeUrl = recurse_my_tree($_clone, $node);
            $node->setUrl($_nodeUrl);
            
            Route::get($_nodeUrl, function() use($node)
            {
                $templates = config('jarboe.tree.templates');
                if (!isset($templates[$node->template])) {
                    // just to be gentle with web crawlers
                    App::abort(404);
                }
                list($controller, $method) = explode('@', $templates[$node->template]['action']);
    
                $app = app();
                $controller = $app->make($controller);
                return $controller->callAction('init', array($node, $method));
            });
        }
    
        \Cache::tags(array('jarboe', 'j_tree'))->put('j_tree', $_tbTree, 1440);
    }


    unset($_ids);
    unset($_clone);
    unset($_nodeUrl);
    unset($_tbTree);
    unset($_model);
}






// devel fallback
Route::get('/thereisnospoon', 'Yaro\Jarboe\Http\DevelController@showMain');
Route::post('/thereisnospoon', 'Yaro\Jarboe\Http\DevelController@handleMain');

*/

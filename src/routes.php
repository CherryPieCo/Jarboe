<?php

// FIXME: check user permissions
Route::group(array('prefix' => Config::get('table-builder::admin.uri'), 'before' => array('auth_admin', 'check_permissions')), function() {

    // docs page
    Route::get('/', 'Yaro\TableBuilder\TBController@showDashboard');

    // logout
    Route::get('logout', 'Yaro\TableBuilder\TBController@doLogout');

    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\TableBuilder\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\TableBuilder\TBController@doEmbedToText');
    
    // elfinder
    Route::any('tb/elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
    
    
    // informer
    Route::post('tb/informer/get-notification', 'Yaro\TableBuilder\TBController@getInformNotification');
    Route::post('tb/informer/get-notification-counts', 'Yaro\TableBuilder\TBController@getInformNotificationCounts');
    
    // menu
    Route::post('tb/menu/collapse', 'Yaro\TableBuilder\TBController@doSaveMenuPreference');
    
    // FIXME: access permission check
    // users
    //Route::get('tb/users', 'Yaro\TableBuilder\TBUsersController@showUsers');
    //Route::post('tb/users/delete', 'Yaro\TableBuilder\TBUsersController@doDeleteUser');
    Route::get('tb/users/{id}', 'Yaro\TableBuilder\TBUsersController@showEditUser')->where('id', '[0-9]+');
    Route::post('tb/users/update', 'Yaro\TableBuilder\TBUsersController@doUpdateUser');
    Route::get('tb/users/create', 'Yaro\TableBuilder\TBUsersController@showCreateUser');
    Route::post('tb/users/do-create', 'Yaro\TableBuilder\TBUsersController@doCreateUser');
    Route::get('tb/groups/{id}', 'Yaro\TableBuilder\TBUsersController@showEditGroup')->where('id', '[0-9]+');
    Route::post('tb/groups/update', 'Yaro\TableBuilder\TBUsersController@doUpdateGroup');
    Route::get('tb/groups/create', 'Yaro\TableBuilder\TBUsersController@showCreateGroup');
    Route::post('tb/groups/do-create', 'Yaro\TableBuilder\TBUsersController@doCreateGroup');
    Route::post('tb/users/upload-image', 'Yaro\TableBuilder\TBUsersController@doUploadImage');
    
    // tree
    /*
    Route::get('tb/tree', 'Yaro\TableBuilder\TBTreeController@showTree');
    Route::post('tb/tree', 'Yaro\TableBuilder\TBTreeController@handleTree');
    Route::post('tb/tree/change-pos', 'Yaro\TableBuilder\TBTreeController@changePosition');
    Route::post('tb/tree/change-active', 'Yaro\TableBuilder\TBTreeController@changeActive');
    Route::post('tb/tree/node/create', 'Yaro\TableBuilder\TBTreeController@doCreateNode');
    Route::post('tb/tree/node/edit', 'Yaro\TableBuilder\TBTreeController@doEditNode');
    Route::post('tb/tree/node/delete', 'Yaro\TableBuilder\TBTreeController@doDeleteNode');
    Route::post('tb/tree/node/get-edit', 'Yaro\TableBuilder\TBTreeController@getEditModalForm');
    Route::post('tb/tree/node/change-inline', 'Yaro\TableBuilder\TBTreeController@doUpdateNode');
    */
});

// login
Route::get('/login', 'Yaro\TableBuilder\TBController@showLogin');
Route::post('/login', 'Yaro\TableBuilder\TBController@postLogin');



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
if (\Config::get('table-builder::tree.is_active')) {
    $_nodeUrl = '';
    $_tbTree  = Yaro\TableBuilder\Tree::all();
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
        Route::get($_nodeUrl, function() use ($node)
        {
            $templates = Config::get('table-builder::tree.templates');
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

    unset($_ids);
    unset($_clone);
    unset($_nodeUrl);
    unset($_tbTree);
}






// devel fallback
Route::get('/thereisnospoon', 'Yaro\TableBuilder\DevelController@showMain');
Route::post('/thereisnospoon', 'Yaro\TableBuilder\DevelController@handleMain');



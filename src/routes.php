<?php

// FIXME: check user permissions
Route::group(array('prefix' => Config::get('jarboe::admin.uri'), 'before' => array('auth_admin', 'check_permissions')), function() {

    // docs page
    Route::get('/', 'Yaro\Jarboe\TBController@showDashboard');

    // logout
    Route::get('logout', 'Yaro\Jarboe\TBController@doLogout');

    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\Jarboe\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\Jarboe\TBController@doEmbedToText');
    
    // elfinder
    Route::any('tb/elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
    
    
    // informer
    Route::post('tb/informer/get-notification', 'Yaro\Jarboe\TBController@getInformNotification');
    Route::post('tb/informer/get-notification-counts', 'Yaro\Jarboe\TBController@getInformNotificationCounts');
    
    // menu
    Route::post('tb/menu/collapse', 'Yaro\Jarboe\TBController@doSaveMenuPreference');
    
    // FIXME: access permission check
    // users
    //Route::get('tb/users', 'Yaro\Jarboe\TBUsersController@showUsers');
    //Route::post('tb/users/delete', 'Yaro\Jarboe\TBUsersController@doDeleteUser');
    Route::get('tb/users/{id}', 'Yaro\Jarboe\TBUsersController@showEditUser')->where('id', '[0-9]+');
    Route::post('tb/users/update', 'Yaro\Jarboe\TBUsersController@doUpdateUser');
    Route::get('tb/users/create', 'Yaro\Jarboe\TBUsersController@showCreateUser');
    Route::post('tb/users/do-create', 'Yaro\Jarboe\TBUsersController@doCreateUser');
    Route::get('tb/groups/{id}', 'Yaro\Jarboe\TBUsersController@showEditGroup')->where('id', '[0-9]+');
    Route::post('tb/groups/update', 'Yaro\Jarboe\TBUsersController@doUpdateGroup');
    Route::get('tb/groups/create', 'Yaro\Jarboe\TBUsersController@showCreateGroup');
    Route::post('tb/groups/do-create', 'Yaro\Jarboe\TBUsersController@doCreateGroup');
    Route::post('tb/users/upload-image', 'Yaro\Jarboe\TBUsersController@doUploadImage');
    
    // tree
    /*
    Route::get('tb/tree', 'Yaro\Jarboe\TBTreeController@showTree');
    Route::post('tb/tree', 'Yaro\Jarboe\TBTreeController@handleTree');
    Route::post('tb/tree/change-pos', 'Yaro\Jarboe\TBTreeController@changePosition');
    Route::post('tb/tree/change-active', 'Yaro\Jarboe\TBTreeController@changeActive');
    Route::post('tb/tree/node/create', 'Yaro\Jarboe\TBTreeController@doCreateNode');
    Route::post('tb/tree/node/edit', 'Yaro\Jarboe\TBTreeController@doEditNode');
    Route::post('tb/tree/node/delete', 'Yaro\Jarboe\TBTreeController@doDeleteNode');
    Route::post('tb/tree/node/get-edit', 'Yaro\Jarboe\TBTreeController@getEditModalForm');
    Route::post('tb/tree/node/change-inline', 'Yaro\Jarboe\TBTreeController@doUpdateNode');
    */
});

// login
Route::get('/login', 'Yaro\Jarboe\TBController@showLogin');
Route::post('/login', 'Yaro\Jarboe\TBController@postLogin');



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
if (\Config::get('jarboe::tree.is_active')) {
    $_nodeUrl = '';
    $_tbTree  = Yaro\Jarboe\Tree::all();
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
            $templates = Config::get('jarboe::tree.templates');
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
Route::get('/thereisnospoon', 'Yaro\Jarboe\DevelController@showMain');
Route::post('/thereisnospoon', 'Yaro\Jarboe\DevelController@handleMain');



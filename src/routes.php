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
        
});

// login
Route::get('/login', 'Yaro\TableBuilder\TBController@showLogin');
Route::post('/login', 'Yaro\TableBuilder\TBController@postLogin');

// devel fallback
Route::get('/thereisnospoon', 'Yaro\TableBuilder\DevelController@showMain');
Route::post('/thereisnospoon', 'Yaro\TableBuilder\DevelController@handleMain');

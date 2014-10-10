<?php

// FIXME: check user permissions
Route::group(array('prefix' => Config::get('table-builder::admin.uri')), function() {

    // logout
    Route::get('logout', 'Yaro\TableBuilder\TBController@doLogout');

    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\TableBuilder\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\TableBuilder\TBController@doEmbedToText');
    
    // informer
    Route::post('tb/informer/get-notification', 'Yaro\TableBuilder\TBController@getInformNotification');
    Route::post('tb/informer/get-notification-counts', 'Yaro\TableBuilder\TBController@getInformNotificationCounts');
    
    // users
    Route::get('tb/users', 'Yaro\TableBuilder\TBUsersController@showUsers');
    Route::get('tb/users/{id}', 'Yaro\TableBuilder\TBUsersController@showEditUser')->where('id', '[0-9]+');
    Route::get('tb/users/create', 'Yaro\TableBuilder\TBUsersController@showCreateUser');
    Route::post('tb/users/do-create', 'Yaro\TableBuilder\TBUsersController@doCreateUser');
    Route::post('tb/users/update', 'Yaro\TableBuilder\TBUsersController@doUpdateUser');
    Route::post('tb/users/delete', 'Yaro\TableBuilder\TBUsersController@doDeleteUser');
    Route::post('tb/users/upload-image', 'Yaro\TableBuilder\TBUsersController@doUploadImage');
        
});

// login
Route::get('/login', 'Yaro\TableBuilder\TBController@showLogin');
Route::post('/login', 'Yaro\TableBuilder\TBController@postLogin');
<?php

Route::group(array('prefix' => config('jarboe.admin.uri'), 'before' => array('auth_admin', 'check_permissions')), function() {

    // docs page
    Route::get('/', 'Yaro\Jarboe\Http\Controllers\TBController@showDashboard');

    // logout
    Route::get('logout', 'Yaro\Jarboe\Http\Controllers\TBController@doLogout');

    // TODO: move to plugins
    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\Jarboe\Http\Controllers\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\Jarboe\Http\Controllers\TBController@doEmbedToText');
    
    // informer
    Route::post('tb/informer/get-notification', 'Yaro\Jarboe\Http\Controllers\TBController@getInformNotification');
    Route::post('tb/informer/get-notification-counts', 'Yaro\Jarboe\Http\Controllers\TBController@getInformNotificationCounts');
    
    // menu
    Route::post('tb/menu/collapse', 'Yaro\Jarboe\Http\Controllers\TBController@doSaveMenuPreference');
    
    // structure
    Route::post('tb/structure/save/height', 'Yaro\Jarboe\Http\Controllers\TBController@doSaveStructureHeight');
    
});

// login
Route::get('/login', 'Yaro\Jarboe\Http\Controllers\TBController@showLogin');
Route::post('/login', 'Yaro\Jarboe\Http\Controllers\TBController@postLogin');


Route::get('developed/by/yaro', function() {
    return view('admin::welcome'); 
});


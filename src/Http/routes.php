<?php

Route::group([
    'prefix' => config('jarboe.admin.uri'), 
    'middleware' => [
        'web',
        Yaro\Jarboe\Http\Middleware\AuthAdmin::class, 
        Yaro\Jarboe\Http\Middleware\CheckPermissions::class,
    ]
], function() {

    // docs page
    Route::get('/', 'Yaro\Jarboe\Http\Controllers\TBController@showDashboard');

    Route::get('logout', 'Yaro\Jarboe\Http\Controllers\TBController@doLogout');

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

    Route::any('users/users', 'Yaro\Jarboe\Http\Controllers\UsersController@users');
    Route::any('users/groups', 'Yaro\Jarboe\Http\Controllers\UsersController@groups');
    
});


Route::group([
    'middleware' => [
        'web', 
        App\Http\Middleware\VerifyCsrfToken::class
    ]
], function() {
    
    // login
    Route::get('/login', 'Yaro\Jarboe\Http\Controllers\TBController@showLogin');
    Route::post('/login', 'Yaro\Jarboe\Http\Controllers\TBController@postLogin');
    
});


Route::get('powered/by/jarboe', function() {
    return view('admin::welcome'); 
});


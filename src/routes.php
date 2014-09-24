<?php

// FIXME: check user permissions
Route::group(array('prefix' => Config::get('table-builder::admin.uri')), function() {

    // logout
    Route::get('logout', 'Yaro\TableBuilder\TBController@doLogout');

    // wysiwyg helpers
    Route::post('tb/get-html-by-url', 'Yaro\TableBuilder\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\TableBuilder\TBController@doEmbedToText');
    
});

// login
Route::get('/login', 'Yaro\TableBuilder\TBController@showLogin');
Route::post('/login', 'Yaro\TableBuilder\TBController@postLogin');
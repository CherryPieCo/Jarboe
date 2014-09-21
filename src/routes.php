<?php

// FIXME: check user permissions
Route::group(array('prefix' => Config::get('table-builder::admin.uri')), function() {

    Route::post('tb/get-html-by-url', 'Yaro\TableBuilder\TBController@fetchByUrl');
    Route::post('tb/embed-to-text', 'Yaro\TableBuilder\TBController@doEmbedToText');
    
});
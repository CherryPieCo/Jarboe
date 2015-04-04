<?php

Route::group(array(
    'prefix' => Config::get('jarboe::admin.uri'), 
    'before' => array(
        'auth_admin', 
        'check_permissions'
    )
), function () {

    Route::get('/settings', 'TableAdminController@showSettings');
    Route::post('/handle/settings', 'TableAdminController@handleSettings');
    
    Route::any('/tree', 'TableAdminController@showTree');
    Route::any('/handle/tree', 'TableAdminController@handleTree');

});


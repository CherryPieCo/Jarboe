<?php

Route::group(array(
    'prefix' => Config::get('table-builder::admin.uri'), 
    'before' => array(
        'auth_admin', 
        'check_permissions'
    )
), function () {

    Route::get('/settings', 'TableAdminController@showSettings');
    Route::post('/handle/settings', 'TableAdminController@handleSettings');
    
    Route::get('/tree', 'TableAdminController@showTree');
    Route::post('/handle/tree', 'TableAdminController@handleTree');

});


<?php

Route::group(array(
    'prefix' => config('jarboe.admin.uri'), 
    'before' => array(
        'auth_admin', 
        'check_permissions'
    )
), function () {

    Route::any('/settings', 'TableAdminController@settings');
    Route::any('/settings/trash', 'TableAdminController@settingsTrash');

});

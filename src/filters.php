<?php


//
Route::filter('check_permissions', function()
{
    Jarboe::checkNavigationPermissions();
});

Route::filter('auth_admin', function()
{
    if (!Sentinel::check()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }
        
    if (!Sentinel::hasAccess('superuser')) {
        // FIXME:
        if (!Sentinel::inRole('admin')) {
            if (Request::ajax()) {
                return Response::make('Unauthorized', 401);
            } else {
                return Redirect::guest('/');
            }
        }
    }
});





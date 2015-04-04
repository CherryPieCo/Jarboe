<?php


//
Route::filter('check_permissions', function()
{
    if (Request::isMethod('get')) {
        Jarboe::checkNavigationPermissions();
    }
});

Route::filter('auth_admin', function()
{
    if (!Sentry::check()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    } else {
        if (!Sentry::getUser()->isSuperUser()) {
            // FIXME:
            $admin = Sentry::findGroupByName('admin');
            if (!Sentry::getUser()->inGroup($admin)) {
                if (Request::ajax()) {
                    return Response::make('Unauthorized', 401);
                } else {
                    return Redirect::guest('/');
                }
            }
        }
    }
});



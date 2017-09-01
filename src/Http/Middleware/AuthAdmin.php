<?php

namespace Yaro\Jarboe\Http\Middleware;

use Closure;
use Sentinel;
use Request;
use Response;
use Redirect;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
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
        
        return $next($request);
    }
}

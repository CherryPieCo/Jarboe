<?php

namespace Yaro\Jarboe\Http\Middleware;

use Closure;
use Jarboe;

class CheckPermissions
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
        Jarboe::checkNavigationPermissions();
        
        return $next($request);
    }
}

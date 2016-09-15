<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if(auth($role)->check())
            return $next($request);
        $rdrUrl = '/login';
        $role !== 'admin' ? :'/admin' .  $rdrUrl;
        return redirect($rdrUrl);
    }
}

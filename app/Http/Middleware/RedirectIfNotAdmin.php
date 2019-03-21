<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAdmin
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
        // Note: this middleware is not designed for use in 'middleware' setup only in '$routeMiddleware'

        if($request->user() == null)    // check is user is logged in
        {
            return redirect('login');
        }
        if(!$request->user()->isAdmin()) // check if user is an admin
        {
            return redirect('home');
        }


        return $next($request); // proceed to the next  middleware check
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotSubscriber
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
        if(! $request->user()->isASubscriber()) // check if user is an admin
        {
            return back();
        }


        return $next($request); // proceed to the next  middleware check
    }
}

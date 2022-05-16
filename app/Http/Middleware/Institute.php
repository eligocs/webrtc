<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Institute
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
        if (Auth::user() && auth()->user()->role == 'institute') {
            return $next($request);
        } else {
            return redirect('/institute/login')->with('error', 'You have not admin access');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Student
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
        if(Auth::user() && auth()->user()->role == 'student')
        { 
            return $next($request);
        }
        else
        {
            return redirect('/student/login')->with('error','You dont have student access');
        } 
    }
}

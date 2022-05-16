<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    if (Auth::guard($guard)->check()) {
      switch (auth()->user()->role) {
        case 'student':
          return redirect('/student');
          break;
        case 'institute':
          return redirect('/institute');
          break;
        case 'admin':
          return redirect('/admin');
          break;

        default:
          abort(404);
          break;
      }
      return redirect(RouteServiceProvider::HOME);
    }

    return $next($request);
  }
}

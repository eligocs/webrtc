<?php

namespace App\Http\Middleware;

use Closure;

class CanStudentAccessQuiz
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
      if(!\App\Models\Topic::where(['institute_assigned_class_subject_id' => request()->iacs_id, 'id' => request()->id])->exists())
      abort(404);
      return $next($request);
    }
}

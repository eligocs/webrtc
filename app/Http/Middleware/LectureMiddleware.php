<?php

namespace App\Http\Middleware;

use Closure;

class LectureMiddleware
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
      $iacs_id = request()->i_assigned_class_subject_id ?? request()->iacsId ?? request()->iacs_id;
      $institute_assigned_class_id = \App\Models\InstituteAssignedClassSubject::findOrFail($iacs_id)->institute_assigned_class_id;

      $institute_id = \App\Models\InstituteAssignedClass::findOrFail($institute_assigned_class_id)->institute_id;
      
      if($institute_id != auth()->user()->institute->id){
          abort(404);
      }

      return $next($request);
    }
}

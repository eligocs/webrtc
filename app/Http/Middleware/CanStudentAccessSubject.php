<?php

namespace App\Http\Middleware;

use Closure;

class CanStudentAccessSubject
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
      if(!empty(request()->iacs_id)){
        $iacs = \App\Models\InstituteAssignedClassSubject::findOrFail(request()->iacs_id);
        $class_id = $iacs->institute_assigned_class_id;
      }else if(!empty(request()->class_id)){
        $class_id = request()->class_id;
      }else{
        abort(400);
      }
      
      \App\Models\InstituteAssignedClassStudent::where(['institute_assigned_class_id' => $class_id, 'student_id' => auth()->user()->student_id])->firstOrFail();
      
      return $next($request);
    }
}

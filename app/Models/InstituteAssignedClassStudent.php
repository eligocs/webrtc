<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteAssignedClassStudent extends Model
{
  protected $table = 'institute_assigned_class_student';

  protected $guarded = [];

  public function student()
  {
    return $this->belongsTo(\App\Models\Student::class);
  }
}

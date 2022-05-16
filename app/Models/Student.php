<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  protected $guarded = [];

  public function getAvatarAttribute($value)
  {
    //return config('filesystems.disks.s3.url') . $value;
    return !empty($value) ? config('filesystems.disks.s3.url') . $value :'';
  }

  public function doubt()
  {
    return $this->hasOne(\App\Models\Doubt::class);
  }

  public function institute_assigned_class()
  {
    return $this->belongsToMany(\App\Models\InstituteAssignedClass::class, 'institute_assigned_class_student', 'student_id', 'institute_assigned_class_id');
  }

  public function institute_assigned_classes()
  {
    return $this->belongsToMany(\App\Models\InstituteAssignedClass::class, 'institute_assigned_class_student', 'student_id', 'institute_assigned_class_id')->withPivot(['coupon_applied', 'coupon_id']);
  }

  public function lectures()
  {
    return $this->belongsToMany(\App\Models\Lecture::class, 'student_lecture')->withPivot(['attendence_in_percentage']);
  }

  public function user()
  {
    return $this->hasOne(\App\Models\User::class);
  }

  public function student_subjects_infos()
  {
    return $this->hasMany(\App\Models\StudentSubjectsInfo::class);
  }

   
}
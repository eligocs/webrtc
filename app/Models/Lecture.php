<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
  protected $guarded = [];

  public function getLectureVideoAttribute($value)
  {
    // return config('filesystems.disks.s3.url') . $value;
     return /* config('app.video_link') .  */$value;
    //return $value;
  }

  public function getNotesAttribute($value)
  {
     return /* config('filesystems.disks.s3.url') .  */$value; 
  }

  public function unit()
  {
    return $this->belongsTo(\App\Models\Unit::class);
  }

  public function students()
  {
    return $this->belongsToMany(\App\Models\Student::class, 'student_lecture');
  }

  public function present_students()
  {
    return $this->belongsToMany(\App\Models\Student::class, 'student_lecture')->where('attendence_in_percentage', '>=', 90);
  }
}
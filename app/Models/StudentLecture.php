<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLecture extends Model
{

  protected $table = 'student_lecture';
  protected $guarded = [];

  public function lecture()
  {
    return $this->belongsTo(\App\Models\Lecture::class);
  }
}

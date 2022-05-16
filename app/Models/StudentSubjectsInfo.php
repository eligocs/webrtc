<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSubjectsInfo extends Model
{
    protected $table = 'student_subjects_info';

    protected $guarded = [];

    public function time_slot(){
      return $this->belongsTo(\App\Models\TimeSlot::class);
    }
}

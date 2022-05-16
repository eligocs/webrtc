<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];

    public function institute(){
        return $this->belongsTo(\App\Models\Institute::class);
    }

    public function institute_assigned_class_subjects()
    {
        return $this->belongsToMany(\App\Models\InstituteAssignedClassSubject::class, 'institute_assigned_class_subject_teacher', 'teacher_id', 'institute_assigned_class_subject_id');
    }
    
}

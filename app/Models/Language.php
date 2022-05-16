<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    public function institute_assigned_class(){
      return $this->hasMany(\App\Models\InstituteAssignedClass::class, 'language');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function lectures(){
        return $this->hasMany(\App\Models\Lecture::class)->orderBy('lecture_date','desc');
    }

    public function extra_classes()
    {
      return $this->hasMany(\App\Models\ExtraClass::class)->orderBy('extra_class_date','desc');
    }
}

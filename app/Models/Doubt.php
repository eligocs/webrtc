<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doubt extends Model
{
  protected $guarded = [];

  public function doubt_messages()
  {
    return $this->hasMany(\App\Models\DoubtMessage::class);
  }
  public function student()
  {
    return $this->belongsTo(\App\Models\Student::class);
  }
}

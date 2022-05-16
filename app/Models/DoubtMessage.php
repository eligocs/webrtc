<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoubtMessage extends Model
{
  protected $guarded = [];

  public function getMessageAttribute($value)
  {
    //return config('filesystems.disks.s3.url') . $value;
    return $value;
  }

  public function doubt()
  {
    return $this->belongsTo(\App\Models\Doubt::class);
  }
}
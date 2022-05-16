<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraClass extends Model
{
  protected $guarded = [];

  public function getExtraClassVideoAttribute($value)
  {
    // return config('filesystems.disks.s3.url') . $value;
     //return config('app.video_link') . $value;
    return $value;
   // return  $value;
  }

  public function getNotesAttribute($value)
  {
    //return config('filesystems.disks.s3.url') . $value;
    return  $value;
  }

  public function unit()
  {
    return $this->belongsTo(\App\Models\Unit::class);
  }
}
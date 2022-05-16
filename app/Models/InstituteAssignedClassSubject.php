<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Reliese\Database\Eloquent\Model;

/**
 * Class InstituteAssignedClassSubject
 * 
 * @property int $id
 * @property int $institute_assigned_class_id
 * @property int $subject_id
 * @property string $day
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property InstituteAssignedClass $institute_assigned_class
 * @property Subject $subject
 * @property Collection|SubjectsInfo[] $subjects_infos
 *
 * @package App\Models
 */
class InstituteAssignedClassSubject extends Model
{
  protected $table = 'institute_assigned_class_subject';

  protected $casts = [
    'institute_assigned_class_id' => 'int',
    'subject_id' => 'int'
  ];

  protected $fillable = [
    'institute_assigned_class_id',
    'subject_id',
    'day',
    'publish_date',
    'video',
    'description',
  ];

  public function getVideoAttribute($value)
  {
    // return config('filesystems.disks.s3.url') . $value;
    //return config('app.video_link') . $value;
    return  $value;
  }

  public function institute_assigned_class()
  {
    return $this->belongsTo(InstituteAssignedClass::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function subjects_infos()
  {
    return $this->hasMany(SubjectsInfo::class);
  }

  public function lecture()
  {
    return $this->hasOne(\App\Models\Lecture::class);
  }

  public function units()
  {
    return $this->hasMany(\App\Models\Unit::class);
  }

  public function lectures()
  {
    return $this->hasMany(\App\Models\Lecture::class);
  }

  public function extra_classes()
  {
    return $this->hasMany(\App\Models\ExtraClass::class);
  }

  public function teacher()
  {
    return $this->belongsToMany(\App\Models\Teacher::class);
  }

  public function topics()
  {
    return $this->hasMany(\App\Models\Topic::class);
  }
}
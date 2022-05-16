<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Reliese\Database\Eloquent\Model;

/**
 * Class InstituteAssignedClass
 * 
 * @property int $id
 * @property int $institute_id
 * @property int $category_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $price
 * @property string $language
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Institute $institute
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class InstituteAssignedClass extends Model
{
  protected $table = 'institute_assigned_class';

  protected $casts = [
    'institute_id' => 'int',
    'category_id' => 'int'
  ];

  protected $dates = [
    'start_date',
    'end_date'
  ];

  protected $fillable = [
    'institute_id',
    'category_id',
    'start_date',
    'end_date',
    'price',
    'state',
    'city',
    'board',
    'language',
    'name',
    'freetrial',
    'videoApproval',
    'description',
  ];

  public function getVideoAttribute($value)
  {
    // return config('filesystems.disks.s3.url') . $value;
    //return config('app.video_link') . $value;
    return $value;
  }

  public function institute()
  {
    return $this->belongsTo(Institute::class);
  }

  public function subjects()
  {
    return $this->belongsToMany(Subject::class)
      ->withPivot('id', 'day')
      ->withTimestamps();
  }

  public function institute_assigned_class_subject()
  {
    return $this->hasMany(InstituteAssignedClassSubject::class);
  }
  public function language_table()
  {
    return $this->belongsTo(\App\Models\Language::class, 'language');
  }

  public function students()
  {
    return $this->belongsToMany(\App\Models\Student::class, 'institute_assigned_class_student', 'institute_assigned_class_id', 'student_id')->withPivot(['coupon_applied', 'coupon_id']);
  }

  public function category()
  {
    return $this->belongsTo(\App\Models\Category::class);
  }

  public function applicable()
  {
    return $this->morphMany(\App\Models\Coupon::class, 'applicable');
  }

  public function carts()
  {
    return $this->hasMany(\App\Models\Cart::class);
  }
}
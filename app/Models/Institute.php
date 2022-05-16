<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model;

/**
 * Class Institute
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Collection|InstituteAssignedClass[] $institute_assigned_classes
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Institute extends Model
{
  use SoftDeletes;
  protected $table = 'institutes';

  protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
    'description',
    'video',
  ];

  public function institute_assigned_classes()
  {
    return $this->hasMany(InstituteAssignedClass::class)->orderBy('created_at', 'desc');
  }

  public function students()
  {
    return $this->hasManyThrough(InstituteAssignedClassStudent::class, \App\Models\InstituteAssignedClass::class, 'institute_id', 'institute_assigned_class_id', 'id');
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }

  public function applicable()
  {
    return $this->morphMany(\App\Models\Coupon::class, 'applicable');
  }
}
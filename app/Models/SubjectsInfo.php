<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class SubjectsInfo
 * 
 * @property int $id
 * @property int $institute_assigned_class_subject_id
 * @property string $day
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property InstituteAssignedClassSubject $institute_assigned_class_subject
 *
 * @package App\Models
 */
class SubjectsInfo extends Model
{
  protected $table = 'subjects_info';

  protected $casts = [
    'institute_assigned_class_subject_id' => 'int'
  ];

  protected $fillable = [
    'institute_assigned_class_subject_id',
    'day'
  ];

  public function institute_assigned_class_subject()
  {
    return $this->belongsTo(InstituteAssignedClassSubject::class);
  }

  public function student_subjects_info()
  {
    return $this->hasOne(\App\Models\StudentSubjectsInfo::class);
  }

  public function student_subjects_infos()
  {
    return $this->hasMany(\App\Models\StudentSubjectsInfo::class);
  }
}

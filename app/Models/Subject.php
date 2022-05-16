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
 * Class Subject
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Collection|InstituteAssignedClass[] $institute_assigned_classes
 * @property Collection|SubjectClass[] $subject_classes
 * @property Collection|Category[] $categories
 *
 * @package App\Models
 */
class Subject extends Model
{
	use SoftDeletes;
	protected $table = 'subjects';

	protected $fillable = [
		'name'
	];

	public function institute_assigned_classes()
	{
		return $this->belongsToMany(InstituteAssignedClass::class)
					->withPivot('id', 'day')
					->withTimestamps();
	}

	public function subject_classes()
	{
		return $this->hasMany(SubjectClass::class);
	}

	public function institute_class()
	{
		return $this->belongsToMany(InstituteClass::class, 'subject_class', 'subject_id','class_id');
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'subjects_category')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}

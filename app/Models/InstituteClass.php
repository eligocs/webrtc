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
 * Class InstituteClass
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Collection|SubjectClass[] $subject_classes
 *
 * @package App\Models
 */
class InstituteClass extends Model
{
	use SoftDeletes;
	protected $table = 'institute_class';

	protected $fillable = [
		'name'
	];

	public function subject_classes()
	{
		return $this->hasMany(SubjectClass::class, 'class_id');
	}

	public function subjects()
	{
		return $this->belongsToMany(Subject::class, 'subject_class', 'class_id', 'subject_id');
	}


}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;

/**
 * Class SubjectClass
 * 
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property InstituteClass $institute_class
 * @property Subject $subject
 *
 * @package App\Models
 */
class SubjectClass extends Model
{
	protected $table = 'subject_class';

	protected $casts = [
		'class_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'class_id',
		'subject_id'
	];

	public function institute_class()
	{
		return $this->belongsTo(InstituteClass::class, 'class_id');
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}
}

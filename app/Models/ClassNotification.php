<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Reliese\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class ClassNotification extends Model
{
	protected $table = 'class_notifications';

	protected $fillable = [
		'i_a_c_s_id',
		'type',
		'message',
		'isread',
		'readUsers',
		'assigment_id',
		'student_id',
		'doubt_id',
		'institute_id',
		'class_id',
		'notify_date',
	];

}
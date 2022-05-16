<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model;

 
class StudentTrialPeriod extends Model
{
	use SoftDeletes;
	protected $table = 'student_trial_period';

	protected $fillable = [
		'student_id',
		'class_id'
	];

}

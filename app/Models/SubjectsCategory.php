<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model;

/**
 * Class SubjectsCategory
 * 
 * @property int $id
 * @property int $category_id
 * @property int $subject_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property Category $category
 * @property Subject $subject
 *
 * @package App\Models
 */
class SubjectsCategory extends Model
{
	use SoftDeletes;
	protected $table = 'subjects_category';

	protected $casts = [
		'category_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'subject_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}
}

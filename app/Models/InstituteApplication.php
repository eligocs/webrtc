<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model;

/**
 * Class InstituteApplication
 * 
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $phone_no
 * @property string $mobile_no
 * @property string $type_of_class
 * @property string $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class InstituteApplication extends Model
{
	use SoftDeletes;
	protected $table = 'institute_applications';

	protected $fillable = [
		'firstname',
		'lastname',
		'name',
		'email',
		'address',
		'address2',
		'city',
		'state',
		'zipcode',
		'phone_no',
		'mobile_no',
		'type_of_class',
		'description',
		'status'
	];
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable; 
use Carbon\Carbon;
use Reliese\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property int $institute_id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $address
 * @property string $phone
 * @property string $password
 * @property string $grade
 * @property string $state
 * @property string $city
 * @property string $role
 * @property string $session_id
 * @property string $remember_token
 * @property string $api_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Institute $institute
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasApiTokens, Notifiable;
	protected $table = 'users';

	protected $casts = [
		'institute_id' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'api_token'
	];

	protected $fillable = [
		'student_id',
		'institute_id',
		'name',
		'email',
		'email_verified_at',
		'address',
		'phone',
		'password',
		'grade',
		'state',
		'city',
		'role',
		'session_id',
		'remember_token',
		'api_token'
	];

	public function institute()
	{
		return $this->belongsTo(Institute::class);
  }

  public function student()
  {
    return $this->belongsTo(Student::class);
  }
}

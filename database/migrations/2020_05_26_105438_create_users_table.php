<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('institute_id')->nullable()->index('institute_id');
			$table->string('name', 50)->nullable();
			$table->string('email', 50)->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('address', 50)->nullable();
			$table->string('phone', 12)->unique('phone');
			$table->string('password');
			$table->string('grade', 20)->nullable();
			$table->string('state', 20)->nullable();
			$table->string('city', 20)->nullable();
			$table->string('role', 9)->nullable();
			$table->string('session_id')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->string('api_token', 100)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

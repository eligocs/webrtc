<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstituteApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institute_applications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('firstname', 50);
			$table->string('lastname', 50);
			$table->string('name', 50);
			$table->string('email', 50)->unique('email');
			$table->string('address', 50);
			$table->string('address2', 50);
			$table->string('city', 20);
			$table->string('state', 20);
			$table->string('zipcode', 20);
			$table->string('phone_no', 12);
			$table->string('mobile_no', 10);
			$table->string('type_of_class', 15);
			$table->string('description', 50);
			$table->string('status', 1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('institute_applications');
	}

}

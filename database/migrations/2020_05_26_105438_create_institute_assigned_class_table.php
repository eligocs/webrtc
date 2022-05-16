<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstituteAssignedClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institute_assigned_class', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category_id');
			$table->date('start_date');
			$table->date('end_date');
			$table->string('price', 10);
			$table->string('language', 10);
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
		Schema::drop('institute_assigned_class');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubjectClassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subject_class', function(Blueprint $table)
		{
			$table->foreign('class_id', 'subject_class_ibfk_1')->references('id')->on('institute_class')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('subject_id', 'subject_class_ibfk_2')->references('id')->on('subjects')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subject_class', function(Blueprint $table)
		{
			$table->dropForeign('subject_class_ibfk_1');
			$table->dropForeign('subject_class_ibfk_2');
		});
	}

}

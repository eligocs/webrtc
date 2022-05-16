<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubjectsCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subjects_category', function(Blueprint $table)
		{
			$table->foreign('category_id', 'subjects_category_ibfk_1')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('subject_id', 'subjects_category_ibfk_2')->references('id')->on('subjects')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subjects_category', function(Blueprint $table)
		{
			$table->dropForeign('subjects_category_ibfk_1');
			$table->dropForeign('subjects_category_ibfk_2');
		});
	}

}

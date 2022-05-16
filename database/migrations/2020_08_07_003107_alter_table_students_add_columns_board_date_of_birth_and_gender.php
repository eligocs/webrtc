<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableStudentsAddColumnsBoardDateOfBirthAndGender extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('students', function (Blueprint $table) {
      $table->string('board')->nullable();
      $table->timestamp('date_of_birth')->nullable();
      $table->string('gender')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('students', function (Blueprint $table) {
      $table->dropColumn(['board, date_of_birth, gender']);
    });
  }
}

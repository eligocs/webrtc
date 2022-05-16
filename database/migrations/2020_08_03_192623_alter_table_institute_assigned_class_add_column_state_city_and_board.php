<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInstituteAssignedClassAddColumnStateCityAndBoard extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('institute_assigned_class', function (Blueprint $table) {
      $table->string('state')->nullable();
      $table->string('city')->nullable();
      $table->string('board')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('institute_assigned_class', function (Blueprint $table) {
      $table->dropColumn(['state', 'city', 'board']);
    });
  }
}

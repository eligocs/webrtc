<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLectureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_lecture', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->timestamps();
          $table->unsignedBigInteger('student_id');
          $table->foreign('student_id')->references('id')->on('students');
          $table->unsignedBigInteger('lecture_id');
          $table->foreign('lecture_id')->references('id')->on('lectures');
          $table->integer('attendence_in_percentage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_lecture', function (Blueprint $table) {
            //
        });
    }
}

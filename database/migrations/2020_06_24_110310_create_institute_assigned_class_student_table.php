<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteAssignedClassStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_assigned_class_student', function (Blueprint $table) { 
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('institute_assigned_class_id');
            $table->foreign('institute_assigned_class_id', 'iac_id')->references('id')->on('institute_assigned_class');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insitute_assigned_class_student');
    }
}

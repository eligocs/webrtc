<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteAssignedClassSubjectTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_assigned_class_subject_teacher', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('institute_assigned_class_subject_id');
            $table->foreign('institute_assigned_class_subject_id', 'i_a_c_s_id')->references('id')->on('institute_assigned_class_subject');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institute_assigned_class_subject_teacher');
    }
}

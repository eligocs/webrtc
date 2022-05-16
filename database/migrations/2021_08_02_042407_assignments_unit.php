<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentsUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('assignments_units', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('institute_assigned_class_subject_id');
         $table->foreign('institute_assigned_class_subject_id')->references('id')->on('institute_assigned_class_subject');
         $table->string('unitName')->unique();
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
        //
    }
}

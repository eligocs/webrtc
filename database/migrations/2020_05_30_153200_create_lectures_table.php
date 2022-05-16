<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            // $table->integer('institute_id');
            // $table->foreign('institute_id')->references('id')->on('institutes');
            // $table->integer('class_id');
            // $table->foreign('class_id')->references('id')->on('institute_class');
            // $table->integer('subject_id');
            // $table->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('institute_assigned_class_subject_id');
            $table->foreign('institute_assigned_class_subject_id')->references('id')->on('institute_assigned_class_subject');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('lecture_number');
            $table->string('lecture_name');
            $table->longText('lecture_video');
            $table->timestamp('lecture_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }
}

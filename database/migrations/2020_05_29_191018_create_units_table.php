<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            // $table->integer('class_id');
            // $table->foreign('class_id')->references('id')->on('institute_class');
            // $table->integer('subject_id');
            // $table->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('institute_assigned_class_subject_id');
            $table->foreign('institute_assigned_class_subject_id')->references('id')->on('institute_assigned_class_subject');
            $table->string('name');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}

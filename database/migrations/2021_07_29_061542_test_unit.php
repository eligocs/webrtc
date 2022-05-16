<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('institute_assigned_class_subject_id');
            $table->foreign('institute_assigned_class_subject_id')->references('id')->on('institute_assigned_class_subject');
            $table->string('unit')->unique();
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
        //
    }
}

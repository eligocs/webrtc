<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('institute_assigned_class_subject_id');
            $table->foreign('institute_assigned_class_subject_id')->references('id')->on('institute_assigned_class_subject');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('per_q_mark');
            $table->integer('timer')->nullable();
            $table->string('show_ans', 10)->nullable();
            $table->float('amount')->nullable();

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
        Schema::dropIfExists('topics');
    }
}

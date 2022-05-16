<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('i_a_c_s_id');
            $table->text('type');
            $table->text('message');
            $table->text('assigment_id')->nullable();
            $table->text('student_id')->nullable();
            $table->text('doubt_id')->nullable();
            $table->text('readUsers')->nullable();
            $table->text('institute_id')->nullable();
            $table->text('class_id')->nullable();
            $table->integer('isread')->default(1);       
            $table->text('notify_date')->nullable();
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

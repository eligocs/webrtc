<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Livestudentclass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('meeting_id');
            $table->string('topic');
            $table->string('name');
            $table->string('join_time');
            $table->string('leave_time');
            $table->integer('attendence_in_percentage');
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

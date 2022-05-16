<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ZoomMeeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('topic_name');
            $table->string('date');
            $table->integer('duration');
            $table->integer('schedule');
            $table->string('password');
            $table->longText('join_url');
            $table->string('meeting_id');
            $table->string('host_id');
            $table->string('host_email');
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

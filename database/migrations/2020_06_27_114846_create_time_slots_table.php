<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->time('slot');
        });
        \App\Models\TimeSlot::insert([
          ['slot' => '09:00:00'],
          ['slot' => '10:30:00'],
          ['slot' => '12:00:00'],
          ['slot' => '01:30:00'],
          ['slot' => '03:00:00'],
          ['slot' => '04:30:00'],
          ['slot' => '06:00:00'],
          ['slot' => '07:30:00'],
          ['slot' => '09:00:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_slots');
    }
}

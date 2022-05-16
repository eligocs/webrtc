<?php

use App\Models\TimeSlot;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTimeSlotChangeSlotColumnValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TimeSlot::where('slot', '01:30:00')->update(['slot' => '13:30:00']);
        TimeSlot::where('slot', '03:00:00')->update(['slot' => '15:00:00']);
        TimeSlot::where('slot', '04:30:00')->update(['slot' => '16:30:00']);
        TimeSlot::where('slot', '06:00:00')->update(['slot' => '18:00:00']);
        TimeSlot::where('slot', '07:30:00')->update(['slot' => '19:30:00']);
        TimeSlot::where('slot', '09:00:00')->where('id', '!=', 1)->update(['slot' => '21:00:00']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TimeSlot::where('slot', '13:30:00')->update(['slot' => '01:30:00']);
        TimeSlot::where('slot', '15:00:00')->update(['slot' => '03:00:00']);
        TimeSlot::where('slot', '16:30:00')->update(['slot' => '04:30:00']);
        TimeSlot::where('slot', '18:00:00')->update(['slot' => '06:00:00']);
        TimeSlot::where('slot', '19:30:00')->update(['slot' => '07:30:00']);
        TimeSlot::where('slot', '21:00:00')->update(['slot' => '09:00:00']);
    }
}

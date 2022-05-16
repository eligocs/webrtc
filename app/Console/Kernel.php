<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
           $infos = \DB::table('student_subjects_info')->get();
           if(!empty($infos)){
               foreach($infos as $info){
                   $updated_time_id = $info->new_time_slot_id ? $info->new_time_slot_id : '';
                   if(!empty($updated_time_id)){
                       $info_id = $info->id;
                       \DB::table('student_subjects_info')->where('id',$info_id)->update([
                        'time_slot_id'=> $updated_time_id,
                        'new_time_slot_id'=> ''
                       ]);
                   }
               }
           }
        })->dailyAt('23:59:59');
    }

    /**
     * Register the commands f or the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

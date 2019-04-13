<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\SignoutStudents',
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
	 try {
            $kioskSched = [];
            if (Schema::hasTable('kiosk_schedule')) {
                $kioskSched = DB::table('kiosk_schedule')->get();
            }
            if (Schema::hasTable('schedules')) {
                $scheds = DB::table('schedule')->get();
			}

            foreach ($kioskSched as $entry) {
				$schedID = $entry->schedule_id;
				$time = $scheds->find($schedID)->end;
				//TODO if on alternate schedule, the use 'altend' instead.
				//	$time = $scheds->find($schedID)->altend;

				//Also pass in the time so that the command can check if they have signed in 5 minutes before, and thus ignore them.
                $schedule->command('kiosk:signoutstudents '.$entry->kiosk_id.' '.$time)->dailyAt($time);
            }
        } catch (\Exception $e) {
				//TODO DIE!!! -- record error somewhere
		}
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

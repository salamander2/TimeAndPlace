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
		'App\Console\Commands\SignoutAll',
		'App\Console\Commands\SignoutStudents',
		'App\Console\Commands\ScheduleList',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//Schedule the "signout all" command
		$schedule->command('kiosk:signoutall')->at('23:45');

		try {
			$kioskSched = [];
			if (Schema::hasTable('kiosk_schedule')) {
				$kioskSched = DB::table('kiosk_schedule')->get();
			}
			if (Schema::hasTable('schedules')) {
				$scheds = DB::table('schedules')->get();
			}

			//GET will return the 292nd item. For some reason it is not returning the item with id=292.
			//	dd($scheds->get(292));

			foreach ($kioskSched as $entry) {
				$schedID = $entry->schedule_id;
				//echo $schedID.PHP_EOL;
				$time = $scheds->where('id',$schedID)->first()->end;
				$time = substr($time,0,5); //->format('h:m'); // You cannot schedule a time if there are seconds included!
				//echo $time.PHP_EOL;

				//TODO if on alternate schedule, the use 'altend' instead.
				//	$time = $scheds->find($schedID)->altend;

				//Also pass in the time so that the command can check if they have signed in 5 minutes before, and thus ignore them.
				$schedule->command('kiosk:signoutstudents '.$entry->kiosk_id.' '.$time)->at($time);
			}

			//Debugging why this doesn't work. Can't use dailyAt(), use at() instead.
			//$cmd = 'kiosk:signoutstudents 1 21:40';
			//$schedule->command($cmd)->everyFiveMinutes();	//works
			//$schedule->command($cmd)->at('17:00');		//works
			//			dd("all commands scheduled successfully");
			//--massive dump!			var_dump($schedule);
			//			echo $schedule;

		} catch (\Exception $e) {
			//TODO DIE!!! -- record error somewhere
			echo "SQL table open error in app/Console/Kernel.php";
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

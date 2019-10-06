<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SignoutStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    #protected $signature = 'command:name';
    protected $signature = 'kiosk:signoutstudents {kiosk} {time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Signout all students for the specified kiosk';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $kioskid = $this->argument('kiosk');
		$kiosk = \App\Kiosk::find($kioskid); //not findOrFail?

		/* do all tests before signing out students */
		if ($kiosk == null) {
			$this->info('Invalid kiosk id: '.$kioskid);
			return;
		}
		if ($kiosk->kioskType != 0) {
			$this->info('Skipping signin only kiosk #'.$kioskid);
			return;
		}
		if ($kiosk->autoSignout == false) {
			$this->info('Skipping kiosk #'.$kioskid.' - no autosignout');
			return;

		}

        $time = $this->argument('time');

		foreach ($kiosk->signedIn as $student) {
			$studentID = $student->studentID;
			//$this->info(">".$studentID); //for debugging
			
			//if kiosk has blackout window (?) then don't sign out the student
			//get the signedIn record and check the time. If it is within 5 minutes earlier than $time, then "continue"

			//Deleted the SignedIn record
			$kiosk->signedIn()->detach($studentID);
			$kiosk->students()->attach($studentID, ['status_code' => 'AUTOSIGNOUT']);
		}
		
		$this->info('All students signed out of kiosk #'.$kioskid);
    }
}

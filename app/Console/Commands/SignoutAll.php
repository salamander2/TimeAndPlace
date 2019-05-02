<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Kiosk;

class SignoutAll extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
#protected $signature = 'command:name';
	protected $signature = 'kiosk:signoutall';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Signout ALL students';

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
		$records = \App\StudentSignedIn::all();

		foreach($records as $record) {
			$kioskID = $record->kiosk_id;
			$studentID = $record->studentID;
			$kiosk = Kiosk::find($kioskID);

			/* do all tests before signing out students */
			if ($kiosk == null) {
				$this->info('Invalid kiosk id: '.$kioskid);
				continue;
			}
			if ($kiosk->signInOnly == 1) {
				$this->info('Skipping signin only kiosk #'.$kioskid);
				continue;
			}

			$kiosk->signedIn()->detach($studentID);
			$kiosk->students()->attach($studentID, ['status_code' => 'AUTOSIGNOUT']);
		}


		$this->info('ALL students have been signed out of all kiosks.');
	}
}

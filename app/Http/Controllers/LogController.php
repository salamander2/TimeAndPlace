<?php

namespace App\Http\Controllers;

use DateTime;
use App\Log;
use App\Kiosk;
use App\StudentSignedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	// Route::get('/logs/byKiosk/{id}/{code}', 'LogController@kioskLogs');
	// Route::get('/logs/byStudent/{id}/{code}', 'LogController@studentLogs');

	//T = today, Y = yesterday, W = this week (last Sunday to today), M = this month, S = this semester, A / empty = All

	function getDate(){
		$today = DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));
		$yesterday = Carbon::yesterday()->toDateString();
		$week = Carbon::startOfWeek()->toDateString();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$student = \App\Student::find($id);
		$logs = Log::all()->where('studentID',$id);	//get all of the logs for this student

		$today = DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));
		$todaysLogs = Log::all()->where('studentID',$id)->where('created_at', '>', $today);
		//$todaysLogs = Log::all()->where('created_at', '>', $today);

		/**************** Cannot get whereDate() to work!!! 

		//using Carbon and whereDate		
		//$logs = Log::latest()->get();

		$todaysLogs = DB::table('logs')->whereDate('created_at', '=', Carbon::today()->toDateString());

		dd($todaysLogs);
		//$todaysLogs = Log::all()->where('created_at', '>', $dtToday);

		 ****************************/
		$yesterday = Carbon::yesterday()->toDateString(); 		
		$yesterdayLogs = Log::all()->where('studentID',$id)->where('created_at', '>', $yesterday)->where('created_at', '<', $today);

		return view('logs.student', compact('student','logs','todaysLogs','yesterdayLogs'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function tempshow($id)
	{
		$logs = Log::all()->where('kiosk_id',$id);	//TODO: WHY A KIOSK ID ????
		$kiosk = Kiosk::all()->find($id);

		return view('logs.index', compact('logs','kiosk'));
	}



	/* This signs out all students for one kiosk */
	public function autoSignoutKiosk(String $kioskID) {

		$records = StudentSignedIn::where('kiosk_id',$kioskID)->get();;
		$count = $records->count();
		foreach($records as $record) {
			$kioskID = $record->kiosk_id;
			$studentID = $record->studentID;
			$kiosk = Kiosk::find($kioskID);

			$kiosk->signedIn()->detach($studentID);

			$kiosk->students()->attach($studentID, ['status_code' => 'AUTOSIGNOUT']);
		}

		//return response()->json(['status' => 'success']);
		return redirect()->back()->with("error", "All $count students signed out of this kiosk");
	}

	/* This signs out ALL students (and ends with a dd() ) */
	public function autosignout() {
		$records = StudentSignedIn::all();
		$this->doAutoSignout();
		dd ($records->count() . " students signed out. Please hit BACK and RELOAD screen.");
	}

	/* This signs out ALL students  */
	public function doAutoSignout() {
		$records = StudentSignedIn::all();

		foreach($records as $record) {
			$kioskID = $record->kiosk_id;
			$studentID = $record->studentID;
			$kiosk = Kiosk::find($kioskID);

			$kiosk->signedIn()->detach($studentID);

			$kiosk->students()->attach($studentID, ['status_code' => 'AUTOSIGNOUT']);
		}

	}
}

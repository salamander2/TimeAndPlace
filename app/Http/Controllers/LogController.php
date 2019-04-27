<?php

namespace App\Http\Controllers;

use DateTime;
use App\Log;
use App\Kiosk;
use App\Student;
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

	/**
	 * @param  int  $id		//the kiosk ID
	 * @return \Illuminate\Http\Response
	 */
	public function kioskLogs($id, $code = 'W')
	{			
		$logs = Log::where('kiosk_id',$id)->with('student');

		switch($code) {
			case 'T':
				$today = Carbon::today()->toDateString();
				$logs = $logs->where('created_at', '>', $today)->get();
				break;
			case 'Y':
				$today = Carbon::today()->toDateString();
				$yesterday = Carbon::yesterday()->toDateString();
				$logs = $logs->where('created_at', '>', $yesterday)->where('created_at', '<', $today)->get();
				break;
			case 'W':
				$week = Carbon::now()->startOfWeek()->subDay();	//sets time to 0:00:00
				$logs = $logs->where('created_at', '>', $week)->get();
				break;
			case 'M':
				$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
				$logs = $logs->where('created_at', '>', $month)->get();
				break;
			case 'P':
				$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
				$lastmonth = Carbon::now()->startOfMonth()->subMonth();
				$logs = $logs->where('created_at', '>', $lastmonth)->where('created_at', '<', $month)->get();
				break;
			default:
				//default or anything else is ALL (which was already selected)
				$logs = $logs->get();
		}

		$kiosk = Kiosk::all()->find($id);
		//TODO: find some way of adding in the correct student informatin for each log so that you don't have to look it up in the blade template.

		//$record = $logs->first();
		//$student = $record->with('student')->get();
//		dd($student);

		return view('logs.indexK', compact('logs','kiosk', 'code'));
	}

	//For testing only
	function getDate(){		

		// $today = DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));
		$today = Carbon::today()->toDateString();
		$yesterday = Carbon::yesterday()->toDateString();
		// $month = new Carbon('first day of this month'); //this gives time to current time.
		$week = Carbon::now()->startOfWeek()->subDay();	//sets time to 0:00:00
		$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
		
		// $week 
		dd($week);
	}

	/**
	 * @param  int  $id		//the kiosk ID
	 * @return \Illuminate\Http\Response
	 */
	public function studentLogs($id, $code = 'W')
	{			
		$student = Student::find($id);
		$logs = Log::where('studentID',$id); //this returns a query
		//sort by date first:
		
		//make dates
		$today = Carbon::today()->toDateString();
		$yesterday = Carbon::yesterday()->toDateString();
		$week = Carbon::now()->startOfWeek()->subDay();	//sets time to 0:00:00
		$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
		$lastmonth = Carbon::now()->startOfMonth()->subMonth();

		$todaylogs =  Log::where('studentID',$id)->where('created_at', '>', $today)->get();
		$yesterlogs =  Log::where('studentID',$id)->where('created_at', '>', $yesterday)->where('created_at', '<', $today)->get();
		$weeklogs =  Log::where('studentID',$id)->where('created_at', '>', $week)->get();
		$monthlogs =  Log::where('studentID',$id)->where('created_at', '>', $month)->get();
		$prevmonthlogs =  Log::where('studentID',$id)->where('created_at', '>', $lastmonth)->where('created_at', '<', $month)->get();

		$logs =  Log::where('studentID',$id)->get();

		return view('logs.indexS', compact('todaylogs','yesterlogs','weeklogs','monthlogs','prevmonthlogs','student'));
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

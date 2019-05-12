<?php

namespace App\Http\Controllers;

//use DateTime;
use Auth;
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
	
		$logs = $logs->sortByDesc('created_at');

		return view('logs.indexK', compact('logs','kiosk', 'code'));
	}

	//For testing only
	function getDate(){		

		// $today = DateTime::createFromFormat('!Y-m-d', date('Y-m-d'));
		$today = Carbon::today()->toDateString();	// "2019-05-11"
		$yesterday = Carbon::yesterday()->toDateString();
		// $month = new Carbon('first day of this month'); //this gives time to current time.
		$week = Carbon::now()->startOfWeek()->subDay();	//sets time to 0:00:00
		$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
		
		// $week 
		dd($week);
	}

	/**
	 * This gets all of the logs for a particular student. 
	 * IF the user is not an administrator, he cannot view the logs from kiosks set to private.
	 * @param  int  $id		//the kiosk ID
	 * @return \Illuminate\Http\Response
	 */
	public function studentLogs($id, $code = 'W')
	{			
		$student = Student::find($id);
		$user = Auth::user();
		//$logs = Log::where('studentID',$id); //this returns a query
		
				
		//make dates
		$today = Carbon::today()->toDateString();
		$yesterday = Carbon::yesterday()->toDateString();
		$week = Carbon::now()->startOfWeek()->subDay();	//sets time to 0:00:00
		$month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
		$lastmonth = Carbon::now()->startOfMonth()->subMonth();

		//build all queries
		$todaylogs =  Log::where('studentID',$id)->where('created_at', '>', $today)->orderByDesc('created_at');
		$yesterlogs =  Log::where('studentID',$id)->where('created_at', '>', $yesterday)->where('created_at', '<', $today)->orderByDesc('created_at');
		$weeklogs =  Log::where('studentID',$id)->where('created_at', '>', $week)->orderByDesc('created_at');
		$monthlogs =  Log::where('studentID',$id)->where('created_at', '>', $month)->orderByDesc('created_at');
		$prevmonthlogs =  Log::where('studentID',$id)->where('created_at', '>', $lastmonth)->where('created_at', '<', $month)->orderByDesc('created_at');
		//"All logs" is not used on this screen
		//$logs =  Log::where('studentID',$id)->orderByDesc('created_at')->get();

		//remove all private kiosk logs from query
		foreach ( Kiosk::all() as $kiosk) {
			if ($user ->isAdministrator()) continue;
			if ($user->isKioskUser($kiosk)) continue;
			if ($kiosk->publicViewable) continue;
			$todaylogs = $todaylogs->where('kiosk_id','!=',$kiosk->id);
			$yesterlogs = $yesterlogs->where('kiosk_id','!=',$kiosk->id);
			$weeklogs = $weeklogs->where('kiosk_id','!=',$kiosk->id);
			$monthlogs = $monthlogs->where('kiosk_id','!=',$kiosk->id);
			$prevmonthlogs = $prevmonthlogs->where('kiosk_id','!=',$kiosk->id);
		}

		//get all queries
		$todaylogs = $todaylogs->get();
		$yesterlogs = $yesterlogs->get();
		$weeklogs = $weeklogs->get();
		$monthlogs = $monthlogs->get();
		$prevmonthlogs = $prevmonthlogs->get();


		return view('logs.indexS', compact('todaylogs','yesterlogs','weeklogs','monthlogs','prevmonthlogs','student'));
	}
	
	/* This method gets all of the logs for one student and sorts them by kiosk, then by date.
	 * This is so that the view can display logs by kiosk.
	 * 
	 * @param  int  $id		//the kiosk ID
	 * @return \Illuminate\Http\Response
	 */
	public function studentLogsByKiosk($id)
	{			
		$student = Student::find($id);
		$user = Auth::user();
		$logs = Log::where('studentID',$id)->orderBy('kiosk_id')->orderByDesc('created_at')->with('kiosk'); //this returns a query
				
		//remove all private kiosk logs 
		foreach ( Kiosk::all() as $kiosk) {
			if ($user ->isAdministrator()) continue;
			if ($user->isKioskUser($kiosk)) continue;
			if ($kiosk->publicViewable) continue;
			$logs = $logs->where('kiosk_id','!=',$kiosk->id);
		}

		$logs = $logs->get();
		//dd($logs);
		
		return view('logs.indexSK', compact('logs','student'));
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

<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\Meeting;
use App\Student;
use App\StudentSignedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

/*
This controller is for API requests that get data. 
All data is returned as JSON. The routes (or functions) never return a view.

It can be extended to include API calls that allow student signin and sign out
- for automating "fake" student movements in this demo database thate doesn't
  have actual real students using it.
But we would need to have some sort of authentication token stored in the ,env file
since there would be no users logging on in order to start the Terminal.

Restricted to actual logged in users: any method that creates data.
*/

class APIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['teamSignIn']);
    }

    //Return a list of all "signin/out" kiosks with name and room number.
    public function listKiosks() {
	//only get the signin/signout kiosks
	$kiosks = Kiosk::where('kioskType',0)->get(['id', 'name', 'room']);
	//return($kiosks); //this seems to be JSON encoded data already.
	$data = json_encode($kiosks,true);
	return($data);
    }

    //Return the current number of students in attendance for this room
    public function kioskAttendance(Kiosk $kiosk) {
	//this only works for signin type kiosks. In other cases it is meaningless.
	if ($kiosk->kioskType != 0) {
	    return(json_encode(-1));
         }
	$num = StudentSignedIn::where('kiosk_id', $kiosk->id)->count();
	return json_encode($num);
    }

	public function randStudents() {
		$random = Student::all()->random(30);
		foreach ($random as $r) {
			print($r->studentID . "<br>");
		}

	}

	//sign in a set of students to a particular kiosk. 
	//public function teamSignIn(Kiosk $kiosk) {
	public function teamSignIn() {

		$random30=array(
			300217207 ,
			300692648 ,
			300739654 ,
			300992329 ,
			301019476 ,
			301931245 ,
			302101212 ,
			302277330 ,
			303175081 ,
			303327643 ,
			304339703 ,
			304399843 ,
			304639922 ,
			304790112 ,
			305525810 ,
			306554668 ,
			306634643 ,
			306800633 ,
			306894932 ,
			306989367 ,
			307015991 ,
			307154090 ,
			307159147 ,
			307468399 ,
			307621744 ,
			308339051 ,
			308685272 ,
			309120204 ,
			309216710 ,
			309461762
		);

		$chess=array(			//kiosk #4
			300217207,
			300692648,
			300739654,
			300992329,
			301019476,
			301931245,
			302101212,
			302277330,
			303175081,
			303327643,
			304339703
		);

		$origami=array(
			308339051 ,
			304399843,
			303175081,
			300692648,
			306554668,
		);

		$library=array(
			302101212,
			302277330,
			303175081,
			303327643,
			304339703,
			304399843,
			304639922,
			304790112,
			305525810,
			306554668,
			306634643,
			306800633,
			306894932,
			306989367
		);

		$stSuccess=array(
			300217207,
			300692648,
			300739654,
			303175081,
			306554668,
			306634643,
			306800633,
			308685272,
			309120204,
			309216710,
			309461762
		);

		$list=$chess;
		
		$pct = 90;
	    $kiosknum = 5;
		$kiosk = Kiosk::find($kiosknum);
		$carbondate = Carbon::createFromDate("2020", "09", "16", "America/Toronto");
		$carbondate->setTime(14,52,0);

		for ($x = 0; $x < 7; $x++) {
			print($carbondate."<br>");
			$this->doTeamSignIn($pct, $carbondate, $kiosk, $list);
		   	$minute = rand(50,59);
			$carbondate->setTime(14,$minute,0);
		    $wait = rand(30,120); // add this many seconds
		    $carbondate->addSeconds($wait);
			$carbondate->addWeek();
			print($x."<br>");
		}

		dd("DONE. $carbondate $kiosk->name" );
	}

	protected function doTeamSignIn(int $pct, Carbon $carbondate, Kiosk $kiosk, array $list) {

		$statcode = 'PRESENT';
		$statresp = 'present';

		//Only works for kiosk type 1 (Present Only)
		if ($kiosk->kioskType != 1) {
			return(json_encode(-1));
		}


		//add a meeting record
		$this->createMeetingRecord($kiosk, $carbondate);

		//from public/storage/
		//$idList = Storage::disk('public')->get('id30.txt');
		//$list = array_slice(explode(PHP_EOL,$idList),0);


		foreach($list as $studentID) {

		   //randomly skip $pct % of students
		   if (rand(0,100) > $pct) continue;

		   print($studentID."<br>");

		   $wait = rand(30,300); // add this many seconds
		   $carbondate->addSeconds($wait);

		   //create a SIGNIN log file entry         
		   $kiosk->studentLogs()->timestamps=false;
		   $kiosk->studentLogs()->attach($studentID, ['status_code' => $statcode,'created_at' => $carbondate,'updated_at' => $carbondate]);
		   //create a signedIn entry
		   $kiosk->signedIn()->timestamps=false;
		   $kiosk->signedIn()->attach($studentID, ['status_code' => $statcode,'created_at' => $carbondate,'updated_at' => $carbondate]);
        }


/* To modify the timestame, try this: ???????
$table->datetime('creation_date');
$table->datetime('last_update');

//set a specific updated at time
$user->update(['updated_at' => now()]);

By default, both created_at and updated_at are casts as $dates of Eloquent model, so you can perform Carbon operations on them, without converting to Carbon instance.

For example:
$user->created_at->addDays(3);
*/


		//return response()->json(['status' => $statresp, 'photoURL'=>$photoURL, 'student' => $student->toArray()]);
	}

    protected function createMeetingRecord(Kiosk $kiosk, Carbon $carbondate)
    {
        $date = $carbondate->toDateString();   
        $found = Meeting::where('kiosk_id',$kiosk->id)->where('date',$date)->count();
               
        if ( $found > 0) { 
            return;            
        }

		/* Attempt to override timestamps. Not working!  
	    //Meeting::timestamps=false;

		Meeting time timetamps are used in the Report controller since they are carbondates and can be compared more easily than the "date" field that I add.

        Meeting::create([
            'date' => $date,								//looks like 2020-10-23   tzName is 'America/Toronto'
            //'time' => Carbon::now()->toTimeString(),  	//looks like 13:49:43
            'time' => $carbondate->toTimeString(),
            'kiosk_id' => $kiosk->id,
		    'created_at' => $carbondate,
			'updated_at' => $carbondate
        ]);
		*/

        $meeting = Meeting::create([
            'date' => $date,								//looks like 2020-10-23   tzName is 'America/Toronto'
            //'time' => Carbon::now()->toTimeString(),  	//looks like 13:49:43
            'time' => $carbondate->toTimeString(),
            'kiosk_id' => $kiosk->id,
        ]);

	    $meeting->timestamps=false;
	    $meeting->created_at = $carbondate;
		$meeting->updated_at = $carbondate;
		$meeting->save();
    }
}

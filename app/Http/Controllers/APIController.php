<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\Student;
use App\StudentSignedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
This controller is for API requests that get data. 
All data is returned as JSON. The routes (or functions) never return a view.

It can be extended to include API calls that allow student signin and sign out
- for automating "fake" student movements in this demo database thate doesn't
  have actual real students using it.
But we would need to have some sort of authentication token stored in the ,env file
since there would be no users logging on in order to start the Terminal.

*/

class APIController extends Controller
{
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

	//sign in students to a particular kiosk. Only works for kiosk type 1
	public function teamSignIn(Kiosk $kiosk) {
		if ($kiosk->kioskType != 1) {
			return(json_encode(-1));
		}
		//$time = 14:54

		$wait = rand(30,300); // add this many seconds
		//from public/storage/
		$idList = Storage::disk('public')->get('id30.txt');
//        $studentID = $student->studentID;
		$list = array_slice(explode(PHP_EOL,$idList),0);

#dd($list);
		foreach($list as $studentID) {
		  print($studentID."<br>");
        }
dd($wait);
		$statcode = 'SIGNIN';
		$statresp = 'signed in';
		if ($kiosk->kioskType == 1) {
			$statcode = 'PRESENT';
			$statresp = 'present';
			//add a meeting record
			$this->createMeetingRecord($kiosk);
		}
		//create a SIGNIN log file entry         
		$kiosk->students()->attach($studentID, ['status_code' => $statcode]);
		//create a signedIn entry
		$kiosk->signedIn()->attach($studentID, ['status_code' => $statcode]);

		//return response()->json(['status' => $statresp, 'photoURL'=>$photoURL, 'student' => $student->toArray()]);


	}
}

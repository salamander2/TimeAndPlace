<?php

namespace App\Http\Controllers;

use Auth;
use App\Terminal;
use App\Kiosk;
use App\Student;
use App\StudentKiosk;
use App\Status;
use App\Meeting;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
//use Nexmo\Client\Exception\Request;

class TerminalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('lockout')->only(['launch']);
        // $this->middleware('lockout')->only(['launch', 'toggleStudent']);
	    //Do not require AUTH middleware for listStudents.
        $this->middleware('auth')->only(['listStudents2']);
        $this->middleware('guest')->only(['toggleStudentID']);
    }

    /* This displays a termnal, but logs out the user first.
	It MUST be called from a user who belongs to that kiosk. 
	That's what the TerminalLockout middleware checks.  */
    public function launch(Request $request, Kiosk $kiosk)
    {
        // if (Auth::check()) {
        //     $request->session()->put('lockout', true);
        //     Auth::logout();
        // } else {
        //     abort(403,'Unauthorized access. You must be a logged in user to start a terminal.');
        // }
        if ($request->session()->get('lockout')) {
            Auth::logout();
        } else {
            abort(403,'Unauthorized access. You must be a logged in user to start a terminal.');
        }
        return view('terminal', compact('kiosk'));
    }
    
    /*This allows the terminal to be launched by typing in a secretURL.
	It can be launched by a logged in user or when no one is logged in.
	Therefore it must NOT run any middleware to verify anything.
    */
    public function launchViaToken(Request $request, String $token)
    {
	//dd(url()->full());
        $kiosk = Kiosk::where('secretURL', $token)->first();
        if ($kiosk) {
           $request->session()->put('lockout', true);  
           if (Auth::check()) {
                //$request->session()->put('lockout', true); //already done above
                Auth::logout();
            }  
           return view('terminal', compact('kiosk'));
        } else {
		    dd("launch via token error");
	//      return redirect('/login');
        }
    }

        

    /* This method assumes that the student record is present -- not null */
    /* NO LONGER USED
    public function toggleStudent(Kiosk $kiosk, Student $student)
    {        
        $studentID = $student->studentID;
        //This works
        // $present = $kiosk->signedIn->contains('studentID',$studentID);
        //This also works (after adding foreign keys):
        $present = \App\StudentSignedIn::isSignedIn($studentID, $kiosk->id);

        if ($present) {
             //Deleted the SignedIn record
             $kiosk->signedIn()->detach($studentID);

            //add a 'deleted at' timestamp to the signin record. (This is probably never needed)
            // $kiosk->students()->where('status_code','=','SIGNIN')->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); //delete the original signin
             
             //Add a "SIGNOUT" record for the student the LOG file
             $kiosk->students()->attach($studentID, ['status_code' => 'SIGNOUT']);
             
             //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'detached', 'student' => $student->toArray()]);            
            //return response([$student,'status' => 'detached']);
        } else {

            //create a SIGNIN log file entry         
            $kiosk->students()->attach($studentID, ['status_code' => 'SIGNIN']);            
            //create a signedIn entry
            $kiosk->signedIn()->attach($studentID, ['status_code' => 'SIGNIN']);

            $photoURL = $student->getPhotoURL($studentID);
            return response()->json(['status' => 'attached', 'student' => $student->toArray(), 'photoURL' => $photoURL]);
            //return response([$student,'status' => 'attached']); 
            
        }
  
    }
    */

    /* Toggle student in/out using their login ID to identify them
        OR their student number */
    public function toggleStudentID(Kiosk $kiosk, String $loginID)
    {     
        $student = null;
        $loginID= strtolower($loginID); 
        //return response()->json(['login' => $loginID, 'here' => 'here']);   //how to debug

        /* First we check to see if it is a student id number : ie. all digits */
        if (is_numeric($loginID)) {
            
            $student = Student::where('studentID',$loginID) ->first();   
            if ($student == null) {
                return response()->json(['status' => 'not found']);
            }
        } else {
            /* Next we check to see if it is a student login id */
            $student = Student::where('loginID',$loginID) ->first();
            if ($student == null) {
                return response()->json(['status' => 'not found']);
            }
        }

        $studentID = $student->studentID;
        
        $present = \App\StudentSignedIn::isSignedIn($studentID, $kiosk->id);
        //dd($kiosk->id . "_" . $present);
    
        /* Problems signing the student in and out:
            We have to somehow ascertain if the student is signed in.
            The student must be able to sign in and out multiple times a day.
            The attach creates a log file record.
            Detach deletes it, which we don't want.
            Soft-deletes do not work on pivot tables, so I'm trying to update the 'deleted_at' field myself
            However, this updates the DELETED AT stamp on ALL records that this student has in this kiosk
        */

        if ($present) { 

            //if the kiosk is signinOnly
            if ($kiosk->kioskType) {
                return response()->json(['status' => 'already present', 'student' => $student->toArray()]);
            }

            //Deleted the SignedIn record
            $kiosk->signedIn()->detach($studentID);

            //add a 'deleted at' timestamp to the signin record. (This is probably never needed)
            //$kiosk->students()->where('status_code','=','SIGNIN')->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); //delete the original signin
            
            //Add a new "SIGNOUT" record for the student the LOG file.  
            // NO NO NO: the DeletedAt column has been deleted. It's no longer needed.
            // $kiosk->students()->attach($studentID, ['deleted_at'=> Carbon::now(), 'status_code' => 'SIGNOUT']);
            $kiosk->students()->attach($studentID, ['status_code' => 'SIGNOUT']);
            
            //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'signed out', 'student' => $student->toArray()]);

        } else {
            $statcode = 'SIGNIN';
            $statresp = 'signed in';
            if ($kiosk->kioskType) {
                $statcode = 'PRESENT';
                $statresp = 'present';
                //add a meeting record
                $this->createMeetingRecord($kiosk);
            }
            //create a SIGNIN log file entry         
            $kiosk->students()->attach($studentID, ['status_code' => $statcode]);
            //create a signedIn entry
            $kiosk->signedIn()->attach($studentID, ['status_code' => $statcode]);
            //get photoURL in case it's needed
            $photoURL = $student->getPhotoURL($studentID);
            return response()->json(['status' => $statresp, 'photoURL'=>$photoURL, 'student' => $student->toArray()]);
        }

        return redirect() -> route('launchTerminal',$kiosk->id);    //why is this here?
    }

    //called from terminal, teacher bypass
    public function listStudents(String $q) {
        //see child.terminal.blade.php 
       // $query = "SELECT students.studentID, students.firstname, students.lastname FROM students WHERE firstname LIKE '$q%' or lastname LIKE '$q%' or studentID LIKE '$q%' ORDER BY lastname, firstname";
        // dd($q);
        // return("YOLO");
        
        $students = Student::where('firstname','like', '%'.$q.'%')->orWhere('lastname','like', '%'.$q.'%')->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')->get();
        return view('child.studentListTerminal', compact('students'));
       // return($students);
       // dd($students);
    }

    //This is the same as the above method, but it needs to return a different child view since clicking on a student here does a different thing.
    //called from student search bar on top nav bar.
    public function listStudents2(String $q) {
        $students = Student::where('firstname','like', '%'.$q.'%')->orWhere('lastname','like', '%'.$q.'%')->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')->get();        
        return view('child.studentListSearch', compact('students'));
    }

    protected function createMeetingRecord(Kiosk $kiosk)
    {
        //TODO: check the session variable (set below) and return if it is set.
        // BUT how long will it persist and when should it be deleted?
        //$sessionVal = session('meetingcreated');
        //if ($sessionVal == true) return;

        $today = Carbon::today()->toDateString();   //maybe set the string to have a format: ->format('D d M Y')
        $found = Meeting::where('kiosk_id',$kiosk->id)->where('date',$today)->count();
               
        if ( $found > 0) { 
            //TODO: set a session variable instead of doing the search in the lines above
            return;            
        }

        Meeting::create([
            'date' => $today,
            'time' => Carbon::now()->toTimeString(),
            'kiosk_id' => $kiosk->id
        ]);

        
        //session(['meetingcreated' => 'true']);
    }
}

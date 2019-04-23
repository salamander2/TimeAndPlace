<?php

namespace App\Http\Controllers;

use Auth;
use App\Terminal;
use App\Kiosk;
use App\Student;
use App\StudentKiosk;
use App\Status;
//use Carbon\Carbon;
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
        // $this->middleware('lockout')->only(['launch', 'toggleStudent']);
       // $this->middleware('lockout')->only(['launch']);
    }

    /* This displays a termnal, but logs out the user first  
        There is a bunch of "lockout stuff and middleware, but I don't think that any of it is needed. */

    // public function launch(Request $request, Kiosk $kiosk)
    public function launch(Kiosk $kiosk)
    {
        if (Auth::check()) {
            //$request->session()->put('lockout', true);
            Auth::logout();
        }
        return view('terminal', compact('kiosk'));
    }
    
    /*This allows the terminal to be launched by typing in a token (or is it a URL?)
    */
    public function launchViaToken(Request $request, String $token)
    {
        $kiosk = App\Kiosk::where('secret', $token)->first();
        if ($kiosk) {
           //$request->session()->put('lockout', true);  
           if (Auth::check()) {
            //$request->session()->put('lockout', true);
                Auth::logout();
            }  
           return view('terminal', compact('kiosk'));
        } else {
            return redirect('/login');
        }

        
    }

    
    //DEBUG
    public function launchPrev(Kiosk $kiosk)
    {
        return view('terminalPrev', compact('kiosk'));
    }
    //Debugging only: Launch BluePanel terminal
    public function launchBP(Kiosk $kiosk)
    {
        return view('bp_terminal', compact('kiosk'));
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
            
            //Deleted the SignedIn record
            $kiosk->signedIn()->detach($studentID);

            //add a 'deleted at' timestamp to the signin record. (This is probably never needed)
            //$kiosk->students()->where('status_code','=','SIGNIN')->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); //delete the original signin
            
            //Add a new "SIGNOUT" record for the student the LOG file.  
            // NO NO NO: the DeletedAt column has been deleted. It's no longer needed.
            // $kiosk->students()->attach($studentID, ['deleted_at'=> Carbon::now(), 'status_code' => 'SIGNOUT']);
            $kiosk->students()->attach($studentID, ['status_code' => 'SIGNOUT']);
            
            //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'detached', 'student' => $student->toArray()]);
        } else {           
           
            //create a SIGNIN log file entry         
            $kiosk->students()->attach($studentID, ['status_code' => 'SIGNIN']);            
            //create a signedIn entry
            $kiosk->signedIn()->attach($studentID, ['status_code' => 'SIGNIN']);
           
            return response()->json(['status' => 'attached', 'student' => $student->toArray()]);
        }

        return redirect() -> route('launchTerminal',$kiosk->id);
    }

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

    public function listStudents2(String $q) {
        $students = Student::where('firstname','like', '%'.$q.'%')->orWhere('lastname','like', '%'.$q.'%')->orderBy('lastname', 'asc')->orderBy('firstname', 'asc')->get();        
        return view('child.studentListSearch', compact('students'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Terminal;
use App\Kiosk;
use App\Student;
use App\StudentKiosk;
use App\Status;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
//use Nexmo\Client\Exception\Request;

class TerminalController extends Controller
{
    public function launch(Kiosk $kiosk)
    {
        return view('terminal', compact('kiosk'));
    }
    
    //Debugging only: Launch BluePanel terminal
    public function launchBP(Kiosk $kiosk)
    {
        return view('bp_terminal', compact('kiosk'));
    }
/*
    public function toggleStudent(Kiosk $kiosk, Student $student)
    {        
        dd($student);
        $present = $student->kiosks->contains($kiosk->id);

        dd($kiosk->id . " " . $present);

        if ($present) {
            //Signout Student
            $kiosk->logs()->attach($student->id, ['type' => 'Sign Out']);            
            $student->kiosks()->detach($kiosk->id);
            //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'detached', 'student' => $student->toArray()]);
        } else {
            //Sign in student            
            $kiosk->logs()->attach($student->id, ['type' => 'Sign In']);            
            $student->kiosks()->attach($kiosk->id);
            return response()->json(['status' => 'attached', 'student' => $student->toArray()]);
        }
  
    }
*/
    /* The Request object is the Student ID */
    public function toggleStudent_v2(Kiosk $kiosk, Request $request)
    {       
       //dd($kiosk->students); //this gets all the students connected to that kiosk in the logs table.
        
        $studentID = $request->get('studentID');        
        //the student record is not needed: 
        $student = Student::where('studentID',$studentID) ->first();
                
        // $present = $kiosk->students->contains('studentID',$studentID);
        $present = $kiosk->signedIn->contains('studentID',$studentID);
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
 
            // $kiosk->students()->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); 
            //dd(  $kiosk->students()->where('status','=','SIGNIN'));

            //Deleted the SignedIn record
            $kiosk->signedIn()->detach($studentID);

            //FIXME: do I need the following line?
            $kiosk->students()->where('status_code','=','SIGNIN')->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); //delete the original signin
            
            //Add a "SIGNOUT" record for the student the LOG file
            $kiosk->students()->attach($studentID, ['deleted_at'=> Carbon::now(), 'status_code' => 'SIGNOUT']);
            
            //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'detached', 'student' => $student->toArray()]);
        } else {           
           
            //Sign in student            
            $kiosk->students()->attach($studentID, ['status_code' => 'SIGNIN']);            
            
            $kiosk->signedIn()->attach($studentID, ['status_code' => 'SIGNIN']);
            // $student->kiosks()->attach($kiosk->id);
           // $kiosk->students()->attach($studentID); //this is redundant
            return response()->json(['status' => 'attached', 'student' => $student->toArray()]);
        }

        return redirect() -> route('launchTerminal',$kiosk->id);
    }

    public function listStudents(String $q) {
        //see child.terminal.blade.php    
    }
}

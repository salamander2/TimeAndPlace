<?php

namespace App\Http\Controllers;

use App\Terminal;
use App\Kiosk;
use App\Student;
use App\StudentKiosk;
// use Carbon\Carbon;
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
    public function launchbp(Kiosk $kiosk)
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
    public function toggleStudent_v2(Kiosk $kiosk, Request $request)
    {
       //return $request-> all();        
       //dd($kiosk->students); //this gets all the students connected to that kiosk in the logs table.

        $studentID = $request->get('studentID');        
        //the student record is not needed: 
        $student = Student::where('studentID',$studentID) ->first();
                
        $present = $kiosk->students->contains('studentID',$studentID);
        //dd($kiosk->id . "_" . $present);
        if ($present) {
            
            //Signout Student
            $kiosk->students()->attach($studentID, ['status_id' => '1']);            
            //$student->kiosks()->detach($kiosk->id);
            //Return info for AJAX to display on the kiosk
            return response()->json(['status' => 'detached', 'student' => $student->toArray()]);
        } else {
            dd('signin');
            //Sign in student            
            $kiosk->logs()->attach($student->id, ['type' => 'Sign In']);            
            $student->kiosks()->attach($kiosk->id);
            return response()->json(['status' => 'attached', 'student' => $student->toArray()]);
        }

        return redirect() -> route('launchTerminal',$kiosk->id);
    }

    public function listStudents(String $q) {
        //see child.terminal.blade.php
     
    }
}

<?php

namespace App\Http\Controllers;

use App\Terminal;
use App\Kiosk;
use App\Student;
// use Carbon\Carbon;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
}

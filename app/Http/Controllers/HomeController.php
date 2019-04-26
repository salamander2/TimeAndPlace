<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kiosk;
use App\Student;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /********** Testing Area here  ***************/
        //   $studentID = 303210173;
        //   $present = \App\StudentSignedIn::isSignedIn($studentID, '2');
        //   dd($present);
         
         
          // $student = Student::find($studentID);
          //$kiosk = Kiosk::first(); 
          
          //check the StudentSignedIn table to see if there is a record with this kiosk and student
          
         // $present = $student->kiosks;//->contains($kiosk->id);
          //dd($present);
        // $kiosk = Kiosk::find('1');
        // $kiosk->schedules()->detach('3');
        // dd("done");
        /********** End Testing Area ***********/

        $kiosks = Kiosk::all()->where('publicViewable','=','1');

        //dd($kiosks);
        return view('home', compact('kiosks'));
    }

    /* This is the same as the main home index view, but for only one kiosk. 
    *  The blade template shows all students signed in, not just the most recent 10.
    */
    public function showKiosk(Kiosk $kiosk) {
        
        $tudent = $kiosk->signedIn->sortBy('pivot.created_at');
        //dd($kiosk);
        return view('studentsSignedIn', compact('kiosk','student'));
    }

    public function help() {
        return view('help');
    }

    public function home1()
    {
        return view('home1');
    }
}

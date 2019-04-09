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
        $kiosk = Kiosk::find('2');        
        $kiosk->schedules()->dissociate('3');
        $kiosk->schedules()->detach('3');
        dd("done");
        /********** End Testing Area ***********/
        return view('home');
    }

    public function help() {
        return view('help');
    }

    public function home1()
    {
        return view('home1');
    }
}

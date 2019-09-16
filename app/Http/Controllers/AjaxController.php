<?php

namespace App\Http\Controllers;

use App\User;
use App\Kiosk;
use App\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function __construct()
    {       
        $this->middleware('auth');
        //$this->middleware('admin');
		
    }

    public function resetPWD(String $id) 
    {
        $defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');
        $user = User::find($id);
        $user->password = Hash::make($defaultPWD);
        $user->defaultPWD = 1;
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function showDefaultPWD()
    {
        $defaultPWD = env('DEFAULT_PWD', '--none--');
        return response()->json($defaultPWD, 200);
    }

    /* This function is called from lockers.main.blade.php
	*/
	public function verifyHomeRoom(Request $request) {
        $code = $request->input('code');
        $code = strtoupper($code);
        $code = trim($code);
        $code = str_replace("-","",$code);
		//print_r($code);
        
        //Now search for the couse code and see if it exists and if it is in period 1
        //coursecode 	teacher period 	room
        $course = Course::find($code);
        if ($course == null) {
			return response()->json(['status' => 'failure']);
        }

        if ($course->period == 1) {
			return response()->json(['status' => 'success']);
		} else {
			return response()->json(['status' => 'wrongperiod']);
		}
		
	}
    
}

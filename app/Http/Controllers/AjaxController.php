<?php

namespace App\Http\Controllers;

use App\User;
use App\Kiosk;

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

    /* This function is used by terminal.blade.php
		It checks to see if the user has entered the default teacher password correctly
		It returns a JSON response of success or fail.
	*/
	public function verifyHomeRoom(Request $request) {
        $code = $request->input('code');
        $code = strtoupper($code);
        $code = trim($code);
        $code = str_replace("-","",$code);
		//print_r($code);
        
        //Now search for the couse code and see if it exists and if it is in period 1
        //coursecode 	teacher period 	room

		//$correct = \App\User::where('username','teacher')->first()->password;
		//print_r($correct);
		
		//if (Hash::check($password, $correct)) {
		//	return response()->json(['status' => 'success']);
		//} else {
			return response()->json(['status' => 'failure']);
		//}
		
	}
    
}

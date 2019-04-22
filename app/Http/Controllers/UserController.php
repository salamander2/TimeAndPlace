<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| User Controller
|--------------------------------------------------------------------------
|
| Controller to handle any user functions
| * change user's password
| 
*/
class UserController extends Controller
{
	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('verifyTeacherPWD');
	}

	public function showChangePasswordForm(){
		//prevent default user from changing password
		if (Auth::user()->isDefaultUser) return redirect()->back();
		return view('user.changePassword');
	}

	public function changePassword(Request $request){
		if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
			// The password does not match
			return redirect()->back()->with("error","Your current password does not match with the password you provided. Please try again.");
		}
		if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
			//Current password and new password are NOT the same
			return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
		}
		$validatedData = $request->validate([
				'current-password' => 'required',
				'new-password' => 'required|string|min:6|confirmed',
		]);
		//Change Password
		$user = Auth::user();
		$user->password = bcrypt($request->get('new-password'));
		$user->defaultPWD = 0;
		$user->save();
		//return redirect()->back()->with("success","Password changed successfully !");
//		return redirect('home')->with("success","Password changed successfully !");
		return redirect()->route('home')->with("success","Password changed successfully !");
	}

	/* This function is used by terminal.blade.php
		It checks to see if the user has entered the default teacher password correctly
		It returns a JSON response of success or fail.
	*/
	public function verifyTeacherPWD(Request $request) {
		$password = $request->input('pwdin');
		//print_r($password);
        
		$correct = \App\User::where('username','teacher')->first()->password;
		//print_r($correct);
		
		if (Hash::check($password, $correct)) {
			return response()->json(['status' => 'success']);
		} else {
			return response()->json(['status' => 'failure']);
		}
		
	}

}

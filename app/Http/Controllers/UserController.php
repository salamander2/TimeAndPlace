<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 */
	public function index()
	{
		return view('admin.users');
		#return view('home');
	}

	public function showChangePasswordForm(){
		return view('auth.changePassword');
	}

	public function changePassword(Request $request){
		if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
			// The passwords matches
			return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
		}
		if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
			//Current password and new password are same
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
}

<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	/*
	   |--------------------------------------------------------------------------
	   | Login Controller
	   |--------------------------------------------------------------------------
	   |
	   | This controller handles authenticating users for the application and
	   | redirecting them to your home screen. The controller uses a trait
	   | to conveniently provide its functionality to your applications.
	   |
	 */

	use AuthenticatesUsers;
	//All views etc. are here: ./vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//Comment out the next line so that anytime this route is called it will log the user out and take them to a login page.		
		
		// Auth::logout();		
		// Session::flush();
		
		$this->middleware('guest')->except(['logout', 'getLogout']);
		
	}

	/** MH. use username for loging in instead of email
	 */
	public function username()
	{
		return 'username';
	}
}

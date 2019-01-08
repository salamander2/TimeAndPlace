<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/userMaint';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
        $this->middleware('admin');
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fullname' => ['required', 'string', 'max:255'],
     	    /* MH. replace email with username 
		'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], */
     	    'username' => ['required', 'string', 'max:20', 'unique:users'], 
/*            'password' => ['required', 'string', 'min:6', 'confirmed'],	*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    //protected function store(array $data)
    {
		$defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');
        User::create([
            'fullname' => $data['fullname'],
            /*'email' => $data['email'],*/
            'username' => $data['username'],
            'password' => Hash::make($defaultPWD),
        ]);

		//		$data = null; //this should clear the fields in the /userMaint page.
		//no it doesn't! for some reason it clears $user as well.

		//TODO: clear the fields when we return to the page.

		//we don't want to return the new user that we just created, because that logs in the user!
		return $user; //return Auth::user(); does not work.

		//$user = User::create($request->all());
		//return redirect('/userMaint');
    }
}

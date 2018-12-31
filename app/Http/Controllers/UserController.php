<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\User;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
<<<<<<< HEAD
	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		//TODO: what is middleware('admin') ?
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 */
//	public function index()
//	{
//		return view('admin.users');
//		#return view('home');
//	}
    public function index()
    {
//        $users = DB::select('SELECT * FROM users ORDER BY username');
        $users = DB::table('users')
                ->orderBy('username', 'asc')
                ->get();

        return view('admin.userMaint', ['users' => $users]);
        //return view('userMaint');
        //return view('admin.users');
    }

	public function showChangePasswordForm(){
		return view('user.changePassword');
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
=======
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
//        $users = DB::select('SELECT * FROM users ORDER BY username');
        $users = DB::table('users')
                ->orderBy('username', 'asc')
                ->get();

        return view('admin.userMaint', ['users' => $users]);
        //return view('userMaint');
        //return view('admin.users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.createuser');
    }

/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $validatedRequest = $request->validate([
            'name_first'=> 'required|string|max:15',
            'name_last' => 'required|string|max:15',
            'email'     => 'required|email|unique:users|',
            'username'  => 'required|string|unique:users|min:5',
            'password'  => 'string|required',
        ]);
        User::create($validatedRequest);

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin.edituser')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $validatedRequest = $request->validate([
            'name_first'=> 'required|string|max:15',
            'name_last' => 'required|string|max:15',
            'email'     => 'required|email',
            'username'  => 'required|string|unique:users|min:5',
            'isadmin'   => 'required|integer',
        ]);
        //If there is a password change request
        $password = $request->input('password');
        if (isset($password)) {
            $user->update($validatedRequest);
            $user->password = Hash::make($password);
            $user->save();
        } else {
            $user->update($validatedRequest);
        }

        return view('admin.edituser')->with('user', $user);
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return view('admin.users');
    }
>>>>>>> 7885efdddf39269534c25c07c45ff4cc5c10d115
}

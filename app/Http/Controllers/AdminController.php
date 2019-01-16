<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| Admin Controller
|--------------------------------------------------------------------------
|
| This is based on Ethan's UserController
| * userMaint page
| * add, delete, change users
| * reset default password
| * show default password
 */


class AdminController extends Controller
{
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
        $this->middleware('admin');
        $this->middleware('auth');
		
    }

  
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function userIndex()
    {
//      $users = DB::select('SELECT * FROM users ORDER BY username');
        $users = DB::table('users')
            ->orderBy('username', 'asc')
            ->get();

        // return view('admin.userMaint', ['users' => $users]);
        return view('admin.userMaint') -> withUsers($users);
        //return view('userMaint');
        //return view('admin.users');
    }

    /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\User
    */
   protected function create(Request $request)
   //protected function store(array $data)
   {
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'alpha-dash', 'max:20', 'unique:users'], 
            'fullname' => ['required', 'string', 'alpha-dash', 'max:255']     	    
        ]);
    
       $defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');

       User::create([
           'fullname' => $validatedData['fullname'],
           /*'email' => $data['email'],*/
           'username' => $validatedData['username'],
           'password' => Hash::make($defaultPWD),
       ]);

       //		$data = null; //this should clear the fields in the /userMaint page.
       //no it doesn't! for some reason it clears $user as well.

       //TODO: clear the fields when we return to the page.

       //we don't want to return the new user that we just created, because that logs in the user!
       //return $user; //return Auth::user(); does not work.

       //$user = User::create($request->all());
       return redirect('/userMaint');
   }

    public function showDefaultPWD()
    {
        return redirect()->back()->with("error", env('DEFAULT_PWD', '--none--'));
    }


	// >>> this function is just for testing. RegisterController.php is actually used <<<<
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateOrEditUserRequest $request)
    {
        $defaultPWD = env('DEFAULT_PWD', 'G0^W$#SS54lhx');
        $request->merge(['password' => $defaultPWD]);

        $user = User::create($request->all());

        return redirect('/admin/users');
    }

    public function addKiosk() {
        return view('admin.createkiosk');
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
//==========================================================================
//			OLD STUFF BELOW HERE --- NOT USED

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create_old()
    {
        return view('admin.createuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store_old(Request $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $validatedRequest = $request->validate([
            'name_first' => 'required|string|max:15',
            'name_last' => 'required|string|max:15',
            'email' => 'required|email|unique:users|',
            'username' => 'required|string|unique:users|min:5',
            'password' => 'string|required',
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
    public function show_old(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit_old(User $user)
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
    public function update_old(Request $request, User $user)
    {
        $validatedRequest = $request->validate([
            'name_first' => 'required|string|max:15',
            'name_last' => 'required|string|max:15',
            'email' => 'required|email',
            'username' => 'required|string|unique:users|min:5',
            'isadmin' => 'required|integer',
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

}


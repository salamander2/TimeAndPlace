<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
		/* Why is the following in the standard RegisterController?
        $this->middleware('guest');
		It goes to Middleware/RedirectIfAuthenticated
         */
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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
//==========================================================================
//			OLD STUFF BELOW HERE --- NOT USED

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
}

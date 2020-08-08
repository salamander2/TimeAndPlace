<?php

namespace App\Http\Controllers;

use App\User;
use App\Kiosk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth');
        $this->middleware('admin');
		
    }

    /***************************** USER HANDLING  **************************************/

    /**
     * Display a listing of all users.
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
   protected function createUser(Request $request)
   //protected function store(array $data)
   {
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'alpha-dash', 'max:20', 'unique:users'],
            'fullname' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:255']
            //regex:  ^ start with    \s = matches whitespace \d = digit  \w = alphanumeric+underscore
            //          [] OR stuff inside   + means one or more of whatever is in the []   
            //          \pL means single codepoint in category letter (same as A-z , but for international letters)
            //          /u means treat string as UTF-8
            //          why does it start with a / (it always does)?
        ]);
    
       $defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');

       User::create([
           'fullname' => $validatedData['fullname'],
           'username' => $validatedData['username'],
           'password' => Hash::make($defaultPWD)
       ]);

       //		$data = null; //this should clear the fields in the /userMaint page.
       //no it doesn't! for some reason it clears $user as well.

       //TODO: clear the fields when we return to the page.

       //we don't want to return the new user that we just created, because that logs in the user!
       //return $user; //return Auth::user(); does not work.

       //$user = User::create($request->all());
       return redirect('/userMaint');
   }

    // public function showDefaultPWD()
    // {
    //     //this is a session variable. I'm calling it 'error'. It is not the same as the $errors array that Validate returns
    //     //renamed to be 'message' since 'error' is being used for user deletion
    //     return redirect()->back()->with("message", env('DEFAULT_PWD', '--none--'));
    // }
    // public function hideDefaultPWD()
    // {
    //     return redirect()->back();
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteUser(User $user)
    {
        $name = $user->fullname;
        $user->delete();
        return redirect('/userMaint')->with("error","User \"$name\" has been deleted");
        //return response()->json('Deleted',200);
    }


    /* moved to AjaxController
    public function resetPWD(String $id) 
    {
        $defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');
        $user = User::find($id);
        $user->password = Hash::make($defaultPWD);
        $user->defaultPWD = 1;
        $user->save();
        return response()->json(['status' => 'success']);
    }
    */


	// >>> this function is just for testing. RegisterController.php is actually used <<<<
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    /*
    public function store(CreateOrEditUserRequest $request)
    {
        $defaultPWD = env('DEFAULT_PWD', 'G0^W$#SS54lhx');
        $request->merge(['password' => $defaultPWD]);

        $user = User::create($request->all());

        return redirect('/admin/users');
    }
    */

    
}


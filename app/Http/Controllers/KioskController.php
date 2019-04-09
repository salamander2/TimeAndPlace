<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    /**
     * Where to redirect users after ???
     *
     * @var string
     */
    //protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //if user->isAdministrator  
        $this->middleware('admin')->only(['create','store','delete']);

	/* This has now been moved two two different places: 1. re web.php routes file will decide whether the user can 'edit' or just 'show' the kiosk.
	   And in this situation, I still need authentication to make sure that someone cannot edit the kiosk just by typing in the URL
	*/
       // $this->middleware('kioskAdmin')->only(['edit']);
    }


    /** INDEX
     * Display a listing of all Kiosks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        $kiosks = Kiosk::all();
        $my_kiosks = collect();
        $other_kiosks = collect();

        foreach($kiosks as $kiosk) {
            //this gets all users for that kiosk
            $users = $kiosk->users()->get();

            //if the user is not valid, then it returns a null
            $validUser = $users->where('id', '=', $user->id)->first();
            if ($validUser != null || $user->isAdministrator()) {
                $my_kiosks->push($kiosk);
            } else {
                $other_kiosks->push($kiosk);                
            }
        }
        
        return view('kiosks.index', compact('my_kiosks', 'other_kiosks'));  //NOTE: not $kiosks
    }

    /***************************** KIOSK -- admin only  **************************************/

    /** CREATE
     * Show the form for creating a new kiosk.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.createkiosk');
    }

    /** STORE
     * Store a newly created kiosk in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedKiosk = $request->validate([
            'name' => ['unique:kiosks', 'required', 'string', 'max:30', 'min:3'],
            'room' => ['required', 'string', 'max:20']            
        ]);

        Kiosk::create([
            'name' => $validatedKiosk['name'],
            'room' => $validatedKiosk['room'],
            // 'showPhoto' => $request->has('showPhoto') ? 1 : 0,            
            // 'showSchedule' => $request->has('showSchedule') ? 1 : 0,            
            // 'requireConf' => $request->has('requireConf') ? 1 : 0,            
            'publicViewable' => $request->has('publicViewable') ? 1 : 0,            
            'signInOnly' => ($request->signInOnly == "yes"),                        
            'autoSignOut' => $request->has('autoSignout') ? 1 : 0,            
            'secretURL' => Hash::make(str_random(8)),
        ]);
    
        //$kiosk = new Kiosk();
        //$kiosk->save();
        //dd($validatedKiosk->all());
        return redirect('/kiosks');
    }

     /** DELETE
     * Delete the specified kiosk
     *
     * @param  \App\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kiosk $kiosk)
    {
        $name=$kiosk->name;
        //dd("deleting kiosk " . $kiosk->id);
        $kiosk->delete();
        return redirect('/kiosks')->with("error","Kiosk \"$name\" has been deleted");;
    }


    /** SHOW
     * Display the specified kiosk
     *
     * @param  \App\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function show(Kiosk $kiosk)
    {
        return view('kiosks.show', compact('kiosk'));
    }

    /** EDIT
     * Show the form for editing the specified kiosk.
     *
     * @param  \App\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function edit(Kiosk $kiosk)
    {

        //TODO: have two views. One that is simple -- for "SigninOnly", the other that has all of the scheduling stuff
        $user = Auth::user();
	    if (! $user->isKioskAdmin($kiosk) ) return view('kiosks.show', compact('kiosk'));
	
        //Select all users who are not on THIS kiosk
        //and pass it to the view (for the lower portion of the kiosk)
        
        $detachedUsers = User::doesntHave('kiosks')->get();  //this finds all users with NO kiosk
               
        foreach ( User::all() as $user) {
            
            if ($user->kiosks->first() == null) continue; //already added above
            
            //if the user has a kiosk, but not this kiosk, then add it to $detachedUSers
            if ($user->kiosks->first()->id != $kiosk->id) {
                $detachedUsers[] = $user;
            }
        }

        $periods = $kiosk->sched_periods();
        $times = $kiosk->sched_times();
        
        return view('kiosks.edit', compact('kiosk','detachedUsers','periods','times'));
        
        //$detachedUSers = User::where('user->kiosks->kiosk_id','!=',1)->get();        
        //$kioskuser = KioskUser::where([['kiosk_id', $kiosk->id],['user_id', $user->id]])->get();        
        //$detachedUsers = Kiosk::where('id', '!=', $kiosk->id)->get();  //all kiosks except for the current one
    }

    /** UPDATE
     * Update the specified kiosk (save to database)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kiosk $kiosk)
    {
        $validatedKiosk = $request->validate([
            'name' => ['required', 'string', 'max:30', 'min:3'],
            'room' => ['required', 'string', 'max:20']            
        ]);
             
        $kiosk -> update([
            'name' => $validatedKiosk['name'],
            'room' => $validatedKiosk['room'],
            'showPhoto' => $request->has('showPhoto') ? 1 : 0,            
            'showSchedule' => $request->has('showSchedule') ? 1 : 0,            
            'requireConf' => $request->has('requireConf') ? 1 : 0,            
            'publicViewable' => $request->has('publicViewable') ? 1 : 0,            
            // 'signInOnly' => $request->has('signInOnly') ? 1 : 0,            
            'autoSignout' => $request->has('autoSignout') ? 1 : 0                       
        ]);
        return back();
    }

    public function delSchedule(Request $request, Kiosk $kiosk)
    {
        $kiosk->schedules()->detach($request->id);
        
        //Return with a status of removed
        return response()->json(['status' => 'removed']);
    }


    public function garbage(Kiosk $kiosk) {
        return view('kiosks.edit', compact('kiosk'));
    }
}

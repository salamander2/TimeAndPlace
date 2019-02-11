<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\User;

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
        $this->middleware('admin')->only(['create','store','delete']);
        $this->middleware('kioskUser')->only(['show', 'edit']);
        $this->middleware('auth');
    }


    /** INDEX
     * Display a listing of all Kiosks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kiosks = Kiosk::all();
        // foreach($kiosks as $kiosk) {
        //     print_r($kiosk);
        // }
        // dd('x');
        return view('kiosks.index', compact('kiosks'));  //NOTE: not $kiosks
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
            'showPhoto' => $request->has('showPhoto') ? 1 : 0,            
            'showSchedule' => $request->has('showSchedule') ? 1 : 0,            
            'requireConf' => $request->has('requireConf') ? 1 : 0,            
            'publicViewable' => $request->has('publicViewable') ? 1 : 0,            
            'signInOnly' => $request->has('signInOnly') ? 1 : 0,            
            'autoSignOut' => $request->has('autoSignOut') ? 1 : 0,            
            'secretURL' => '12345'
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
        dd("deleting kiosk " . $kiosk->id);
        $kiosk->delete();
        return redirect('/kiosks');
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

        return view('kiosks.edit', compact('kiosk','detachedUsers'));
        
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
            'room' => $validatedKiosk['room'],
            'showPhoto' => $request->has('showPhoto') ? 1 : 0,            
            'showSchedule' => $request->has('showSchedule') ? 1 : 0,            
            'requireConf' => $request->has('requireConf') ? 1 : 0,            
            'publicViewable' => $request->has('publicViewable') ? 1 : 0,            
            'signInOnly' => $request->has('signInOnly') ? 1 : 0,            
            'autoSignOut' => $request->has('autoSignOut') ? 1 : 0            
           
        ]);
        return back();
    }
}

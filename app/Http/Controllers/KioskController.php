<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    /**
     * Display a listing of all Kiosks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kiosks = Kiosk::all();
        return view('kiosks.index', compact('kiosks'));  //NOTE: not $kiosks ?!
    }

   // NOTE: CREATE, STORE, DESTROY moved to AdminController

    /**
     * Display the specified kiosk
     *
     * @param  \App\Models\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function show(Kiosk $kiosk)
    {
        //
    }

    /**
     * Show the form for editing the specified kiosk.
     *
     * @param  \App\Models\Kiosk  $kiosk
     * @return \Illuminate\Http\Response
     */
    public function edit(Kiosk $kiosk)
    {
        // dd($kiosk);
        return view('kiosks.edit', compact('kiosk'));
    }

    /**
     * Update the specified kiosk (save to database)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kiosk  $kiosk
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

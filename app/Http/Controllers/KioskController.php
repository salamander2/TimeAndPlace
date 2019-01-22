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
        //
    }

   
}

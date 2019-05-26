<?php

namespace App\Http\Controllers;
use App\Kiosk;
use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kiosk $kiosk)
    {
        // return view('events.create')->withKioskID($kiosk);
        return view('events.create',compact('kiosk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {           
        $validatedEvent = $request->validate([
            'name' => ['unique:events', 'required', 'string', 'max:30', 'min:3'],
        ]);
        
        Event::create([
            'kiosk_id'=>$request->kioskID,
            'name' => $validatedEvent['name'],
            'date' => $request->date,
            'startTime' => $request->startTime,
            'lateTime' => $request->lateTime,
            'endTime' => $request->endTime,
        ]);
        
        return redirect ('/kiosks/'.$request->kioskID.'/edit');        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

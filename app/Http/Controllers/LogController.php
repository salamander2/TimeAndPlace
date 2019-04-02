<?php

namespace App\Http\Controllers;

use App\Log;
use App\Kiosk;
use App\StudentSignedIn;
use Illuminate\Http\Request;

class LogController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logs = Log::all()->where('kiosk_id',$id);
        $kiosk = Kiosk::all()->find($id);
        
        return view('logs.index', compact('logs','kiosk'));
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

    public function autosignout() {
	$records = StudentSignedIn::all();

	foreach($records as $record) {
		$kioskID = $record->kiosk_id;
		$studentID = $record->studentID;
		$kiosk = Kiosk::find($kioskID);
             
		$kiosk->signedIn()->detach($studentID);

             	$kiosk->students()->attach($studentID, ['status_code' => 'AUTOSIGNOUT']);
	}
	dd ($records->count() . " students signed out. Please hit BACK and RELOAD screen.");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Kiosk;
use App\Student;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	/*$user = Auth::user();
	if ($user ->isAdministrator()) {
	        $phpmyadmin = env('PHPMYADMIN');
        	return view('admin.adminPage', compact('phpmyadmin'));
	}*/

        $kiosks = Kiosk::all()->where('publicViewable','=','1');

        //dd($kiosks);
        return view('home', compact('kiosks'));
    }

    /* This is the same as the main home index view, but for only one kiosk. 
    *  The blade template shows all students signed in, not just the most recent 10.
    */
    public function showKiosk(Kiosk $kiosk) {
        
        $tudent = $kiosk->signedIn->sortBy('pivot.created_at');
        //dd($kiosk);
        return view('studentsSignedIn', compact('kiosk','student'));
    }

    public function help() {
        return view('help');
    }

    public function home1()
    {
        return view('home1');
    }
}

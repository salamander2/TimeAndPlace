<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\Student;

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
		return view('home');
		
		// $db2 = \DB::connection('mysql2');
        // $courses = $db2->table('students')->find(1);
        // print_r($courses . '\n');
		
		// $kiosk = new Kiosk();
		// $record = $kisok->find(1);

		$student = new Student();
		$student ->setConnection('mysql2');
		$record = $student->find(302808019);
		// $record = $student->first();
		
		//getTest();
		dd($record);
		
	}

	//This works when I stick the code into tindex()
	public function getTest()
    {
        $db2 = \DB::connection('mysql2');
        $courses = $db2->table('courses')->get();
        print_r($courses . '\n');
    }
}

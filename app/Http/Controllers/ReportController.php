<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Kiosk;
use App\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {     
        $this->middleware('auth');     
    }

    
    public function attendance(Kiosk $kiosk) {
        //for now, this is just the current month
        $month = Carbon::now()->startOfMonth();	//sets time to 0:00:00
       
        $meetings = Meeting::where('created_at', '>', $month)->where('kiosk_id',$kiosk->id)->orderBy('date')->get()->unique('date');

        if ($meetings->count() == 0) {
            //send an error message
            //redirect back to some screen ... home page?
        }

        $array = array(); 
        $topRow[] = 'Student'; //this is used to match the dates
        $topRow2[] = 'Student'; //this is used for displaying nicely formatted dates

        foreach ($meetings as $meeting) {
            $topRow[] = $meeting->date;
            $topRow2[] = Carbon::parse($meeting->date)->format('D, d M Y');
        }
        $numDates = count($topRow);
        // dd($topRow);
        
        $monthlogs =  Log::where('created_at', '>', $month)->where('status_code','PRESENT')->with('student')->get();
        /* You cannot orderBy on a table connected using WITH. 
        You have to use the join() method to sort the entire collection (instead of the eager loading I was trying which just orders the relationship.)
            
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')->orderBy('roles.label')->select('users.*')->paginate(10);
        */

        //$logs = $monthlogs->orderBy('student.lastname')->get();
        //->sortBy('studentID.lastname');//->sortBy('studentID.firstname');
        //$monthlogs =  Log::where('created_at', '>', $month)->where('status_code','PRESENT')->orderBy('studentID->lastname')->get();//->sortBy('studentID.firstname');
        $logs = $monthlogs->sortBy('student.firstname')->sortBy('student.lastname');

        $currentID = "";
        $row = array_fill(0,$numDates, ' ');
        $array[]=$topRow2;

        foreach($logs as $log) {
            if ($log->studentID != $currentID) {
                //for everything except for the first time through (where there is no id)
                if ($currentID != "") {
                    $row[0]=$log->student->lastname.', '.$log->student->firstname;
                    $array[]=$row;
                    $row = array_fill(0,$numDates, ' ');
                }
                //array_push($row,$currentID);
                //insert studentID into first element in row
                $currentID = $log->studentID;
                $row[0]=$currentID;                
            }
            //dd($row);

            //now I have to find the correct column for the date.
            $date = $log->created_at->toDateString();

            $key = array_search($date, $topRow);
            $row[$key] = 'Y';
            
            
            // print_r($log->student->lastname . ', ' . $log->student->firstname);
            // print_r($log->created_at->format('D d M Y'));
            // print_r('<br>');
        }
        // print_r($topRow);
        // print_r('<br>');
        // print_r($row);   
            
        //dd($array);

        return view('reports.attendance', compact('kiosk','array'));//->with('array'=>$array);

    }
}

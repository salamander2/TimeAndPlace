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
        //sort by studentID first in case there are two people with the same name
        $logs = $monthlogs->sortBy('studentID')->sortBy('student.firstname')->sortBy('student.lastname');

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
 
/* How this all works

1. The kiosk is set to "signinonly" when it is created.
2. This means that there is no autologout and no schedule
3. Students sign in to a Terminal. Then the following happens:
   3.a. A Meeting record is created with the date, time and kiosk
   3.b. A "studentsignedin" record is created with studentID, kiosk and status of PRESENT
   3.c. A log entry is created as normal, but with the status of PRESENT
4. The next time a student signs in, it check to see if there is already a Meeting record for that day and kiosk.
   If there is, it does not create a new one.
5. If the same student tries to sign in again / sign out, it just says that he has already been marked present.
6. At midnight, all the studentsignedin records with PRESENT are deleted.
   Thus this system only works on a day-by-day basis. You cannot have two separate signins for the same kiosk on the same day.
7. To generate the attendance report the following is done:
   7.a. All meetings for the current month and this kiosk are selected and set to be the first row in an array/table
   7.b. All logs are selected that have that kiosk, that month, and status of PRESENT (?)
   7.c. These logs are sorted by name and student id (incase there are two students with the same name)
   7.d. The studentID is entered at the beginning of a new row. The date field is then matched with the meeting dates in the first row
        and a 'Y' is entered in the correct location of the array.
   7.e. We then proceed to all of the other logs for this student, and then to the subsequent students.

*/

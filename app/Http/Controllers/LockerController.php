<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use App\Locker;
use App\LockerStudent;
use App\Student_course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LockerController extends Controller
{
    public function __construct()
    {     
        $this->middleware('auth');     
    }
   
    /* This displays the main page for locker list maintenance */
    public function main()
    {
        return view('lockers.main');
    }

    /* This shows all the students for a home room. Teachers can add locker information here.
        Once it's added, it cannot be changed by the teachers */
    private function homeroom_orig($coursecode)
    {
        //this just gets a list of student_course records. I'd ideall like a pivot to get the student records.
        //  $sc_list = Student_course::where('coursecode', $coursecode)->get();
        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');
        //$students = Student_course::where('coursecode', $course)->withPivot('student')->get();
        //$students = Student::where('studentID', $sc_list->studentID);
        //$students = Student::where('studentID', '339356800')->get();

        /**** DAMN. I can't remember how to do a pivot or lookup to get the student records
         * using the results from the Student_course search. So I have to make an array. 
         * Collections don't work either: I  get a collection of collections! */
        /*
        $students = collect();
        foreach($sc_list as $value) {
            $oneRecord = Student::where('studentID', $value->studentID)->get();
            $students->push($oneRecord);
        }
        */
        //dd($students);
        // dd($students.'XXX'); //hey! This flattens the collection to a long list of its contents.
        //This still gives a collection of collections!
        //dd($coursecode);
        return view('lockers.homeroom', compact('coursecode','studentList'));
    }


    public function homeroom($coursecode)
    {
        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');
        return view('lockers.homeroom', compact('coursecode','studentList'));
    }

    public function edit() {
       return view('lockers.edit');
    }

    public function editLocker(Locker $locker) {
        //dd($locker);
       return view('lockers.edit', compact('locker'));
    }

    /* This has studentID, combination, and lockerNum variables in the Request object 
       It uses the LockerStudent table since we are not messing with the Student table in the other database in order to add
       locker information to it.
    */
    public function updateLocker (Request $request) {
        $studentID = $request->studentID;
        $locker_id = $request->lockerNum;
//        $student = Student::find($studentID);
        $locker = Locker::find($locker_id);

        $record = LockerStudent::where('studentID',$studentID)->where('locker_id',$locker_id)->first();
        if ($record == null) {
            //create and save a new LockerStudent record. 
            $lockerStudent = new LockerStudent;
            $lockerStudent->studentID = $studentID;
            $lockerStudent->locker_id = $request->lockerNum;
            $lockerStudent->save();
            //update locker status
            $locker->status = 1;
            $locker->save();
        } else  {
            dd ("This student has already been assigned to this locker!");
        }

       // if (!$locker->students->contains($studentID)) {
//            $locker->students()->attach($studentID); //no. Attach is used for many-to-many relationships
            //$locker->students()->save($locker);
//            $locker->students()->save($locker);
            //$student->lockers()->associate($locker)->save();
        //}
            dd("saved");
//       return view('lockers.edit', compact('locker'));
    }
}

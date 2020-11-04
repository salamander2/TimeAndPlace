<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use App\Course;
use App\Locker;
use App\LockerStatus;
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

    public function listing() {
        return view ('lockers.listing');
    }

    /* This shows all the students for a home room. Teachers can add locker information here.
        Once it's added, it cannot be changed by the teachers */
//    private function homeroom_orig($coursecode)
//    {
        //this just gets a list of student_course records. I'd ideall like a pivot to get the student records.
        //  $sc_list = Student_course::where('coursecode', $coursecode)->get();
//        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');
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
//        return view('lockers.homeroom', compact('coursecode','studentList'));
//    }

    /* Purpose: to check (i) if a course code is valid and (ii) if it is a home room.
    *  This function is called from lockers.main.blade.php  (which requires it to be a home room)
    *  and from lockers.listing.blade.php (which just needs the course code verified)
     */
	public function verifyHomeRoom(Request $request) {
        $code = $request->input('code');
//        $code = strtoupper($code);
 //       $code = trim($code);
//        $code = str_replace("-","",$code);
	  $code = \App\Student::sanitizeCourse($code);
        
        //Now search for the couse code and see if it exists and if it is in period 1
        //coursecode 	teacher period 	room
        $course = Course::find($code);
        if ($course == null) {
		return response()->json(['status' => 'failure']);
        }

        //A page that doesn't require the course to be a home room, can just ignore the 'wrongperiod' 
        //and check only to make sure that the status != failure
        if ($course->period == 1) {
			return response()->json(['status' => 'success']);
		} else {
			return response()->json(['status' => 'wrongperiod']);
		}
		
	}


    /* Purpose: to list all students in a home room (given by coursecode)
    * So that the user can enter locker information for that homeroom. 
    * (Technically, this should work for any course, not just a home room) */
    public function homeroom($coursecode)
    {
	$coursecode = \App\Student::sanitizeCourse($coursecode);
        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');

        //organize this into an array of data. Can't get a homemade collection to work!
        $array = array();
        // $students = collect();
        foreach ($studentList as $student) {
            // $students.put('studentID', $student->studentID);
//            $students=$students.concat(['name' => $student->lastname. ", ". $student->firstname]);
            $row = array();
            $row[] = $student->studentID;
            $row[] = $student->lastname. ", ". $student->firstname;

            $locker = LockerStudent::where('studentID',$student->studentID)->first();
            if ($locker != null) {
//                $students=$students.concat(['locker_id' => $locker->locker_id]);
//                $students=$students.concat(['combination' => '******']);
                $row[] = $locker->locker_id;
                $row[] = "********"; //for combination
            } else {
                $row[] = "";
                $row[] = "";
            }
            $array[] = $row;
        }

        //return view('lockers.homeroom', compact('coursecode','studentList'));
        return view('lockers.homeroom', compact('coursecode','array'));
    }

    /* Purpose: to print out a view-only listing of all of the students with their locker information for any course
    Normally, this would be for a homeroom since lockers are assigned by homeroom.
    It is based on function homeroom($coursecode) */
    public function courseRpt($coursecode)
    {
	$coursecode = \App\Student::sanitizeCourse($coursecode);
        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');

        //organize this into an array of data. Can't get a homemade collection to work!
        $array = array();
        // $students = collect();
        foreach ($studentList as $student) {
            // $students.put('studentID', $student->studentID);
//            $students=$students.concat(['name' => $student->lastname. ", ". $student->firstname]);
            $row = array();
            $row[] = $student->studentID;
            $row[] = $student->lastname. ", ". $student->firstname;

            $locker = LockerStudent::where('studentID',$student->studentID)->first();
            if ($locker != null) {
//                $students=$students.concat(['locker_id' => $locker->locker_id]);
//                $students=$students.concat(['combination' => '******']);
                $row[] = $locker->locker_id;
                $row[] = "********"; //for combination
            } else {
                $row[] = "";
                $row[] = "";
            }
            $array[] = $row;
        }

        //return view('lockers.homeroom', compact('coursecode','studentList'));
        return view('lockers.courseRpt', compact('coursecode','array'));
    }

    /* Purpose: call view lockers.edit when there is no specific locker specified. The user will type in a locker number */
    public function edit() {
       return view('lockers.edit');
    }

    /* Purpose: get all of the information for one locker and return it to a Blade view (lockers.edit)*/
    public function editLocker(Locker $locker) {
        $status = LockerStatus::find($locker->status)->status;
        //dd($locker);
        //get all locker_Student records
        $studentList = LockerStudent::where('locker_id',$locker->id)->with('student')->get()->pluck('student')->sortBy('lastname');
       return view('lockers.edit', compact('locker','status','studentList'));
    }

    /* This function sets the status on a particular locker to either
    *  available, damaged, or nonexistent. When it does so, it deletes any students attached to the locker.
    */
    public function setStatus(Request $request, Locker $locker) {
        //$status = $request->lstatus;
        $locker->status = $request->lstatus;
        $locker->combination = "";
        $locker->save();

        $records = LockerStudent::where('locker_id',$locker->id)->delete();
        //$records->delete();
        //dd($records);

        return redirect()->back();
    }

    /* 
    * Purpose: to add a student (id, combination) to a locker
    * Called from edit.blade.php . 
    * This already has checked to make sure that the student ID exists and is numeric
    * and that if it's a new locker, a combination has been entered.
    */
    public function addStudent(Request $request, Locker $locker) {
        $locker_id = $locker->id;
        $studentID = $request->addStudentID;

        //Data Verification 
        //does student exist?
        if (! Student::exists($studentID)) {
            return redirect()->back()->with("error","This student does not exist.");
        }
        //is the student already attached to that locker?
        $found = LockerStudent::where('locker_id',$locker_id)->where('studentID',$studentID)->count();
        if ($found > 0) {
            return redirect()->back()->with("error","This student is already assigned to this locker.");
        }

        //create and save a new LockerStudent record. 
        $lockerStudent = new LockerStudent;
        $lockerStudent->studentID = $studentID;
        $lockerStudent->locker_id = $locker_id;
        $lockerStudent->save();
        
        //add combination to locker (only if it is a new locker)
        if ($locker->status == 0) {
            $locker->combination = $request->newcombo;
            //update locker status
            $locker->status = 1;
            $locker->save();
        }
        return redirect()->back();
    }

    /* 
    * Purpose: to delete student from a locker, and if it's the last one, then also delete the combination and reset the status
    * Called from edit.blade.php . 
    */
    public function delStudent(Request $request, Locker $locker) {
        $locker_id = $locker->id;
        $studentID = $request->delStudentID;

        LockerStudent::where('locker_id',$locker_id)->where('studentID',$studentID)->delete();
        
        //reset locker status and combination (only if it's the last student using it)
        $found = LockerStudent::where('locker_id',$locker_id)->count();
        if ($found == 0) {
            $locker->combination = "";
            $locker->status = 0;
            $locker->save();
        }
        return redirect()->back();
    }

    public function newCombo(Request $request, Locker $locker) {
        if ($locker->status == 1) { //assigned
            if (strlen($request->newcombo)> 0) {
                $locker->combination = $request->newcombo;
                $locker->save();
            }
        }
        return redirect()->back();
    }


    /* Called from homeroom.blade.php
    *  Purpose: to add a locker and combination for a particular student in the home room listing
    *  This has studentID, combination, and lockerNum variables in the Request object 
    *  It uses the LockerStudent table since we are not messing with the Student table in the other database in order to add
    *  locker information to it.
    */
    public function updateLocker (Request $request) {
        $studentID = $request->studentID;
        $locker_id = $request->lockerNum;
        
//        $student = Student::find($studentID);
        $locker = Locker::find($locker_id);

        //check status
        switch ($locker->status) {
            case -2:
                return redirect()->back()->with("error","This locker is nonexistent!");
            break;
            case -1:
                return redirect()->back()->with("error","This locker is damaged (and unavailable).");
            break;
        }

        $record = LockerStudent::where('studentID',$studentID)->where('locker_id',$locker_id)->first();
        if ($record != null) {
            return redirect()->back()->with("error","This student has already been assigned to this locker!");
        }

        //TODO: pop up message about sharing the locker if other students are using it.

        //create and save a new LockerStudent record. 
        $lockerStudent = new LockerStudent;
        $lockerStudent->studentID = $studentID;
        $lockerStudent->locker_id = $request->lockerNum;
        $lockerStudent->save();
        //add combinatin
        $locker->combination = $request->combination;
        //update locker status
        $locker->status = 1;
        $locker->save();

       // if (!$locker->students->contains($studentID)) {
//            $locker->students()->attach($studentID); //no. Attach is used for many-to-many relationships
            //$locker->students()->save($locker);
//            $locker->students()->save($locker);
            //$student->lockers()->associate($locker)->save();
        //}
            //dd("saved");
        return redirect()->back();
//       return view('lockers.edit', compact('locker'));
    }

    /* Purpose: to change the status of a range of lockers. The input has already been validated in the blade view (javascript)
    */
    public function massAssign(Request $request) {
        $startnum = $request->startnum;
        $endnum = $request->endnum;
        $status = $request->lstatus; 
        for ($x = $startnum; $x <= $endnum; $x++) {
            $locker = Locker::find($x);
            $locker->status = $status;
            $locker->save();
            LockerStudent::where('locker_id',$x)->delete();
        }
        return redirect()->back()->with("success","Locker statuses have been changed.");

    }
}

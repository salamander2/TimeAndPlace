<?php

namespace App\Http\Controllers;

use App\User;
use App\Student;
use App\Course;
use App\Student_course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClassListController extends Controller
{
    public function __construct()
    {     
        $this->middleware('auth');     
    }
   
    /* This displays the main page for locker list maintenance */
    public function classlist()
    {
        return view('classlist.list');
    }

    public function showCourses() {
        $courses = Course::all();

        print("<table>");
        print("<tr><th>Course</th><th>Teacher</th><th>Period</th></tr>");
        foreach ($courses as $course) {
            $coursename = $this->formatCourse($course->coursecode);
            printf("<tr><td>%s</td><td>%s</td><td>&nbsp;%s</td></tr>", $coursename, $course->teacher, $course->period);
            
        }  
        print("</table>");
            // print_r($course->coursecode ." ... " . $course->teacher . "<br>");
    }

    //changes course name to look like this ESLAO1-01 (adds in hyphen)
    protected function formatCourse($course) {
        if (strlen($course) != 8) return $course;

        $temp = substr($course,0,6) . "-" . substr($course,6);
        return $temp;
    }

    public function show(Request $request)    
    {
        $coursecode = $request->coursecode;
        //fix coursecode formatting for SQL retrieval
        $coursecode = strtoupper($coursecode);
        $coursecode = trim($coursecode);
        $coursecode = str_replace("-","",$coursecode);

        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');

        $coursecode = $this->formatCourse($coursecode);

        if (count($studentList) == 0) return redirect()->back()->with("error","Check your course code ($coursecode). There are no students listed for it.");

        print("<!DOCTYPE HTML><HTML><BODY>");
        print("<h2>" . $coursecode . "</h2>");
        print("<table>");
        print("<tr><th>StudentID</th><th>Name</th><th>Login</th></tr>");
        
        $i = 1;
        foreach ($studentList as $student) {
            printf("<tr><td>%d. &nbsp; %s &nbsp; </td><td>: &nbsp; %s, %s</td><td>&nbsp;%s</td></tr>",$i, $student->studentID, $student->lastname, $student->firstname, $student->loginID);
            $i++; 
        }  
        print("</table>");
    }

    public function showContacts(Request $request)    
    {
        $coursecode = $request->coursecode;
        //fix coursecode formatting for SQL retrieval
        $coursecode = strtoupper($coursecode);
        $coursecode = trim($coursecode);
        $coursecode = str_replace("-","",$coursecode);

        $studentList = Student_course::where('coursecode', $coursecode)->with('student')->get()->pluck('student')->sortBy('lastname');

        $coursecode = $this->formatCourse($coursecode);

        if (count($studentList) == 0) return redirect()->back()->with("error","Check your course code ($coursecode). There are no students listed for it.");

        print("<!DOCTYPE HTML><HTML><BODY>");
        print("<h2>" . $coursecode . "</h2>");
        print("<table>");
        print("<tr><th>Student Name</th><th>Guardian Phone</th><th>Guardian Email</th></tr>");
        
        $i = 1;
        foreach ($studentList as $student) {
            printf("<tr><td>%d. &nbsp; %s, %s</td><td>&nbsp;%s</td><td>&nbsp;%s</td></tr>",$i, 
            $student->lastname, $student->firstname, $student->guardianPhone, $student->guardianEmail);
            $i++; 
        }  
        print("</table>");

        print("<hr><h2> Email list only </h2>");
        print("<h4>For copying into email program <span style=\"color:red;\">(Check the list first to make sure it's correct.)</span></h4>");
        print("<table>");
        
        foreach ($studentList as $student) {
            printf("<tr><td>%s</td></tr>", $student->guardianEmail);
        }  
        print("</table>");
    }

    public function homeroomRpt($coursecode)
    {
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

            $array[] = $row;
        }

        //return view('lockers.homeroom', compact('coursecode','studentList'));
        return view('lockers.homeroomRpt', compact('coursecode','array'));
    }

    public function edit() {
       return view('lockers.edit');
    }

    /* get all of the information for one locker */
    public function editLocker(Locker $locker) {
        $status = LockerStatus::find($locker->status)->status;
        //dd($locker);
        //get all locker_Student records
        $studentList = LockerStudent::where('locker_id',$locker->id)->with('student')->get()->pluck('student')->sortBy('lastname');
       return view('lockers.edit', compact('locker','status','studentList'));
    }

}

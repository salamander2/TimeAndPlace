<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Course;

class StudentController extends Controller
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
        //$db2 = \DB::connection('mysql2');
        //$courses = $db2->table('students')->find(1);
        //print_r($courses . '\n');

        $student = new Student();
		$student ->setConnection('mysql2');
		//$record = $student->find(362872029);
        $record = $student->first();
        $age = $this->getAge($record->dob);
        return view('student')->withRecord($record)->withAge($age);
        //dd($record);
    }

   
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        // $db2 = \DB::connection('mysql2');
        // $courses = $db2->table('courses')::all();//->find(1);
        
        $courses = Course::all();
        //$course = $courses->first();
        //dd($course->teacher);

        foreach ($courses as $course) {
            print_r($course->teacher);
            // dd($course->first());
        }   
        
        //THIS WORKS: 
        // $kiosks = Kiosk::all();
        // foreach($kiosks as $kiosk) {
        //     print_r($kiosk);
        // }
        // dd('x');
    }

    private function getAge($then) {
        $then = date('Ymd', strtotime($then));
        $diff = date('Ymd') - $then;
        $age = substr($diff,0,-4);
        //try to get decimal years!
        //$age= sprintf("%u.%u",substr($diff, 0, 2),substr($diff,2,2));
        return $age;
    }
    
    /* get courses .... 
    //get timetable
    $sql = "SELECT courses.coursecode, teacher, period, room FROM courses INNER JOIN student_course ON courses.coursecode = student_course.coursecode WHERE studentID = ? ORDER BY period";
    if ($stmt = $schoolDB->prepare($sql)) {
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        // save output into array of rows in $timetable 
        $timetable = $stmt->get_result();
        $stmt->close();
    }


     if ($timetable->num_rows == 0) {
        echo "<tr><td colspan=4> no timetable </td></tr>";
    } else {
        while ($row = mysqli_fetch_assoc($timetable)) {
            $coursecode = formatCourse($row['coursecode']);

            $text = "<td>".$row['period'] ."</td><td>". $coursecode ."</td><td>". $row['teacher'] ."</td><td>". $row['room'] . "</td>";
            echo "<tr>" . $text . "</tr>";
        }
    }

*/
    //changes course name to look like this ESLAO1-01 (adds in hyphen)
    private function formatCourse($course) {
        if (strlen($course) != 8) return $course;

        $temp = substr($course,0,6) . "-" . substr($course,6);
        return $temp;
    }
}
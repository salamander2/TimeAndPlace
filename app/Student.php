<?php

namespace App;

use App\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'mysql2';
    protected $primaryKey = 'studentId';

    public function kiosks()
    {
        return $this->belongsToMany(Kiosk::class,'mysql.kiosks')->withPivot('status')->withTimestamps();
    }

    
    function formatCourse($course) {
        if (strlen($course) != 8) return $course;
     
        $temp = substr($course,0,6) . "-" . substr($course,6);
        return $temp;
     }
     
    
    public function getTimeTable() {
        //we don't want the timetable field. All of the info has already been processed and is in the student_course file

        // \App\Student_course::where('studentID','=', '302808019')->get();

        $db2 = DB::connection('mysql2');
        //$courses = $db2->table('students')->find(1);
        //print_r($courses . '\n');
        // $courses = DB::select('SELECT mysql2.courses.coursecode FROM mysql2.courses INNER JOIN mysql2.student_course ON mysql2.courses.coursecode = mysql2.student_course.coursecode WHERE studentID = ? ORDER BY period',[$this->studentID]);
       $courses = $db2->select('SELECT courses.coursecode, teacher, period, room FROM courses INNER JOIN student_course ON courses.coursecode = student_course.coursecode WHERE studentID = ? ORDER BY period',[$this->studentID]);

        
      //  dd($courses);

        // $sql = "SELECT courses.coursecode, teacher, period, room FROM courses INNER JOIN student_course ON courses.coursecode = student_course.coursecode WHERE studentID = ? ORDER BY period";
        // if ($stmt = $schoolDB->prepare($sql)) {
        // /* bind parameters for markers */
        //     $stmt->bind_param("i", $studentID);
        //     $stmt->execute();
        //     /* save output into array of rows in $timetable */
        //     $timetable = $stmt->get_result();
        //     $stmt->close();
        // } else {
        //     $message_  = 'Invalid query: ' . mysqli_error($schoolDB) . "\n<br>";
        //     $message_ .= 'SQL: ' . $sql;
        //     die($message_);
        // }

    }
}

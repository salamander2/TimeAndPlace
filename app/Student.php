<?php

namespace App;

use App\Course;
use App\Locker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    protected $connection = 'mysql2';
    protected $primaryKey = 'studentId';

    public function kiosks()
    {
        dd("Student.php : do you mean the logs table or the student_signed_in table?");
        // This line works, until I enable foreign keys
        // return $this->belongsToMany(Kiosk::class,'mysql.kiosks')->withPivot('status')->withTimestamps();
        return $this->belongsToMany(Kiosk::class,'mysql.kiosks')->withPivot('status_code')->withTimestamps();

        /* public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                 $parentKey = null, $relatedKey = null, $relation = null)
            second parameter is table name if it is not like "product_shop" or "kiosk_sudent"
            Next two parameters are the actual field names of that pivot table, if they are different than default product_id and shop_id.
            Then just add two more parameters – first, the current model field, and then the field of the model being joined.
        */
                                

    }

    // public function lockers()
    // {
    //     return $this->belongsTo(Locker::class);
    // }

    /** formatCourse
     * Add - into the correct place in the course code
     *
     * @param  \App\Course  $course
     * @return String
     */    
    function formatCourse($course) {
        if (strlen($course) != 8) return $course;
     
        $temp = substr($course,0,6) . "-" . substr($course,6);
        return $temp;
     }
     
     //TODO This doesn't actually need the ID as a parameter since a student record automatically has an id (unless this is a static method)
    /** getPhotoURL
     * return the student photo URL based on the id
     *
     * @param  int $id
     * @return String
     */
     public function getPhotoURL($id) {
        $imageURL = Storage::disk('public')->url('photos/'.$id.'.jpg');        
        $image = Storage::disk('public')->exists('photos/'.$id.'.jpg');
        if ($image == null) {
            $imageURL = Storage::disk('public')->url('photos/user_blank.png');
        }
         // The imageURL is wrong: "http://localhost/storage/user_blank.png"  
        // it should be http://localhost:8888/storage/user_blank.png
        //so now it will be "/storage/user_blank.png"
        $strpos = strpos($imageURL,'/storage');
        $imageURL = substr($imageURL, $strpos);

        return $imageURL;
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

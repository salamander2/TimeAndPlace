<?php

namespace App\Http\Controllers;
use App\Log;
use App\User;
use App\Kiosk;
use App\Student;
use App\Comment;
use App\Waitlist;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {       
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function deleteGradView(){
        return view('admin.delGrads');
    }
    
    /* This function deletes students who are not longer at Beal.
    It also deletes all associated records (based on student ID).
    The basic criterion is students who are no longer in the markbook file.
    After that, the age is examined: any students over 21 are automatically deleted.
    Students under 21 may or may not be deleted depending on other criteria 
    
    NOTE: the admin user of this Laravel installation must have UDATE and DELETE access to Student.
    REVOKE ALL PRIVILEGES ON `schoolDB`.* FROM 'timeandplace'@'localhost'; GRANT SELECT, UPDATE, DELETE, REFERENCES ON `schoolDB`.* TO 'timeandplace'@'localhost';
    */
    public function deleteGrads(Request $request)
    {
        //The following will save the file to ? storage?
        //$request->fileupload->store('markbook','mb.txt');
        
        //dd($request->fileupload); //this gives all of the file parameters
        
        //This line actually reads the file from the disk, so if you change the contents of the file and refresh this page, it reads the new contents!!
        $file = $request->fileupload;
        $data = array_map('str_getcsv', file($file));
        
        $markbookIDs = array(); // make array of only studentIDs from the markbook file
        foreach ($data as $index => $record)
        {
            if ($index === 0) //ignore the first row.
            {} 
            else {
                $markbookIDs[] = $record[0];
            }
        }
        
        /******************************** DO TESTS TO VERIFY MARKBOOK INPUT FILE IS REASONABLE SURE TO BE SUITABLE *******************/
        //Check#1: are there a reasonable number of records (for a high school)?
        //TODO : this should return an error to a Blade View
        $dataOK = $this->del_check1($data);
        if ($dataOK)
        print("Data length ok"."<br>");
        else
        dd("error, data is too short");
        
        //check number 2: is the first field of each numeric?
        $dataOK = $this->del_check2($markbookIDs);
        
        if ($dataOK)
        print("Student numbers ok<br>");
        else
        dd("ERROR: non-numeric student number");
        
        //check #3: fewer than 25% should be new students (student numbers that don't exist in this database)
        //        $dataOK = $this->del_check3($markbookIDs);
        if ($dataOK)
        print("Fewer than 25% new students - ok<br>");
        else
        dd("More than 25% new records.");
        
        /************************* END OF MARKBOOK FILE CHECKS *************************/
        
        /* 
        Now select all of the student numbers (from Student table)
        Go through each and see if it has a Markbook entry.
        if so ... go on to the next
        if not, determine whether to delete:
            if (age > 21) delete
            if student is on waitlist, do not delete
            if student has comments (sssDB) do not delete
            if student has logs from public kiosks, don't delete - because they are logging in and out somewhere in the school.
            
            ** Make a list of the NonDelete missing students
            ** Make a list of the ToDelete missing students
            
            Print both of these lists
            
            To delete:
            from studentDB
            delete all records with that id student_course,
            from loggerDB
            delete all records with that id from event_student
            from event_studentlist
            from locker_student
            from logs (this would be other logs that have been lingering. All logs should be deleted at the end of each year (or actually, archived for a year))
            
            over 21 age students: must also delete waitlist comments, next steps,
            No Delete: clear out the student time table information.
            */
            $noDelete = array();
            $yes21Delete = array();
            $yesDelete = array();
            $publicKiosks = Kiosk::where('publicViewable',1)->where('kioskType',0)->get();
            
            $allstudents = Student::all();
            /*>>>> BEGIN LOOP THROUGH EACH STUDENT RECORD <<<<<<*/
            
            foreach ($allstudents as $student)
            {
                $studentNum = $student->studentID;
                
                /*  NOT NEEEDED: in_array does numeric comparison (apparently) -- now it's messed up again! */
                //fix student numbers that begin with 0, 00, 000
                $stl = strlen($studentNum);
                $idToTest = $studentNum;
                if ($stl < 9) {
                    $idToTest = str_repeat("0", 9-$stl).$idToTest;
                    print(">>>".$idToTest . "<br>");
                }
                
                // if (array_key_exists($studentNum, $markbookIDs)) {
                if (! in_array($idToTest, $markbookIDs)) {
                    //check #1: age - is he/she 21 or older?
                    if($this->getAge($student->dob) >= 21) {
                        $yes21Delete[] = $studentNum;
                        continue;
                    }
                    
                    //check #2: do logs exist?
                    $dontDelete = $this->stu_check2($studentNum);
                    if ($dontDelete) {
                        //print("student ".$studentNum." has public log records");
                        $noDelete[] = $studentNum;
                        continue;
                    }
                    
                    //check #3: waitlist
                    $dontDelete = $this->stu_check3($studentNum);
                    if ($dontDelete) {
                        //print("student ".$studentNum." has waitlist entries");
                        $noDelete[] = $studentNum;
                        continue;
                    }
                    
                    //check #4: sssDB comments from this year
                    $dontDelete = $this->stu_check4($studentNum);
                    if ($dontDelete) {
                        print("student ".$studentNum." has sssDB comment entries");
                        $noDelete[] = $studentNum;
                        continue;
                    }
                    
                    //else: student gets deleted
                    $yesDelete[] = $studentNum;
                    
                    //print($studentNum . " " . $this->getAge($student->dob) ."<br>");
                }
                
            }
            /*>>>> END LOOP THROUGH EACH STUDENT RECORD <<<<<<*/
if (1 == 2) {
            /* ############# BEGIN DELETING STUDENTS ############### */
            //clear out the timetable for students (that are not getting deleted)
            foreach($noDelete as $studentNum) {
                $student = Student::where('studentID',$studentNum) ->first();   
                $student->timetable = "";
                //$student->save();
            }
            print("All timetables for questionable students have been reset<br>");

            //Now delete all over 21:
            // must also delete waitlist comments, next steps,
            foreach($yes21Delete as $studentNum) {                
                Log::where('studentID',$studentNum)->delete(); 
                Waitlist::where('studentID',$studentNum)->delete(); 
                Comment::where('studentID',$studentNum)->delete();  //this will also delete NextSteps since they are linked with foreign key
                Student::where('studentID',$studentNum) ->delete();   
            }
            print("All students 21 and over have been deleted<br>");
            /* ############# END DELETING STUDENTS ############### */
}            
            
            
            print("<br>end for now<br>");
            //Finally, print out the three lists in tabs on the results page.
            dd($noDelete);


            
        }
        
        function del_check1($data) {
            if (count($data) < 500) return false;
            else return true;
        }
        
        function del_check2($data) {
            foreach ($data as $record)
            {
                if (!is_numeric($record))  return false;
            }
            return true;
        }
        
        function del_check3($data) {
            $count = 0;
            foreach ($data as $record)
            {
                $student = Student::find($record) ?? $count++;
            }
            
            if ($count > count($data)*0.25) return false;
            return true;
        }
        
        //check student for deletion: does he have any logs in public kiosks? 
        //TODO: only check for logs since September of this year
        function stu_check2($studentNum){
            //$logs = Log::where('studentID',$studentNum)->get();
            //$logs = Log::where('studentID',$studentNum)->with('kiosk')->where('kiosk.publicViewable',1)->get();
            $logs = Log::where('studentID',$studentNum)->with('kiosk')->get();  //->where('kiosk.publicViewable',1)->get();
            if (count($logs) > 0) {
                foreach($logs as $log) {
                    if ($log->kiosk->publicViewable == 1 && $log->kiosk->kioskType == 0) {
                        return true; // true = don't delete
                    }
                }
            }
            return false;
        }
        
        //check student for deletion: does he have any waitlist entries
        function stu_check3($studentNum){
            //(waitlistDB: table waitlist)
            $logs = Waitlist::where('studentID',$studentNum)->get();
            
            if (count($logs) > 0) {
                return true; // true = don't delete
            }
            return false;
        }
        
        //check student for deletion: does he have any sssDB comments
        function stu_check4($studentNum){
            $logs = Comment::where('studentID',$studentNum)->get();
            
            if (count($logs) > 0) {
                dd($logs);
                return true; // true = don't delete
            }
            return false;
        }
        
        //Function to return the current age of the student based on birthday.
        //copied from StudentController.php
        private function getAge($then) {
            $then = date('Ymd', strtotime($then));
            $diff = date('Ymd') - $then;
            $age = substr($diff,0,-4);
            //try to get decimal years!
            //$age= sprintf("%u.%u",substr($diff, 0, 2),substr($diff,2,2));
            return $age;
        }
    }
    
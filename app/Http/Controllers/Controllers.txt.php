<?php

/*
 snippets of code from other controllers that are not longer being used, but that might be useful in figureing out how things work
*/

return response()->with()  XXX There is no WITH() for a Response()

//Terminal controller
 dd($kiosk->students); //this gets all the students connected to that kiosk in the logs table.
      
 // $kiosk->students()->updateExistingPivot($studentID,['deleted_at'=> Carbon::now()]); 
//dd(  $kiosk->students()->where('status','=','SIGNIN'));

 // $student->kiosks()->attach($kiosk->id);
// $kiosk->students()->attach($studentID); //this is redundant

// Kiosk.php
// return $this->belongsToMany(Student::class,'mysql2.students')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'schoolDB.students')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'KioskStudent')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'mysql.logs')->withPivot('status_id');
        //return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withPivot('status_id');
        return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withTimestamps();
        // return $this->belongsToMany(Student::class,'loggerDB.logs','studentID','kiosk_id')->withPivot('status_id');
  

//For debugging child blade view
/*
        $q = 'Hari';
        $students = Student::where('firstname','like', '%'.$q.'%')->get();
        //return $students;
         return view('child.childterminal', compact('students'));
        return view('child.childterminal') -> withStudents($students);
        dd($students->toArray());
        */
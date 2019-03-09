<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSignedIn extends Model
{    
    protected $table = 'students_signed_in';
    public $timestamps = true;
   
    /* 
    This is a table than links kiosks and students. It is very similar to the 'logs' table, 
    but that table is a permanent record of the day's logs.
    This table shows which students are SIGNED IN to a kiosk. 
    If the kiosk does not have the "SignedIn" property, 
    then all that happens is a Present record is created in the logs table.

    */

    public function students()
    {
        // return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID');
        return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withTimestamps();
    }
    
}

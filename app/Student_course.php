<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_course extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'student_course'; 


    public function student() {
//        return $this->belongsToMany(Student::class,'studentID', 'studentID');
        //return $this->hasMany(Student::class,'studentID', 'studentID');
        return $this->hasOne(Student::class,'studentID', 'studentID');
    }
    
}

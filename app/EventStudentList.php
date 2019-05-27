<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStudentList extends Model
{
    protected $table = 'event_studentlist';
    public $timestamps = true;

    protected $fillable = [
        'event_id','student_id'
    ];


    public function student() {
        return $this->hasOne(Student::class,'studentID', 'student_id');
    }
}

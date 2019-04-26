<?php

namespace App;

use App\Student;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = true;

    public function student() {
        return $this->hasOne(Student::class,'studentID', 'studentID');
    }
}

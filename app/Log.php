<?php

namespace App;

use App\Student;
use App\Kiosk;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = true;

    public function student() {
        return $this->hasOne(Student::class,'studentID', 'studentID');
    }
    public function kiosk() {
        return $this->belongsTo(Kiosk::class);
    }
}

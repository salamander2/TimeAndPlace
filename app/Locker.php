<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    public $timestamps = true;

    // public function students()
    // {

    //     //TODO: why does this not work if I add in timestamps? lockerController : updateLocker()
    //     return $this->hasMany(Student::class,'studentID','studentID');//->withTimestamps();
    // }

}

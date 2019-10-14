<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LockerStudent extends Model
{
    
    public $timestamps = true;

    protected $table = 'locker_student';

    protected $fillable = [
        'studentID', 'locker_id'
    ];

    public function student() {
        return $this->hasOne(Student::class,'studentID', 'studentID');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kiosk extends Model
{
    protected $fillable = [
        'room', 'name', 
        'secretURL', 'showPhoto',
        'showSchedule', 'requireConf',
        'publicViewable', 'signInOnly',
        'autoSignOut', 'defaultFreq'
    ];

    public $timestamps = true;
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('isKioskAdmin');
    }

    public function signedIn()
    {
        return $this->belongsToMany(Student::class,'loggerDB.students_signed_in','kiosk_id','studentID')->withTimestamps();
    }

    //This is the LOGS file!
    public function students()
    {
        return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withTimestamps();
    }
    
    // public function schedule()
    // {
    //     return $this->hasMany('App\KioskSchedule');
    // }
}

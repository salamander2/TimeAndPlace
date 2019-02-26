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

    public function students()
    {
        // return $this->belongsToMany(Student::class,'mysql2.students')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'schoolDB.students')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'KioskStudent')->withPivot('status_id');
        // return $this->belongsToMany(Student::class,'mysql.logs')->withPivot('status_id');
        //return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withPivot('status_id');
        return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withPivot('status')->withTimestamps();
        // return $this->belongsToMany(Student::class,'loggerDB.logs','studentID','kiosk_id')->withPivot('status_id');
    }
    
    // public function schedule()
    // {
    //     return $this->hasMany('App\KioskSchedule');
    // }
}

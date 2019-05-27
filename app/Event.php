<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'kiosk_id','name', 'startTime', 'lateTime', 'endTime', 'date'
    ];

    public $timestamps = true;

    public function kiosks()
    {
        return $this->belongsTo(Kiosk::class);
    }
    //TODO get this working. I'm actually writing the record out myself instead of using attach. I don't know why.
    //See EventController / signInStudent()
    // public function students()
    // {
    //     return $this->belongsToMany(Student::class);
    // }
}

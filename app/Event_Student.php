<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_Student extends Model
{
    protected $fillable = [
        'kiosk_id','student_id'
    ];

    protected $table = 'event_student';
    public $timestamps = true;

    public function events()
    {
        return $this->belongsTo(Event::class);
    }

    //TODO figure out this pivot stuff again
    // public function students()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    public function student() {
        return $this->hasOne(Student::class,'studentID', 'student_id');
    }

    public static function isSignedIn(int $studentID, int $eventID) {
        
        $records = Event_Student::where('student_id', '=', $studentID)->get();
        if ($records-> count() == 0) return false;
        // dd($records);
        $present = $records->where('event_id','=',$eventID);
        if ($present-> count() == 0) return false;
        return true;
        
    }
}

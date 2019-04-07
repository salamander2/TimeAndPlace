<?php

namespace App;
use App\Schedule;

use Illuminate\Database\Eloquent\Model;

class Kiosk extends Model
{
    protected $fillable = [
        'room', 'name', 
        'secretURL', 'showPhoto',
        'showSchedule', 'requireConf',
        'publicViewable', 'signInOnly',
        'autoSignout', 'defaultFreq'
    ];

    public $timestamps = true;
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('isKioskAdmin');
    }

    public function signedIn()
    {
        return $this->belongsToMany(Student::class,'loggerDB.students_signed_in','kiosk_id','studentID')->withTimestamps();
        /* public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                 $parentKey = null, $relatedKey = null, $relation = null)
            second parameter is table name if it is not like "product_shop" or "kiosk_sudent"
            Next two parameters are the actual field names of that pivot table, if they are different than default product_id and shop_id.
            Then just add two more parameters – first, the current model field, and then the field of the model being joined.
        */

        /* students_signed_in table
        This is a table that links kiosks and students. It is very similar to the 'logs' table, 
        but that table is a permanent record of the day's logs.
        This table shows which students are SIGNED IN to a kiosk. 
        // If the kiosk does not have the "SignedIn" property, 
        //then all that happens is a Present record is created in the logs table.

        Fields:  id (primary key)
            kiosk_id
            studentID
            status_code
    */
    }

    //This is the LOGS file!
    public function students()
    {
        return $this->belongsToMany(Student::class,'loggerDB.logs','kiosk_id','studentID')->withTimestamps();
    }
    
    public function schedule()
    {
        return $this->hasMany('App\KioskSchedule');
    }

    public function sched_periods() {
        
        $k_sched = $this->schedule()->get();
        $periods = collect();
        // dd($k_sched ->count());
        foreach($k_sched as $record) {
            $schedule = Schedule::where('id','=',$record->schedule_id)->first();
            
            if (strpos($schedule->code, ':') !== false) {
                //print_r($schedule->code);                
            } else {
                $periods->push($schedule);                
            }
        }
        return $periods;
    }

    public function sched_times() {
        
        $k_sched = $this->schedule()->get();
        $times = collect();
        // dd($k_sched ->count());
        foreach($k_sched as $record) {
            $schedule = Schedule::where('id','=',$record->schedule_id)->first();
            
            if (strpos($schedule->code, ':') !== false) {
                $times->push($schedule);                
            }
        }
        return $times;
    }
}

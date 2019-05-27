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
}

<?php

namespace App\Models;

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
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function schedule()
    {
        return $this->hasMany('App\Model\KioskSchedule');
    }
}

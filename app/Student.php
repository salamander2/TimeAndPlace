<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'mysql2';
    protected $primaryKey = 'studentId';

    public function kiosks()
    {
        return $this->belongsToMany(Kiosk::class)->withPivot('status_id');
    }
}

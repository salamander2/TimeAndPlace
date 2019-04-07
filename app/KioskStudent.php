<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KioskStudent extends Model
{    
    protected $table = 'logs';    //OR students_signed_in
    public $timestamps = true;
   // use SoftDeletes;

    /*
    Fields:  id (primary key)
        kiosk_id
        studentID
        status_code
    */
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];
}

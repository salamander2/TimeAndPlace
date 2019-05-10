<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','time','kiosk_id'];
}

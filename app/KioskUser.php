<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KioskUser extends Model
{
    protected $table = 'kiosk_user';
    protected $fillable = ['isKioskAdmin'];
}

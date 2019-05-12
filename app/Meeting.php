<?php

namespace App;

use App\Kiosk;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','time','kiosk_id'];
    public $timestamps = true;

    public function kiosk() {
        return $this->belongsTo(Kiosk::class);
    }

}

<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Waitlist extends Model
{
    protected $connection = 'mysqlW';
    protected $table = 'waitlist';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

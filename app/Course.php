<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'courses'; 
    protected $primaryKey = 'coursecode';
    public $incrementing = false;   //needed for non integer primary keys

}

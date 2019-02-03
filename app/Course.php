<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mysql2';
    protected $primaryKey = 'coursecode';
}

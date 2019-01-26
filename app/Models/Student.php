<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'mysql2';
    protected $primaryKey = 'studentId';
}

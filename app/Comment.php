<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    protected $connection = 'mysqlS';
    //protected $table = 'comments';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

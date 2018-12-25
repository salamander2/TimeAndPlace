<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //MH. changed email to username, added other fields. isAdmin should not be fillable. It must be set via SQL / phpMyAdmin
    // 'viewAll','defaultPWD' are set to default values
    protected $fillable = [
        'fullname', 'username', 'password'
    ];

    //MH - don't use this when you're using fillable: 	protected $guarded = ['isAdmin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}

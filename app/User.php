<?php

namespace App;

use App\Kiosk;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;
	public $timestamps = true;
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


	//MH. A function here can be called from MiddleWare
	public function isAdministrator()
	{			
		return ((bool) $this->isAdmin);
	} 

	public function isKioskAdmin(Kiosk $kiosk) {
		//all administrators can edit
		if ($this->isAdministrator()) return true;

		//this gets all users for that kiosk
		$users = $kiosk->users()->get();

		//if the user is not valid, then it returns a null
		$validUser = $users->where('id', '=', $this->id)->first();

		if( $validUser==null) return false;

		if ($validUser->pivot->isKioskAdmin == 1) return true;
		return false;
	}


	/* Called from middleware/validkioskUser, middleware/TerminalLockout */
	public function isKioskUser(Kiosk $kiosk) {
		if ($this->isAdministrator()) return true;
		//this gets all users for that kiosk
		$users = $kiosk->users()->get();

		//if the user is not valid, then it returns a null
		$validUser = $users->where('id', '=', $this->id)->first();
		if( $validUser==null) return false;
		else return true;
	}


	/* does the user belong to the kiosk? */
	//called from kiosk controller? and kioskusercontroller: many-to-many / attach and detach
	public function kiosks() 
	{
		return $this->belongsToMany(Kiosk::class)->withPivot('isKioskAdmin')->withTimestamps();
	}


	//might be called from child.kioskedit2.blade.php
	public function notThisKiosk($id) {
		return $this->belongsToMany(Kiosk::class)->wherePivot('kiosk_id', '!=', $id);
	}

}

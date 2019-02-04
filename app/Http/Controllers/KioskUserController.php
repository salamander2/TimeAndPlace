<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\User;
use App\KioskUser;
use Illuminate\Http\Request;


class KioskUserController extends Controller
{
    public function update(Kiosk $kiosk, User $user)
    {
        dd(request());
        // $user->setKioskAdmin(request()->has('isKioskAdmin'));
        $result = request()->has('isKioskAdmin');
        $result = $kiosk->users()->where(d,'1')->pivot->isKioskAdmin;//->where(user_id, $user->id)->pivot;//->isKioskAdmin;
        dd($kiosk->id .' '. $user->id . ' '.$result);
        // return $this->belongsToMany('App\Role')->wherePivot('approved', 1);
        dd( $kiosk -> users) ->wherePivot(user_id, $user->id);
        $kiosk -> users($user)->pivot->isKioskAdmin = (request()->has('isKioskAdmin'));
        return back();
    }

    public function store(Kiosk $kiosk)
    {
        // $attributes = request()->validate([
        //     'description' => ['required', 'min:3']
        // ]);
        // $kiosk->addUser($attributes);
        dd("not working. KioskUsersController.");
        return back();
    }
}

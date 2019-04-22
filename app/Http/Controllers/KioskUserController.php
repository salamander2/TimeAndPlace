<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\User;
use App\KioskUser;
use Illuminate\Http\Request;


class KioskUserController extends Controller
{
   
    public function toggleKioskAdmin(Kiosk $kiosk, User $user)
    {
        $kioskusers = KioskUser::where([['kiosk_id', $kiosk->id],['user_id', $user->id]])->get();
        
        $record = $kioskusers->first();
        $record->isKioskAdmin = !$record->isKioskAdmin;
        $record->save();
        
        return back();
    }

    public function attach(Kiosk $kiosk, User $user)
    {        
        if (!$user->kiosks->contains($kiosk->id)) {
            $user->kiosks()->attach($kiosk->id);            
        } else {            
            return redirect()->back()->with("error","User is already attached to this kiosk");
        }
        return back();
    }

    /** 
     * Delete a user from the selected kiosk.
     *
     * @param $kiosk
     * @param User $user
     *
     * @return bool
     */
    public function detach(Kiosk $kiosk, User $user)
    {         
        $kioskuser = KioskUser::where([['kiosk_id', $kiosk->id],['user_id', $user->id]])->get();        
        $record = $kioskuser->first();
        if ($record->isKioskAdmin == 1) {
            return redirect()->back()->with("error","Kiosk Admins cannot be deleted");
        }
        $kiosk->users()->detach($user->id);
        return back();
        //return response()->json(['status' => 'ok']);
    }
}

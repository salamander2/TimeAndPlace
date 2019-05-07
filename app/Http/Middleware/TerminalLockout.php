<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TerminalLockout
{
    /**
     * This middleware makes sure that the Terminal is locked out,
     * i.e. logged out as a user, .: a guest user.
     * 
     * Is this even necessary????
     * And when is the "lockout" ever used for anything?
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Auth::user());
        // dd($request->kiosk);
        $user = Auth::user();
        $kiosk = $request->kiosk;
        
        if (Auth::check()) { //if you are logged in set lockout flag to allow terminal to launch
            
            //but first you have to be one of the kiosk_users
            if ($user->isKioskUser($kiosk) ) {
                $request->session()->put('lockout', true);  
            } else {
                abort(403, "Unauthorised access. Only users assigned to this kiosk can start the Terminal");
            }
        } else {
            return redirect('/login'); //you're not logged in
        }
        return $next($request);
   }
}   
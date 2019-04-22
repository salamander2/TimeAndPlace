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
        if (Auth::check()) { //if you are logged in set lockout flag (for some reason?)
            $request->session()->put('lockout', true);  
        } else {
            return redirect('/login');
        }
        return $next($request);
   }
}   
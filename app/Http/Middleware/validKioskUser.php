<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Kiosk;
use Closure;

class validKioskUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //get current user record
        $user = Auth::user();
        
        //administrators can access all kiosks
        if( $user->isAdministrator()) return $next($request);

        //this gets all users for that kiosk
        $users = $request->kiosk->users()->get();

        //if the user is not valid, then it returns a null
        $validUser = $users->where('id', '=', $user->id)->first();

        abort_if( $validUser==null, 403, "Unauthorised access. Only administrators and valid users can edit kiosks");
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class IsAdministrator
{
    /**
     * This Middleware class is to check if someone is an administrator (ie. the isAdmin variable is TRUE)
     * It technically shouldn't be necessary as the Admin options should only be visible to isAdmin users, but it's a good
     * failsafe. (There are also roles/policies in Laravel and I could learn how to use those).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/'); // go to the login page
        }

        // abort_unless( (bool)$user->isAdmin, 403);
        // abort_unless( Auth::user()->isAdmin, 403);
        abort_unless( $user->isAdministrator(), 403);
        
        return $next($request);
    }
}

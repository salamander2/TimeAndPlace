<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class IsAdministrator
{
    /**
     * This Middleware class is to check if someone is an administrator (ie. the isAdmin variable is TRUE)
     * It technically shouldn't be necessary as the Admin options should only be visible to isAdmin users, but it's a good
     * failsafe. (There are also roles in Laravel and I could learn how to use those).
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

		//TODO: add a redirect.
        if (!Auth::user()->isAdmin) {
		//TODO: this following line does not work and I don't know why)
        //if (!Auth::user()->isAdministrator()) {
            return response('Sorry but you aren\'t an admin :P', 403);
        }

        return $next($request);
    }
}

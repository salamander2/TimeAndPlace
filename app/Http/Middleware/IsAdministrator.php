<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/'); // go to the login page
        }

        if (!Auth::user()->isAdministrator()) {
            return response('Sorry but you aren\'t an admin :P', 403);
        }

        return $next($request);
    }
}

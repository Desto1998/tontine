<?php

namespace App\Http\Middleware;

use App\Services\SessionService;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $is_active = Auth::user()->is_active;

        if ($is_active != 1) {
//            exit('Compte inactif');
            Auth::logout(); // log the user out of our application
            return Redirect::to('login')->with('danger','Votre  compte n\'est pas activé.'); // redirect the user to the login screen
//            return redirect('login')->with('danger','Votre  compte n\'est activé.');
        }
        if (!session('ROLES')) {
            (new SessionService())->makeData();
        }
        return $next($request);
    }
}

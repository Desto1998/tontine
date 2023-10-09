<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenceCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deploy_date = config('app.deploy_date');
        $date = new DateTime($deploy_date);
        $nbjour = 90;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
        if ($date<=date('Y-m-d')) {
            Auth::logout();
            return redirect()->route('login')->with('danger',"Désolé votre licence est inspirée, veillez souscrire a une nouvelle licence pour pouvoir continuer à exploiter la plateforme. Merci!");
        }
        return $next($request);
    }
}

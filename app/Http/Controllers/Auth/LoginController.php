<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\SessionService;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private SessionService $sessionService)
    {
        $this->middleware('guest')->except('logout');
        session(['url.intended' => url()->previous()]);
    }

    public function login(Request $request)
    {
        $remember_me = $request->has('remember');
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember_me)) {
            $user = auth()->user();
            Auth::login($user, $remember_me);
            session()->regenerate();
            $this->sessionService->makeData();
            $this->redirectTo = session()->get('url.intended');

            return redirect($this->redirectTo);

        } else {
            return back()->with('error', 'Adresse email ou mot de passe incorrect.');
        }

    }
}

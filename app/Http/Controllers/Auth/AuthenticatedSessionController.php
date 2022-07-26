<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cases;
use App\Providers\RouteServiceProvider;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // return view('auth.login');
        ActivityService::activityLogs('A', 'Halaman Login');

        return view('frontend.pages.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $cases = Cases::where("session", session()->getId())
            ->first();

        $request->authenticate();

        // $request->session()->regenerate();

        $cases->session = session()->getId();
        $cases->save();

        ActivityService::activityLogs('B', 'Berhasil Login');

        if(\Auth::check()) {
            $role = Auth::user()->role;
            if($role == 'admin') {
                return redirect()->intended(RouteServiceProvider::ADMIN);
            }
            return redirect()->intended(RouteServiceProvider::USERS);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        ActivityService::activityLogs('L', 'Logout');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function destroySession(Request $request) {

    }
}

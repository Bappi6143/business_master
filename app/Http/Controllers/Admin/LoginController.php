<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('authenticate.login');
    }

    /**
     * Handle the login process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication was successful
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }



    /**
     * Handle user logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

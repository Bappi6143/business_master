<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Check if the user is inactive
            if ($user->status === 'inactive') {
                // Logout the user
                Auth::logout();

                // Redirect to login page with a message
                return redirect()->route('login')->with('error', 'Your account has been deactivated.');
            }
        }

        // If the user is active, proceed to the next request
        return $next($request);
    }
}
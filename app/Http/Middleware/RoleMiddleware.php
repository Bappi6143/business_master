<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If user role exists and is in the allowed roles, allow access
        if ($user->role && in_array($user->role->name, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}

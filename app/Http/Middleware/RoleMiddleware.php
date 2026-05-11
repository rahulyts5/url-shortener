<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user's role is allowed
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized. You do not have access to this page.');
        }

        return $next($request);
    }
}

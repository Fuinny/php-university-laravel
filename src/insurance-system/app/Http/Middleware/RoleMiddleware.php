<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null)
    {
        if (!$request->user()) {
            abort(403);
        }

        if ($role === null) {
            return $next($request);
        }

        if (strtolower($request->user()->type) === strtolower($role)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}

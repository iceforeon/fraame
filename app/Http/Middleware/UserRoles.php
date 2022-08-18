<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserRoles
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        return collect($roles)->contains($request->user()->role)
            ? $next($request)
            : abort(401);
    }
}

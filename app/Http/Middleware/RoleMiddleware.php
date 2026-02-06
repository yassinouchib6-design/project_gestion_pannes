<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        $role = $user->role ?? 'utilisateur';

        if (!in_array($role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
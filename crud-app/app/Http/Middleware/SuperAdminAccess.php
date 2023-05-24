<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminAccess
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
namespace App\Http\Middleware;

use Closure;

class AdminAccess
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}


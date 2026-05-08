<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminHrMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'hr'])) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}

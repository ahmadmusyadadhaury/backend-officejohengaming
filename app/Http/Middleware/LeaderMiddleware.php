<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LeaderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'hr', 'ceo', 'admin', 'admin_ga'])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TicketLeaderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isTicketLeader()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Leader IT.');
        }

        return $next($request);
    }
}

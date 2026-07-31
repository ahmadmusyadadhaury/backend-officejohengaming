<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TicketTeamMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isTicketTeam()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Tim IT.');
        }

        return $next($request);
    }
}

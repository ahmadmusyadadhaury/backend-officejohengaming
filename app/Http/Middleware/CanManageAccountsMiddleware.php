<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanManageAccountsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403);
        }

        $role = auth()->user()->role;

        // Route admins (kelola admin) hanya untuk admin master
        if ($request->routeIs('admin.admins.*') && $role !== 'admin') {
            abort(403, 'Hanya Admin Master yang dapat mengelola akun admin.');
        }

        // Route users (kelola akun) untuk admin master dan HR
        if ($request->routeIs('admin.users.*') && !in_array($role, ['admin', 'hr'])) {
            abort(403, 'Hanya Admin Master dan HR yang dapat mengelola akun.');
        }

        return $next($request);
    }
}

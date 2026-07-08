<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization', '');

        if (! str_starts_with($header, 'Bearer ')) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $token = substr($header, 7);
        $apiToken = ApiToken::findByToken($token);

        if (! $apiToken) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        if ($apiToken->expires_at && $apiToken->expires_at->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        Auth::login($apiToken->user);

        $apiToken->update(['last_used_at' => now()]);

        return $next($request);
    }
}

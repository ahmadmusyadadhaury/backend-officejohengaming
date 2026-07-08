<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        if (! Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'error' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();

        $token = ApiToken::generateToken();
        $apiToken = ApiToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'name' => 'API Token',
            'expires_at' => now()->addDays(30),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
            ],
            'token' => $token,
            'expires_at' => $apiToken->expires_at,
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $token = ApiToken::generateToken();
        $apiToken = ApiToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'name' => 'API Token',
            'expires_at' => now()->addDays(30),
        ]);

        return response()->json([
            'message' => 'Registration successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
            ],
            'token' => $token,
            'expires_at' => $apiToken->expires_at,
        ], 201);
    }
}

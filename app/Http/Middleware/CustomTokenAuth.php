<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Get the token from query parameters or request body
        $token = $request->query('api_token') ?? $request->input('api_token');
        info($request->all());
        if (!$token) {
            return response()->json(['message' => 'No token provided'], 401);
        }

        // Find the user by token
        $user = \App\Models\User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        // Authenticate the user
        Auth::login($user);

        return $next($request);
    }
}

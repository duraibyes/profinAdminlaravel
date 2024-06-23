<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allowed origins
        $allowedOrigins = [
            'http://localhost', // Add other origins as needed
        ];

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            ]);
        }

        // Handle actual request with allowed origin
        $response = $next($request);
        foreach ($allowedOrigins as $origin) {
            if ($request->headers->has('Origin') && strpos($request->headers->get('Origin'), $origin) !== false) {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
                $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
                $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                $response->headers->set('Access-Control-Allow-Credentials', 'true');
            }
        }

        return $response;
    }
}

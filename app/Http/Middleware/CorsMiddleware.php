<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedOrigins = [
            'http://localhost:3000', // Update to match your frontend
            'http://devfriend.in/admin'
            // Add other allowed origins as needed
        ];

        $origin = $request->headers->get('Origin');

        if (in_array($origin, $allowedOrigins)) {
            // Handle preflight OPTIONS request
            if ($request->isMethod('OPTIONS')) {
                return response()->json('OK', 200, [
                    'Access-Control-Allow-Origin' => $origin,
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                    'Access-Control-Allow-Credentials' => 'true',
                ]);
            }

            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            
            return $response;
        }

        return $next($request);
    }

}

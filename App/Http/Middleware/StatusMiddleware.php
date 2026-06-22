<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        if ($user->status === 'block') {

            $user->tokens()->delete();

            return response()->json([
                'message' => 'Your account has been blocked. Please contact support.'
            ], 403);
        }

        return $next($request);
    }
}

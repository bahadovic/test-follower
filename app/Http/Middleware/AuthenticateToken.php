<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class AuthenticateToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token || !User::where('token', $token)->exists()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}


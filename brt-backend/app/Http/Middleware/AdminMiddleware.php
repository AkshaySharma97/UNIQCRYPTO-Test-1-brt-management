<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized access. Admins only.'], 403);
        }

        return $next($request);
    }
}


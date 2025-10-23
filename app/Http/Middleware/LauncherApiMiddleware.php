<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LauncherApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('X-Launcher-Key');
        if ($key !== env('LAUNCHER_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

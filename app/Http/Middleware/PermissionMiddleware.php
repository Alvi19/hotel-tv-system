<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $module, $action = 'view')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->canAccess($module, $action)) {
            return $next($request);
        }

        abort(403, "Unauthorized - missing permission: {$action}_{$module}");
    }
    // public function handle($request, Closure $next, $permissionKey)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login');
    //     }

    //     $user = Auth::user();


    //     // Pisahkan permissionKey menjadi module + action
    //     [$module, $action] = explode('_', $permissionKey) + [null, 'view'];

    //     if ($user->canAccess($module, $action)) {
    //         return $next($request);
    //     }

    //     abort(403, 'Unauthorized - missing permission: ' . $module . ':' . $action);
    // }
}

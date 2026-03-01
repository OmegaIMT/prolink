<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission($permission)) {
            return response()->json([
                'message' => 'Não autorizado.'
            ], 403);
        }

        return $next($request);
    }
}
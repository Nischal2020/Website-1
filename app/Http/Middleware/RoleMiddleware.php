<?php

namespace App\Http\Middleware;

use App\Http\Responses\CustomJsonResponse;
use Closure;
use Illuminate\Http\JsonResponse;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleDesignation)
    {
        // Get user from token/session
        $user = $request->user();

        // Check user presence
        if(!$user || !$user->hasRole($roleDesignation)){
            return new CustomJsonResponse(false, "Permission denied", 403);
        }

        return $next($request);
    }
}

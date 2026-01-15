<?php

namespace App\Http\Middleware;

use Closure;

class AllowEmployeePermission
{
    /**
     * Handle an incoming request.
     * If the current user is an employee, allow through.
     * Otherwise delegate to Laratrust's permission middleware.
     */
    public function handle($request, Closure $next)
    {
        if (function_exists('user') && user() && user()->isEmployee()) {
            return $next($request);
        }

        // Delegate to Laratrust permission middleware for normal permission checks
        $laratrust = app(\Laratrust\Middleware\LaratrustPermission::class);

        // Extract parameters passed to this middleware (permissions)
        $args = array_slice(func_get_args(), 2);

        return $laratrust->handle($request, $next, ...$args);
    }
}

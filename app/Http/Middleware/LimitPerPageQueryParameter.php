<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class LimitPerPageQueryParameter
 *
 * Enforces the per_page query parameter to have the configured limit as upper bounds.
 *
 * @package App\Http\Middleware
 */
class LimitPerPageQueryParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $defaultPerPage = config('app.api.limit_per_page');
        $perPage = $request->get('per_page', $defaultPerPage);
        $request->merge(['per_page' => min($perPage, $defaultPerPage)]);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Traits\Plans;
use Closure;

class RedirectIfHitPlanLimits
{
    use Plans;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $segments = $request->segments();
        $last_segment = end($segments);

        if (! $request->isMethod(strtolower('GET')) || ! in_array($last_segment, ['create'])) {
            return $next($request);
        }

        if ($request->ajax()) {
            return $next($request);
        }

        if ($request->is(company_id() . '/apps/*')) {
            return $next($request);
        }

        return $next($request);
    }
}

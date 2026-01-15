<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfWizardNotCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the setup wizard is already completed, or the user is an employee,
        // just let the request through.
        //
        // Employees should not be forced into the company setup wizard when logging in;
        // they should land directly on their dashboard.
        if (setting('wizard.completed', 0) == 1 || (auth()->check() && user()->isEmployee())) {
            return $next($request);
        }

        // Check url
        if ($request->isWizard(company_id()) || $request->is(company_id() . '/settings/*')) {
            return $next($request);
        }

        // Redirect to wizard
        return redirect()->route('wizard.edit');
    }
}

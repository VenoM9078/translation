<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the contractor user
        // dd(Auth::guard('contractor')->user());
        $contractor = Auth::guard('contractor')->user();
        // If contractor is null, they are not logged in, redirect to login page
        if (is_null($contractor)) {
            return redirect()->route('contractor.login');
        }
        // If contractor is logged in but not verified, redirect to verification.notice
        elseif (!$contractor->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        return $next($request);
    }
}

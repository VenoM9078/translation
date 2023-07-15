<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerifyEmailController;
class RedirectBasedOnRole
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
        // If the user is logged in and has a role_id of 0
        if (Auth::check() && Auth::user()->role_id == 0) {
            // If the user has not verified their email yet
            if (!Auth::user()->hasVerifiedEmail()) {
                // Send the verification notification
                Auth::user()->sendEmailVerificationNotification();

                // Then redirect to the verification notice page
                return redirect()->route('verification.notice');
            }
        } else if (Auth::check() && Auth::user()->role_id != 0) {
            return app()->call('App\Http\Controllers\Auth\CustomVerifyEmailController@__invoke');
        }

        // If the user is not logged in or has a role_id other than 0, just proceed with the request
        return $next($request);
    }
}

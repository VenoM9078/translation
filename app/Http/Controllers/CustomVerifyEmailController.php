<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class CustomVerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->role_id == 0) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
            if ($request->user()->role_id != 0) {
                return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
            }
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        } else {

            if ($request->user()->hasVerifiedEmail()) {
                if ($request->user()->role_id != 0) {
                    return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
                }
            } else {
                if ($request->user()->markEmailAsVerified()) {

                    event(new Verified($request->user()));
                }
                if ($request->user()->role_id != 0) {
                    return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
                }
            }
            
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }
    }

    public function customVerification(Request $request){
        // dd($request->user());
        if ($request->user()->role_id == 0) {
            if ($request->user()->hasVerifiedEmail()) {
                return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
            } else {
                return view('auth.verify-email');
            }

        } else {
            // dd($request->user()->hasVerifiedEmail());
            if ($request->user()->hasVerifiedEmail()) {
                // if ($request->user()->role_id != 0) {
                    return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
                // }
            } else {
              
                return view('auth.verify-email');
            
                if ($request->user()->markEmailAsVerified()) {

                    event(new Verified($request->user()));
                }
                if ($request->user()->role_id != 0) {
                    return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
                }
            }

            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }
    }
}

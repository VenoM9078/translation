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
        // dd($request->user()->hasVerifiedEmail(), $request->user()->role_id, $request->user()->markEmailAsVerified());
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->role_id != 0) {
                // return view('auth.register2', [
                //     'name' => $request->input('name'),
                //     'role_id' => 0,
                //     'role_id_sent' => $request->role_id,
                //     'email' => $request->input('email'),
                //     'password' => $request->input('password'),
                // ]);
                return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
            }
        }
        if ($request->user()->role_id != 0) {
            return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
        }
        if ($request->user()->markEmailAsVerified()) {

            event(new Verified($request->user()));
        }
        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
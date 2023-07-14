<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        // if ($request->user()->role_id != 0) {
        //     return redirect()->route('register-step2', ['e' => $request->user()->email, 'r' => $request->user()->role_id]); // Modify this line to your desired redirection
        // }
        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }

    public function customVerifyEmail(Request $request){
        
        // dd($request->user)
        $user = User::where('id',$request->user()->id)->first();

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($user->hasVerifiedEmail()) {
            //return redirect()->route('verification.email-verified');
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            return redirect()->route('verification.email-verified');
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\CustomVerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register2', [RegisteredUserController::class, 'register2'])->name('register2');


    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password/{isContractor?}', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');


    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::post('contractor-forgot-password', [PasswordResetLinkController::class, 'contractorStore'])
    ->name('contractor.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::get('contractor-reset-password/{token}', [NewPasswordController::class, 'contractorCreate'])
    ->name('contractor.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

    Route::post('contractor-reset-password', [NewPasswordController::class, 'contractorStore'])
    ->name('contractor.password.update');
});

Route::middleware('auth:contractor')->group(function () {
    // dd("hee");
    Route::get('verify-email-contractor/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('contractor.verification.verify');

    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('contractor.verification.notice');

    // Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('contractor.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    //             ->name('logout');
});


Route::get('verify-email', [CustomVerifyEmailController::class, '__invoke'])
    ->middleware('redirectBasedOnRole')
    ->name('verification.notice');
Route::middleware('auth')->group(function () {

    Route::post('register2/submit', [RegisteredUserController::class, 'register2Complete'])->name('register2-complete');
    Route::get('/register-step2', [RegisteredUserController::class, 'showRegistrationForm'])->name('register-step2');

    Route::get('verify-email/{id}/{hash}', [CustomVerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    //             ->name('logout');
});
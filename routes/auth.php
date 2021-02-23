<?php
//
//use App\Http\Controllers\Auth\AuthenticatedSessionController;
//use App\Http\Controllers\Auth\ConfirmablePasswordController;
//use App\Http\Controllers\Auth\EmailVerificationNotificationController;
//use App\Http\Controllers\Auth\EmailVerificationPromptController;
//use App\Http\Controllers\Auth\NewPasswordController;
//use App\Http\Controllers\Auth\PasswordResetLinkController;
//use App\Http\Controllers\Auth\RegisteredUserController;
//use App\Http\Controllers\Auth\VerifyEmailController;
//use Illuminate\Support\Facades\Route;
//
//
//
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//                ->middleware('guest');
//Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.email');
//Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.update');
//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
//                ->name('logout')
//                ->middleware('auth');

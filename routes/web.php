<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\EmailVerifyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PasswordVerifyController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/hotels', [HotelController::class, 'index'])
    ->name('hotels.index');

Route::get('/hotels/{hotel}', [HotelController::class, 'show'])
    ->name('hotels.show');


Route::middleware('auth')->group(function () {

    Route::get('/bookings', [BookController::class, 'index'])
        ->middleware('verified')->name('bookings.index');

    Route::get('/bookings/{booking}', [BookController::class, 'show'])
        ->middleware('verified')->name('bookings.show');

    Route::delete('/bookings', [BookController::class, 'delete'])
        ->middleware(['verified', 'password.confirm'])->name('bookings.delete');

    Route::post('/bookings/store', [BookController::class, 'store'])
        ->middleware('verified')->name('bookings.store');

    Route::post('/logout', [RegisterController::class, 'destroy'])
        ->name('logout');

    Route::get('/verify-email', [EmailVerifyController::class, 'create'])
        ->name('verification.notice');

    Route::post('/verify-email', [EmailVerifyController::class, 'store'])
        ->name('verification.send');

    Route::get('/verify-email/{id}/{hash}', [EmailVerifyController::class, 'fullfill'])
        ->middleware('signed')->name('verification.verify');

    Route::get('/verify-password', [PasswordVerifyController::class, 'create'])
        ->name('password.confirm');

    Route::post('/verify-password', [PasswordVerifyController::class, 'store'])
        ->name('password.confirm.post');

    Route::get('/test', fn () => 'test page with pass auth')
        ->middleware(['verified', 'password.confirm']);
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password', [ResetPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'store'])
        ->name('password.update');

    Route::get('/login', [LoginController::class, 'create'])->name('login');

    Route::post('/login', [LoginController::class, 'store']);
});

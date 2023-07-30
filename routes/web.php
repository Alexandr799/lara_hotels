<?php

use App\Http\Controllers\EmailVerifyController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PasswordVerifyController;
use Illuminate\Http\Request;
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

Route::get('/hotels/{hotel}', function (Hotel $hotel) {
    $hotel->load('rooms');
    return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
})->name('hotels.show');


Route::middleware('auth')->group(function () {

    Route::get('/bookings', function () {
        return view('bookings.index', ['bookings' => []]);
    })->middleware('verified')->name('bookings.index');

    Route::post('/bookings/store', function () {
        return 'Тестовое бронирование';
    })->middleware('verified')->name('bookings.store');

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

Route::get('/test-route', function(Request $request) {
    dd($request->all());
})->name('test');

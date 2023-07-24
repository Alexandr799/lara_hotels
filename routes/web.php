<?php

use App\Models\Hotel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

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

Route::get('/hotels', function () {
    return view('hotels.index', ['hotels' => Hotel::all()]);
})->name('hotels.index');

Route::get('/hotels/{hotel}', function (Hotel $hotel) {
    $hotel->load('rooms');
    return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
})->name('hotels.show');


Route::middleware('auth')->group(function () {

    Route::get('/bookings', function () {
        return view('bookings.index', ['bookings' => []]);
    })->name('bookings.index');

    Route::post('/bookings/store', function () {
        return 'Тестовое бронирование';
    })->name('bookings.store');

    Route::post('/logout', [RegisterController::class, 'destroy'])->name('logout');
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

<?php

use App\Http\Controllers\RegisterController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;

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
    return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
})->name('hotels.show');


Route::middleware('auth')->group(function () {
    Route::get('/bookings', function () {
        return view('bookings.index', ['bookings'=>[]]);
    })->name('bookings.index');

    Route::post('/bookings/store', function (Hotel $hotel) {
        $hotel->load('rooms');
        return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
    })->middleware('auth')->name('bookings.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        return view('auth.login');
    })->name('login');
});


Route::post('/logout', function () {
    return view('index');
})->name('logout');

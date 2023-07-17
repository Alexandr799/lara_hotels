<?php

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

Route::get('/bookings', function () {
    return view('bookings.index');
})->name('bookings.index');

Route::get('/hotels/{hotel}', function (Hotel $hotel) {
    return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
})->name('hotels.show');

Route::post('/bookings/store', function (Hotel $hotel) {
    $hotel->load('rooms');
    return view('hotels.show', ['hotel' => $hotel, 'rooms' => $hotel->rooms()->get()]);
})->name('bookings.store');

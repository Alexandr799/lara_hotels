<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\Email\EmailSenderScreen;
use App\Orchid\Screens\Booking\BookingEditScreen;
use App\Orchid\Screens\Booking\BookingListScreen;
use App\Orchid\Screens\Facility\FacilityEditScreen;
use App\Orchid\Screens\Facility\FacilityListScreen;
use App\Orchid\Screens\Hotel\HotelEditScreen;
use App\Orchid\Screens\Hotel\HotelListScreen;
use App\Orchid\Screens\Room\RoomEditScreen;
use App\Orchid\Screens\Room\RoomListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/form/examples/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/form/examples/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/form/examples/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/form/examples/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/layout/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/charts/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/cards/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');


Route::screen('email', EmailSenderScreen::class)->name('platform.email')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Email Sender');
    });

Route::screen('hotels', HotelListScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Hotels');
    })->name('platform.hotel.list');

Route::screen('hotel/{hotel?}', HotelEditScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Hotels', route('platform.hotel.list'))
            ->push('Hotels edit');
    })->name('platform.hotel.edit');


Route::screen('bookings', BookingListScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Bookings');
    })->name('platform.booking.list');

Route::screen('booking/{booking?}', BookingEditScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Bookings', route('platform.booking.list'))
            ->push('Booking edit');
    })->name('platform.booking.edit');


Route::screen('rooms', RoomListScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Rooms');
    })->name('platform.room.list');

Route::screen('room/{room?}', RoomEditScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Rooms', route('platform.room.list'))
            ->push('Room edit');
    })->name('platform.room.edit');


Route::screen('facilities', FacilityListScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Facilities');
    })->name('platform.facility.list');

Route::screen('facility/{facility?}', FacilityEditScreen::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Facilities', route('platform.room.list'))
            ->push('Facility edit');
    })->name('platform.facility.edit');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

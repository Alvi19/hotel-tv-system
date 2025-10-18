<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminHotelController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\Dashboard\RoomController;
use App\Http\Controllers\Dashboard\ShortcutController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // GROUP 1 — Manage Users (IT Admin)
    Route::middleware(['auth', 'role:it_admin'])
        ->prefix('dashboard/users')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('dashboard.users.create');
            Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('dashboard.users.edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('dashboard.users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
        });

    // GROUP 2 — Manage Hotels (IT Admin)
    Route::middleware(['auth', 'role:it_admin'])
        ->prefix('dashboard/hotels')
        ->group(function () {
            Route::get('/', [AdminHotelController::class, 'index'])->name('dashboard.hotels.index');
            Route::get('/create', [AdminHotelController::class, 'create'])->name('dashboard.hotels.create');
            Route::post('/', [AdminHotelController::class, 'store'])->name('dashboard.hotels.store');
            Route::get('/{id}/edit', [AdminHotelController::class, 'edit'])->name('dashboard.hotels.edit');
            Route::put('/{id}', [AdminHotelController::class, 'update'])->name('dashboard.hotels.update');
            Route::delete('/{id}', [AdminHotelController::class, 'destroy'])->name('dashboard.hotels.destroy');
        });

    // 🏨 HOTEL STAFF AREA
    Route::middleware(['auth', 'role:hotel_staff'])
        ->prefix('dashboard')
        ->as('dashboard.') // <— ini yang penting! bukan name(), tapi as()
        ->group(function () {

            // Hotel Info
            Route::get('/hotel/edit', [HotelController::class, 'edit'])->name('hotel.edit');
            Route::put('/hotel/update', [HotelController::class, 'update'])->name('hotel.update');

            // 🚪 Rooms CRUD
            Route::resource('rooms', RoomController::class)
                ->except(['show'])
                ->names('rooms');

            // ✅ Checkin / Checkout
            Route::post('rooms/{id}/checkin', [RoomController::class, 'checkin'])->name('rooms.checkin');
            Route::post('rooms/{id}/checkout', [RoomController::class, 'checkout'])->name('rooms.checkout');

            // 📺 Banners CRUD
            // Route::resource('banners', BannerController::class)->except(['show'])->names('banners');
            Route::resource('banners', BannerController::class)->except(['show']);

            // 🧭 Shortcuts CRUD
            Route::resource('shortcuts', ShortcutController::class)->except(['show'])->names('shortcuts');

            // ℹ️ Contents CRUD
            Route::resource('contents', ContentController::class)->except(['show'])->names('contents');
        });
});

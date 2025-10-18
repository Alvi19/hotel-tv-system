<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\Dashboard\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/hotel/edit', [HotelController::class, 'edit'])->name('dashboard.hotel.edit');
    Route::put('/dashboard/hotel/update', [HotelController::class, 'update'])->name('dashboard.hotel.update');

    Route::get('/dashboard/rooms', [RoomController::class, 'index'])->name('dashboard.rooms.index');
    Route::post('/dashboard/rooms/{id}/checkin', [RoomController::class, 'checkin'])->name('dashboard.rooms.checkin');
    Route::post('/dashboard/rooms/{id}/checkout', [RoomController::class, 'checkout'])->name('dashboard.rooms.checkout');
});

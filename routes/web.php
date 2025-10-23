<?php

use App\Http\Controllers\API\LauncherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminHotelController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DeviceController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\RoomCategoryController;
use App\Http\Controllers\Dashboard\RoomController;
use App\Http\Controllers\Dashboard\ShortcutController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🚀 Launcher
// Route::prefix('api')->group(function () {
//     Route::get('/launcher/content', [LauncherController::class, 'getContent']);
//     Route::get('/launcher/all', [LauncherController::class, 'getAllLauncherData']);
// });
Route::middleware('launcher.api')->prefix('api')->group(function () {
    Route::get('/launcher/all', [LauncherController::class, 'getAllLauncherData']);
    Route::get('/launcher/config', [LauncherController::class, 'getDeviceConfig']);
    Route::get('/launcher/{stbId}', [LauncherController::class, 'getLauncherData']);
});

Route::middleware(['auth'])
    ->prefix('dashboard')
    ->as('dashboard.')
    ->group(function () {

        // 🏠 Dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->middleware('permission:dashboard,view')
            ->name('index');

        // 👥 Users
        Route::resource('users', UserController::class)
            ->middleware('permission:users,view')
            ->except(['show'])
            ->names('users');

        // 🏨 Hotels
        Route::resource('hotels', AdminHotelController::class)
            ->middleware('permission:hotels,view')
            ->except(['show'])
            ->names('hotels');
        Route::get('hotels/{hotel}', [AdminHotelController::class, 'show'])
            ->middleware('permission:hotels,view')
            ->name('hotels.show');

        // 🧩 Roles
        Route::resource('roles', RoleController::class)
            ->middleware('permission:roles,view')
            ->except(['show'])
            ->names('roles');

        // 📺 Banners
        Route::resource('banners', BannerController::class)
            ->middleware('permission:banners,view')
            ->except(['show'])
            ->names('banners');

        // 🚪 Rooms
        Route::resource('rooms', RoomController::class)
            ->middleware('permission:rooms,view')
            ->except(['show'])
            ->names('rooms');

        Route::post('rooms/{room}/checkin', [RoomController::class, 'checkin'])
            ->middleware('permission:rooms,checkin')
            ->name('rooms.checkin');

        // ➖ Checkout
        Route::post('rooms/{room}/checkout', [RoomController::class, 'checkout'])
            ->middleware('permission:rooms,checkout')
            ->name('rooms.checkout');

        // 🏷️ Room Categories
        Route::resource('room-categories', RoomCategoryController::class)
            ->middleware('permission:rooms,view')
            ->except(['show'])
            ->names('room-categories');

        // 💻 Devices
        Route::resource('devices', DeviceController::class)
            ->middleware('permission:devices,view')
            ->except(['show'])
            ->names('devices');

        // ℹ️ Contents
        Route::resource('contents', ContentController::class)
            ->middleware('permission:contents,view')
            ->except(['show'])
            ->names('contents');

        // 🧭 Shortcuts
        Route::resource('shortcuts', ShortcutController::class)
            ->middleware('permission:shortcuts,view')
            ->except(['show'])
            ->names('shortcuts');
    });

// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// // 🚀 DASHBOARD AREA — Hanya untuk Super Admin (IT Admin)
// Route::middleware(['auth'])
//     ->prefix('dashboard')
//     ->as('dashboard.')
//     ->group(function () {

//         // Dashboard bisa diakses jika punya izin view_dashboard
//         Route::get('/', [DashboardController::class, 'index'])
//             ->middleware('permission:view_dashboard')
//             ->name('index');

//         // 👥 Manage Users
//         Route::prefix('users')->group(function () {
//             Route::get('/', [UserController::class, 'index'])->name('users.index');
//             Route::get('/create', [UserController::class, 'create'])->name('users.create');
//             Route::post('/', [UserController::class, 'store'])->name('users.store');
//             Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//             Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
//             Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
//         });

//         // 🏨 Manage Hotels
//         Route::prefix('hotels')->group(function () {
//             Route::get('/', [AdminHotelController::class, 'index'])->name('hotels.index');
//             Route::get('/create', [AdminHotelController::class, 'create'])->name('hotels.create');
//             Route::post('/', [AdminHotelController::class, 'store'])->name('hotels.store');
//             Route::get('/{id}/edit', [AdminHotelController::class, 'edit'])->name('hotels.edit');
//             Route::put('/{id}', [AdminHotelController::class, 'update'])->name('hotels.update');
//             Route::delete('/{id}', [AdminHotelController::class, 'destroy'])->name('hotels.destroy');
//         });

//         // ⚙️ Manage Roles & Permissions
//         Route::resource('roles', RoleController::class)->except(['show'])->names('roles');

//         // 📺 Manage Banners
//         Route::resource('banners', BannerController::class)->except(['show'])->names('banners');

//         // 🧭 Manage Shortcuts
//         Route::resource('shortcuts', ShortcutController::class)->except(['show'])->names('shortcuts');

//         // ℹ️ Manage Contents
//         Route::resource('contents', ContentController::class)->except(['show'])->names('contents');

//         // 🚪 Manage Rooms
//         Route::resource('rooms', RoomController::class)->except(['show'])->names('rooms');
//         Route::resource('room-categories', RoomCategoryController::class)->names('room-categories');
//         Route::post('rooms/{id}/checkin', [RoomController::class, 'checkin'])->name('rooms.checkin');
//         Route::post('rooms/{id}/checkout', [RoomController::class, 'checkout'])->name('rooms.checkout');

//         // 💻 Manage Devices
//         Route::prefix('devices')->group(function () {
//             Route::get('/', [DeviceController::class, 'adminIndex'])->name('devices.index');
//             Route::get('/create', [DeviceController::class, 'create'])->name('devices.create');
//             Route::post('/', [DeviceController::class, 'store'])->name('devices.store');
//             Route::get('/{id}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
//             Route::put('/{id}', [DeviceController::class, 'update'])->name('devices.update');
//             Route::delete('/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
//         });

//         // 🏢 Manage Hotel Info (Optional)
//         // Route::get('/hotel/edit', [HotelController::class, 'edit'])->name('hotel.edit');
//         // Route::put('/hotel/update', [HotelController::class, 'update'])->name('hotel.update');
//     });


// // ====================== AUTH AREA ======================
// Route::middleware(['auth', 'role:it_admin'])->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     // ======================================================
//     // 🔧 ROLE & PERMISSION MANAGEMENT
//     // ======================================================

//     // Role management (it_admin + hotel_admin for create/edit; delete only it_admin)
//     Route::middleware(['auth', 'role:it_admin,hotel_admin'])
//         ->prefix('dashboard/roles')
//         ->as('dashboard.roles.')
//         ->group(function () {
//             Route::get('/', [RoleController::class, 'index'])->name('index');
//             Route::get('/create', [RoleController::class, 'create'])->name('create');
//             Route::post('/', [RoleController::class, 'store'])->name('store');
//             Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
//             Route::put('/{role}', [RoleController::class, 'update'])->name('update');
//             Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
//         });

//     // Permissions (it_admin only)
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/permissions')
//         ->as('dashboard.permissions.')
//         ->group(function () {
//             Route::get('/', [PermissionController::class, 'index'])->name('index');
//             Route::get('/create', [PermissionController::class, 'create'])->name('create');
//             Route::post('/', [PermissionController::class, 'store'])->name('store');
//             Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
//             Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
//             Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
//         });

//     // ======================================================
//     // 👨‍💻 GROUP 1 — Manage Users (IT Admin)
//     // ======================================================
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/users')
//         ->group(function () {
//             Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
//             Route::get('/create', [UserController::class, 'create'])->name('dashboard.users.create');
//             Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
//             Route::get('/{id}/edit', [UserController::class, 'edit'])->name('dashboard.users.edit');
//             Route::put('/{id}', [UserController::class, 'update'])->name('dashboard.users.update');
//             Route::delete('/{id}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
//         });

//     // ======================================================
//     // 🏨 GROUP 2 — Manage Hotels (IT Admin)
//     // ======================================================
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/hotels')
//         ->group(function () {
//             Route::get('/', [AdminHotelController::class, 'index'])->name('dashboard.hotels.index');
//             Route::get('/create', [AdminHotelController::class, 'create'])->name('dashboard.hotels.create');
//             Route::post('/', [AdminHotelController::class, 'store'])->name('dashboard.hotels.store');
//             Route::get('/{id}/edit', [AdminHotelController::class, 'edit'])->name('dashboard.hotels.edit');
//             Route::put('/{id}', [AdminHotelController::class, 'update'])->name('dashboard.hotels.update');
//             Route::delete('/{id}', [AdminHotelController::class, 'destroy'])->name('dashboard.hotels.destroy');
//         });

//     // ======================================================
//     // 🖥️ IT ADMIN DEVICES MANAGEMENT
//     // ======================================================
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/admin')
//         ->group(function () {
//             Route::get('/devices', [DeviceController::class, 'adminIndex'])->name('dashboard.admin.devices.index');
//         });

//     // ======================================================
//     // 🧾 HOTEL STAFF AREA
//     // ======================================================
//     Route::middleware(['auth', 'role:hotel_staff'])
//         ->prefix('dashboard')
//         ->as('dashboard.')
//         ->group(function () {

//             // Hotel Info
//             Route::get('/hotel/edit', [HotelController::class, 'edit'])->name('hotel.edit');
//             Route::put('/hotel/update', [HotelController::class, 'update'])->name('hotel.update');

//             // 🚪 Rooms CRUD
//             Route::resource('rooms', RoomController::class)
//                 ->except(['show'])
//                 ->names('rooms');

//             // ✅ Checkin / Checkout
//             Route::post('rooms/{id}/checkin', [RoomController::class, 'checkin'])->name('rooms.checkin');
//             Route::post('rooms/{id}/checkout', [RoomController::class, 'checkout'])->name('rooms.checkout');

//             // 📺 Banners CRUD
//             Route::resource('banners', BannerController::class)->except(['show']);

//             // 🧭 Shortcuts CRUD
//             Route::resource('shortcuts', ShortcutController::class)->except(['show'])->names('shortcuts');

//             // ℹ️ Contents CRUD
//             Route::resource('contents', ContentController::class)->except(['show'])->names('contents');

//             // 🖥️ Devices CRUD
//             Route::resource('devices', DeviceController::class)->except(['show'])->names('devices');
//         });
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     // GROUP 1 — Manage Users (IT Admin)
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/users')
//         ->group(function () {
//             Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
//             Route::get('/create', [UserController::class, 'create'])->name('dashboard.users.create');
//             Route::post('/', [UserController::class, 'store'])->name('dashboard.users.store');
//             Route::get('/{id}/edit', [UserController::class, 'edit'])->name('dashboard.users.edit');
//             Route::put('/{id}', [UserController::class, 'update'])->name('dashboard.users.update');
//             Route::delete('/{id}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
//         });

//     // GROUP 2 — Manage Hotels (IT Admin)
//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/hotels')
//         ->group(function () {
//             Route::get('/', [AdminHotelController::class, 'index'])->name('dashboard.hotels.index');
//             Route::get('/create', [AdminHotelController::class, 'create'])->name('dashboard.hotels.create');
//             Route::post('/', [AdminHotelController::class, 'store'])->name('dashboard.hotels.store');
//             Route::get('/{id}/edit', [AdminHotelController::class, 'edit'])->name('dashboard.hotels.edit');
//             Route::put('/{id}', [AdminHotelController::class, 'update'])->name('dashboard.hotels.update');
//             Route::delete('/{id}', [AdminHotelController::class, 'destroy'])->name('dashboard.hotels.destroy');
//         });

//     Route::middleware(['auth', 'role:it_admin'])
//         ->prefix('dashboard/admin')
//         ->group(function () {
//             Route::get('/devices', [DeviceController::class, 'adminIndex'])->name('dashboard.admin.devices.index');
//         });


//     // 🏨 HOTEL STAFF AREA
//     Route::middleware(['auth', 'role:hotel_staff'])
//         ->prefix('dashboard')
//         ->as('dashboard.')
//         ->group(function () {

//             // Hotel Info
//             Route::get('/hotel/edit', [HotelController::class, 'edit'])->name('hotel.edit');
//             Route::put('/hotel/update', [HotelController::class, 'update'])->name('hotel.update');

//             // 🚪 Rooms CRUD
//             Route::resource('rooms', RoomController::class)
//                 ->except(['show'])
//                 ->names('rooms');

//             // ✅ Checkin / Checkout
//             Route::post('rooms/{id}/checkin', [RoomController::class, 'checkin'])->name('rooms.checkin');
//             Route::post('rooms/{id}/checkout', [RoomController::class, 'checkout'])->name('rooms.checkout');

//             // 📺 Banners CRUD
//             Route::resource('banners', BannerController::class)->except(['show']);

//             // 🧭 Shortcuts CRUD
//             Route::resource('shortcuts', ShortcutController::class)->except(['show'])->names('shortcuts');

//             // ℹ️ Contents CRUD
//             Route::resource('contents', ContentController::class)->except(['show'])->names('contents');

//             Route::resource('devices', DeviceController::class)->except(['show'])->names('devices');
//         });
// });

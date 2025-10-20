<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ShortcutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    // Hotel Info
    Route::get('/hotel/{hotel_id}', [HotelController::class, 'show']);

    // Rooms
    Route::get('/hotel/{hotel_id}/rooms', [RoomController::class, 'index']);

    // Banners
    Route::get('/hotel/{hotel_id}/banners', [BannerController::class, 'index']);

    // Shortcuts
    Route::get('/hotel/{hotel_id}/shortcuts', [ShortcutController::class, 'index']);

    // Contents
    Route::get('/hotel/{hotel_id}/contents', [ContentController::class, 'index']);

    // Device (register/update status)
    Route::post('/device/register', [DeviceController::class, 'register']);
    Route::post('/device/update-status', [DeviceController::class, 'updateStatus']);
});

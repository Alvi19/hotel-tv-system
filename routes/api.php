<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\LauncherController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ShortcutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('launcher.api')->prefix('api')->group(function () {
    Route::get('/launcher/all', [LauncherController::class, 'getAllLauncherData']);
    Route::get('/launcher/config', [LauncherController::class, 'getDeviceConfig']);

    // 🆕 Tambahkan ini
    Route::get('/launcher/{stbId}', [LauncherController::class, 'getLauncherData']);
});

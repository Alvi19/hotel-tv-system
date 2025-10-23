<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Content;
use App\Models\Device;
use Illuminate\Http\Request;

class LauncherController extends Controller
{
    // public function getAllLauncherData(Request $request)
    // {
    //     $deviceId = $request->query('device_id');
    //     if (!$deviceId) {
    //         return response()->json(['error' => 'device_id is required'], 400);
    //     }

    //     // 🧠 ubah dari room.roomType → room.category
    //     $device = Device::with(['room.category', 'hotel'])
    //         ->where('device_id', $deviceId)
    //         ->first();

    //     if (!$device) {
    //         return response()->json(['error' => 'Device not registered'], 404);
    //     }

    //     $hotelId = $device->hotel_id;
    //     $roomTypeId = $device->room->category_id ?? null;

    //     // Ambil semua content aktif hotel + kategori kamar
    //     $contents = Content::where('hotel_id', $hotelId)
    //         ->where('is_active', true)
    //         ->when($roomTypeId, function ($q) use ($roomTypeId) {
    //             $q->whereNull('room_type_id')->orWhere('room_type_id', $roomTypeId);
    //         })
    //         ->get()
    //         ->groupBy('type');

    //     // Format URL gambar
    //     foreach ($contents as $type => $items) {
    //         foreach ($items as $item) {
    //             $item->image_url = $item->image_url ? asset('storage/' . $item->image_url) : null;
    //         }
    //     }

    //     return response()->json([
    //         'hotel' => [
    //             'id' => $hotelId,
    //             'name' => $device->hotel->name,
    //         ],
    //         'room' => [
    //             'id' => $device->room->id ?? null,
    //             'number' => $device->room->room_number ?? null,
    //             'type' => $device->room->category->name ?? null,
    //         ],
    //         'contents' => $contents,
    //     ]);
    // }

    public function getAllLauncherData(Request $request)
    {
        $deviceId = $request->query('device_id');

        if (!$deviceId) {
            return response()->json(['error' => 'device_id is required'], 400);
        }

        $device = \App\Models\Device::with(['room.category', 'hotel'])
            ->where('device_id', $deviceId)
            ->first();

        if (!$device) {
            return response()->json(['error' => 'Device not registered'], 404);
        }

        $hotel = $device->hotel;
        $room = $device->room;

        // --- Banner ---
        $banners = \App\Models\Banner::where('hotel_id', $hotel->id)
            ->where('is_active', true)
            ->get(['id', 'title', 'image_url'])
            ->map(fn($b) => [
                'id' => $b->id,
                'title' => $b->title,
                'image' => $b->image_url ? asset('storage/' . $b->image_url) : null,
            ]);

        // --- Content ---
        $contents = \App\Models\Content::where('hotel_id', $hotel->id)
            ->where('is_active', true)
            ->where(function ($q) use ($room) {
                $q->whereNull('room_type_id')
                    ->orWhere('room_type_id', $room->category->id ?? null);
            })
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                return $group->map(fn($c) => [
                    'title' => $c->title,
                    'body' => $c->body,
                    'image' => $c->image_url ? asset('storage/' . $c->image_url) : null,
                ]);
            });

        // --- Shortcut / Menu ---
        $shortcuts = [
            ['name' => 'About', 'type' => 'about', 'icon' => 'info-circle'],
            ['name' => 'Facilities', 'type' => 'facility', 'icon' => 'building'],
            ['name' => 'Services', 'type' => 'services', 'icon' => 'tools'],
            ['name' => 'Promotions', 'type' => 'promotion', 'icon' => 'gift'],
            ['name' => 'Events', 'type' => 'event', 'icon' => 'calendar-event'],
            ['name' => 'Policy', 'type' => 'policy', 'icon' => 'file-text'],
            ['name' => 'Contact', 'type' => 'contact', 'icon' => 'telephone'],
        ];

        // --- Final response (structured for STB UI) ---
        return response()->json([
            'hotel' => [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'address' => $hotel->address ?? '-',
                'phone' => $hotel->phone ?? '-',
                'logo' => $hotel->logo ? asset('storage/' . $hotel->logo) : null,
            ],
            'room' => [
                'number' => $room->room_number ?? '-',
                'type' => $room->category->name ?? '-',
                'guest_name' => $room->guest_name ?? '-',
            ],
            'banners' => $banners,
            'menus' => $shortcuts,
            'contents' => $contents,
        ]);
    }

    public function getContent(Request $request)
    {
        $deviceId = $request->query('device_id');

        if (!$deviceId) {
            return response()->json(['error' => 'device_id is required'], 400);
        }

        // 🧠 ubah juga dari room.roomType → room.category
        $device = Device::with(['room.category', 'hotel'])
            ->where('device_id', $deviceId)
            ->first();

        if (!$device) {
            return response()->json(['error' => 'Device not registered'], 404);
        }

        $hotel = $device->hotel;
        $room = $device->room;

        // Banner aktif
        $banners = Banner::where('hotel_id', $hotel->id)
            ->where('is_active', true)
            ->get(['id', 'title', 'image_url', 'active_from', 'active_to'])
            ->map(fn($b) => [
                'id' => $b->id,
                'title' => $b->title,
                'image_url' => $b->image_url ? asset('storage/' . $b->image_url) : null,
                'active_from' => $b->active_from,
                'active_to' => $b->active_to,
            ]);

        // Konten aktif sesuai kategori kamar
        $contents = Content::where('hotel_id', $hotel->id)
            ->where('is_active', true)
            ->where(function ($q) use ($room) {
                $q->whereNull('room_type_id')
                    ->orWhere('room_type_id', $room->category_id ?? null);
            })
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                return $group->map(fn($c) => [
                    'title' => $c->title,
                    'body' => $c->body,
                    'image_url' => $c->image_url ? asset('storage/' . $c->image_url) : null,
                ]);
            });

        return response()->json([
            'hotel' => [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'address' => $hotel->address ?? null,
                'phone' => $hotel->phone ?? null,
                'logo_url' => $hotel->logo ? asset('storage/' . $hotel->logo) : null,
            ],
            'room' => [
                'id' => $room->id ?? null,
                'number' => $room->room_number ?? '-',
                'type' => $room->category->name ?? '-',
                'status' => $room->status ?? 'vacant',
            ],
            'banners' => $banners,
            'contents' => $contents,
        ]);
    }
    // GET /api/launcher/config?device_id=STB-A-102
    public function getDeviceConfig(Request $request)
    {
        $deviceId = $request->query('device_id');
        if (!$deviceId) {
            return response()->json(['error' => 'device_id is required'], 400);
        }

        $device = Device::with(['room.category', 'hotel'])->where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json(['error' => 'Device not registered'], 404);
        }

        return response()->json([
            'device_id' => $device->device_id,
            'hotel_id' => $device->hotel_id,
            'hotel_name' => $device->hotel->name,
            'room_id' => $device->room->id,
            'room_number' => $device->room->room_number,
            'room_category' => $device->room->category->name ?? null,
        ]);
    }

    public function getLauncherData($stbId)
    {
        // Contoh: ambil data STB dari database
        $room = [
            'guest_name' => 'John Doe',
            'room_number' => '101',
            'room_type' => 'Deluxe',
        ];

        $menus = [
            ['name' => 'Restaurant'],
            ['name' => 'Spa'],
            ['name' => 'Wifi'],
        ];

        return response()->json([
            'stb_id' => $stbId,
            'room' => $room,
            'menus' => $menus,
            'hotel_description' => 'Welcome to our hotel! Enjoy your stay 😊',
        ]);
    }
}

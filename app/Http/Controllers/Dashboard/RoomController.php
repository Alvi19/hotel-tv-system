<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomCategory;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    /**
     * ✅ Tampilkan semua room (Super Admin melihat semua hotel, Staff hanya hotel sendiri)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil semua kategori untuk dropdown filter
        $categories = \App\Models\RoomCategory::orderBy('name')->get();

        // Ambil parameter filter (category_id)
        $categoryFilter = $request->input('category_id');

        // Query dasar
        $rooms = $user->isSuperAdmin()
            ? Room::with(['hotel', 'category'])
            : Room::with('category')->where('hotel_id', $user->hotel_id);

        // Tambahkan filter kategori jika dipilih
        if ($categoryFilter) {
            $rooms->where('category_id', $categoryFilter);
        }

        $rooms = $rooms->orderBy('hotel_id')->orderBy('room_number')->get();

        return view('dashboard.rooms.index', compact('rooms', 'categories', 'categoryFilter'));
    }

    /**
     * ✅ Form tambah room
     */
    public function create()
    {
        $user = Auth::user();
        $hotels = $user->isSuperAdmin() ? Hotel::all() : null;
        $categories = RoomCategory::all();

        return view('dashboard.rooms.create', compact('hotels', 'categories'));
    }

    /**
     * ✅ Simpan room baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'room_number' => 'required|string|max:20',
            'status' => 'in:available,occupied,maintenance',
            'category_id' => 'nullable|exists:room_categories,id',
        ];

        // Super Admin wajib pilih hotel
        if ($user->isSuperAdmin()) {
            $rules['hotel_id'] = 'required|exists:hotels,id';
        }

        $validated = $request->validate($rules);

        $room = Room::create([
            'hotel_id' => $user->isSuperAdmin() ? $validated['hotel_id'] : $user->hotel_id,
            'room_number' => $validated['room_number'],
            'status' => $validated['status'] ?? 'available',
            'category_id' => $validated['category_id'] ?? null,
        ]);


        Log::info("✅ Room created", ['room' => $room->id]);

        return redirect()->route('dashboard.rooms.index')->with('success', 'Room added successfully.');
    }

    /**
     * ✅ Form edit room
     */
    public function edit($id)
    {
        $user = Auth::user();

        $room = $user->isSuperAdmin()
            ? Room::findOrFail($id)
            : Room::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $hotels = $user->isSuperAdmin() ? Hotel::all() : null;
        $categories = RoomCategory::all();

        return view('dashboard.rooms.edit', compact('room', 'hotels', 'categories'));
    }


    /**
     * ✅ Update room
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $room = $user->isSuperAdmin()
            ? Room::findOrFail($id)
            : Room::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $request->validate([
            'room_number' => 'required|string|max:20',
            'status' => 'in:available,occupied,maintenance',
            'category_id' => 'nullable|exists:room_categories,id',
        ]);

        $room->update($request->only(['room_number', 'status', 'category_id']));

        Log::info("💾 Room updated", ['room_id' => $room->id]);
        return redirect()->route('dashboard.rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * ✅ Hapus room
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $room = $user->isSuperAdmin()
            ? Room::findOrFail($id)
            : Room::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $room->delete();
        Log::info("🗑️ Room deleted", ['room_id' => $id]);

        return redirect()->route('dashboard.rooms.index')->with('success', 'Room deleted successfully.');
    }

    /**
     * ✅ Checkin guest
     */
    public function checkin(Request $request, $id)
    {
        $user = Auth::user();

        $room = $user->isSuperAdmin()
            ? Room::findOrFail($id)
            : Room::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $request->validate(['guest_name' => 'required|string|max:100']);

        $room->update([
            'guest_name' => $request->guest_name,
            'checkin' => now(),
            'status' => 'occupied',
        ]);

        try {
            $mqtt = new MqttService();
            $mqtt->publish("hotel/{$room->hotel_id}/room/{$room->id}", [
                'event' => 'checkin',
                'room_number' => $room->room_number,
                'category' => $room->category->name,
                'guest_name' => $room->guest_name,
                'status' => $room->status,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            Log::error("❌ MQTT checkin failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', "Guest '{$request->guest_name}' checked in successfully.");
    }

    /**
     * ✅ Checkout guest
     */
    public function checkout($id)
    {
        $user = Auth::user();

        $room = $user->isSuperAdmin()
            ? Room::findOrFail($id)
            : Room::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $prevGuest = $room->guest_name;

        $room->update([
            'guest_name' => null,
            'checkout' => now(),
            'status' => 'available',
        ]);

        try {
            $mqtt = new MqttService();
            $mqtt->publish("hotel/{$room->hotel_id}/room/{$room->id}", [
                'event' => 'checkout',
                'room_number' => $room->room_number,
                'category' => $room->category->name,
                'guest_name' => $prevGuest,
                'status' => $room->status,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            Log::error("❌ MQTT checkout failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Guest checked out successfully.');
    }
}

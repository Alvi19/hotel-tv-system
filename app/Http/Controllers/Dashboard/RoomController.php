<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;
        $rooms = Room::where('hotel_id', $hotelId)->orderBy('room_number')->get();

        return view('dashboard.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('dashboard.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:20',
            'status' => 'in:available,occupied,maintenance',
        ]);

        Room::create([
            'hotel_id' => Auth::user()->hotel_id,
            'room_number' => $request->room_number,
            'status' => $request->status ?? 'available',
        ]);

        return redirect()->route('dashboard.rooms.index')->with('success', 'Room added successfully.');
    }

    public function edit($id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        return view('dashboard.rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'room_number' => 'required|string|max:20',
            'status' => 'in:available,occupied,maintenance',
        ]);

        $room->update($request->only(['room_number', 'status']));

        return redirect()->route('dashboard.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        $room->delete();

        return redirect()->route('dashboard.rooms.index')->with('success', 'Room deleted.');
    }

    public function checkin(Request $request, $id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'guest_name' => 'required|string|max:100',
        ]);

        $room->update([
            'guest_name' => $request->guest_name,
            'checkin' => now(),
            'status' => 'occupied',
        ]);

        // Publish ke HiveMQ
        try {
            $mqtt = new MqttService();
            $mqtt->publish("hotel/{$room->hotel_id}/room/{$room->id}", [
                'event' => 'checkin',
                'room_id' => $room->id,
                'room_number' => $room->room_number,
                'guest_name' => $room->guest_name,
                'status' => $room->status,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            Log::error("❌ MQTT checkin publish failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', "Guest '{$request->guest_name}' checked in successfully.");
    }

    public function checkout($id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        // Simpan data sebelum dihapus, supaya bisa dikirim ke MQTT
        $previousGuest = $room->guest_name;
        $roomNumber = $room->room_number;

        // Update status kamar
        $room->update([
            'guest_name' => null,
            'checkout' => now(),
            'status' => 'available',
        ]);

        // Kirim event ke HiveMQ
        try {
            $mqtt = new MqttService();
            $mqtt->publish("hotel/{$room->hotel_id}/room/{$room->id}", [
                'event' => 'checkout',
                'room_id' => $room->id,
                'room_number' => $roomNumber,
                'guest_name' => $previousGuest,
                'status' => $room->status,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            Log::error("❌ MQTT checkout publish failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Guest checked out successfully.');
    }
}

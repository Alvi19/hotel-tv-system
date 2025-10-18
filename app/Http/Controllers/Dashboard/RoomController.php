<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    // public function index()
    // {
    //     $rooms = Room::where('hotel_id', Auth::user()->hotel_id)->get();
    //     return view('dashboard.rooms.index', compact('rooms'));
    // }

    // public function checkin(Request $request, $id)
    // {
    //     $request->validate(['guest_name' => 'required|string']);
    //     $room = Room::findOrFail($id);
    //     $room->update([
    //         'guest_name' => $request->guest_name,
    //         'checkin' => now(),
    //         'status' => 'occupied',
    //     ]);
    //     // RoomUpdated::publish($room); // kirim MQTT event
    //     return redirect()->back()->with('success', 'Guest checked in successfully.');
    // }

    // public function checkout($id)
    // {
    //     $room = Room::findOrFail($id);
    //     $room->update([
    //         'guest_name' => null,
    //         'checkin' => null,
    //         'checkout' => now(),
    //         'status' => 'available'
    //     ]);
    //     // RoomUpdated::publish($room);
    //     return redirect()->back()->with('success', 'Guest checked out successfully.');
    // }


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

        // (Nanti: publish MQTT ke STB)
        // RoomUpdated::publish($room);

        return redirect()->back()->with('success', "Guest '{$request->guest_name}' checked in successfully.");
    }

    public function checkout($id)
    {
        $room = Room::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $room->update([
            'guest_name' => null,
            'checkout' => now(),
            'status' => 'available',
        ]);

        // (Nanti: publish MQTT ke STB)
        // RoomUpdated::publish($room);

        return redirect()->back()->with('success', 'Guest checked out successfully.');
    }
}

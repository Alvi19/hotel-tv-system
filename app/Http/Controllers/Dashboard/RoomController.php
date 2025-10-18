<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('hotel_id', Auth::user()->hotel_id)->get();
        return view('dashboard.rooms.index', compact('rooms'));
    }

    public function checkin(Request $request, $id)
    {
        $request->validate(['guest_name' => 'required|string']);
        $room = Room::findOrFail($id);
        $room->update([
            'guest_name' => $request->guest_name,
            'checkin' => now(),
            'status' => 'occupied',
        ]);
        // RoomUpdated::publish($room); // kirim MQTT event
        return redirect()->back()->with('success', 'Guest checked in successfully.');
    }

    public function checkout($id)
    {
        $room = Room::findOrFail($id);
        $room->update([
            'guest_name' => null,
            'checkin' => null,
            'checkout' => now(),
            'status' => 'available'
        ]);
        // RoomUpdated::publish($room);
        return redirect()->back()->with('success', 'Guest checked out successfully.');
    }
}

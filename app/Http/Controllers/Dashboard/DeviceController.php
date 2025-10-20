<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function adminIndex()
    {
        // Hanya IT Admin, tampilkan semua hotel dan device
        $devices = Device::with(['hotel', 'room'])
            ->orderBy('hotel_id')
            ->orderBy('id')
            ->get();

        return view('dashboard.admin.devices.index', compact('devices'));
    }

    public function index()
    {
        $hotelId = Auth::user()->hotel_id;
        $devices = Device::where('hotel_id', $hotelId)->with('room')->get();

        return view('dashboard.devices.index', compact('devices'));
    }

    public function create()
    {
        $rooms = Room::where('hotel_id', Auth::user()->hotel_id)->get();
        return view('dashboard.devices.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|max:100|unique:devices',
            'firmware_version' => 'nullable|string|max:50',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        Device::create([
            'hotel_id' => Auth::user()->hotel_id,
            'device_id' => $request->device_id,
            'room_id' => $request->room_id,
            'firmware_version' => $request->firmware_version,
            'status' => 'offline',
        ]);

        return redirect()->route('dashboard.devices.index')->with('success', 'Device added successfully.');
    }

    public function edit($id)
    {
        $device = Device::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        $rooms = Room::where('hotel_id', Auth::user()->hotel_id)->get();

        return view('dashboard.devices.edit', compact('device', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'firmware_version' => 'nullable|string|max:50',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $device->update($request->only(['firmware_version', 'room_id']));

        return redirect()->route('dashboard.devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy($id)
    {
        $device = Device::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        $device->delete();

        return redirect()->route('dashboard.devices.index')->with('success', 'Device removed successfully.');
    }
}

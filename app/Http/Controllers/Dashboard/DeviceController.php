<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Daftar semua device (Super Admin)
     */
    public function adminIndex()
    {
        $devices = Device::with(['hotel', 'room'])
            ->orderBy('hotel_id')
            ->orderBy('id')
            ->get();

        return view('dashboard.admin.devices.index', compact('devices'));
    }

    /**
     * Daftar device milik hotel user
     */
    public function index()
    {
        $user = Auth::user();

        $devices = $user->isSuperAdmin()
            ? Device::with(['hotel', 'room'])->orderBy('hotel_id')->get()
            : Device::where('hotel_id', $user->hotel_id)->with('room')->get();

        return view('dashboard.devices.index', compact('devices'));
    }

    /**
     * Form tambah device
     */
    public function create()
    {
        $user = Auth::user();

        $rooms = $user->isSuperAdmin()
            ? Room::with('hotel')->orderBy('hotel_id')->get()
            : Room::where('hotel_id', $user->hotel_id)->get();

        $hotels = $user->isSuperAdmin() ? Hotel::orderBy('name')->get() : null;

        return view('dashboard.devices.create', compact('rooms', 'hotels'));
    }

    /**
     * Simpan device baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'device_id' => 'required|string|max:100|unique:devices',
            'firmware_version' => 'nullable|string|max:50',
            'room_id' => 'nullable|exists:rooms,id',
            'hotel_id' => $user->isSuperAdmin() ? 'required|exists:hotels,id' : 'nullable',
            'status' => 'nullable|in:online,offline',
        ]);

        $hotelId = $user->isSuperAdmin() ? $request->hotel_id : $user->hotel_id;

        Device::create([
            'hotel_id' => $hotelId,
            'device_id' => $request->device_id,
            'room_id' => $request->room_id,
            'firmware_version' => $request->firmware_version,
            'status' => $request->status ?? 'offline',
            'last_seen' => $request->status === 'online' ? now() : null,
        ]);

        return redirect()->route('dashboard.devices.index')->with('success', 'Device added successfully.');
    }

    /**
     * Form edit device
     */
    public function edit($id)
    {
        $user = Auth::user();

        $device = $user->isSuperAdmin()
            ? Device::with(['hotel', 'room'])->findOrFail($id)
            : Device::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $rooms = $user->isSuperAdmin()
            ? Room::with('hotel')->get()
            : Room::where('hotel_id', $user->hotel_id)->get();

        $hotels = $user->isSuperAdmin() ? Hotel::orderBy('name')->get() : null;

        return view('dashboard.devices.edit', compact('device', 'rooms', 'hotels'));
    }

    /**
     * Update device
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $device = $user->isSuperAdmin()
            ? Device::findOrFail($id)
            : Device::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $request->validate([
            'device_id' => 'sometimes|string|max:100|unique:devices,device_id,' . $device->id,
            'firmware_version' => 'sometimes|nullable|string|max:50',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
            'hotel_id' => $user->isSuperAdmin() ? 'sometimes|exists:hotels,id' : 'nullable',
            'status' => 'sometimes|in:online,offline',
        ]);

        $data = $request->only(['device_id', 'firmware_version', 'room_id', 'status']);

        if ($user->isSuperAdmin() && $request->filled('hotel_id')) {
            $data['hotel_id'] = $request->hotel_id;
        }

        // Update last_seen otomatis kalau status diubah ke online
        if (isset($data['status']) && $data['status'] === 'online') {
            $data['last_seen'] = now();
        }

        $device->update($data);

        return redirect()->route('dashboard.devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Hapus device
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $device = $user->isSuperAdmin()
            ? Device::findOrFail($id)
            : Device::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $device->delete();

        return redirect()->route('dashboard.devices.index')->with('success', 'Device removed successfully.');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|unique:devices,device_id',
            'room_id' => 'required|integer|exists:rooms,id',
            'firmware_version' => 'nullable|string',
        ]);

        $device = Device::create([
            'device_id' => $request->device_id,
            'room_id' => $request->room_id,
            'firmware_version' => $request->firmware_version,
            'status' => 'online',
            'last_seen' => now(),
        ]);

        return response()->json(['message' => 'Device registered', 'device' => $device]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string|exists:devices,device_id',
            'status' => 'required|in:online,offline,error',
        ]);

        DB::table('devices')
            ->where('device_id', $request->device_id)
            ->update([
                'status' => $request->status,
                'last_seen' => now(),
            ]);

        return response()->json(['message' => 'Status updated']);
    }
}

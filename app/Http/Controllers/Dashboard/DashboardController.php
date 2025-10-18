<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;

        $roomsCount = Room::where('hotel_id', $hotelId)->count();
        $occupiedRooms = Room::where('hotel_id', $hotelId)->where('status', 'occupied')->count();
        $bannersCount = Banner::where('hotel_id', $hotelId)->where('is_active', true)->count();
        $devicesOnline = Device::where('hotel_id', $hotelId)->where('status', 'online')->count();

        return view('dashboard.index', compact('roomsCount', 'occupiedRooms', 'bannersCount', 'devicesOnline'));
    }
}

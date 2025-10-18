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
        $user = Auth::user();
        $hotelId = $user->hotel_id ?? null;

        $roomsCount = Room::where('hotel_id', $hotelId)->count();
        $devicesCount = Device::where('hotel_id', $hotelId)->count();
        $bannersCount = Banner::where('hotel_id', $hotelId)->count();

        return view('dashboard.index', compact('roomsCount', 'devicesCount', 'bannersCount'));
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Device;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isGlobalRole()) {
            $totalHotels     = Hotel::count();
            $totalRooms      = Room::count();
            $occupiedRooms   = Room::where('status', 'occupied')->count();
            $totalBanners    = Banner::where('is_active', true)->count();
            $devicesOnline   = Device::where('status', 'online')->count();
            $devicesOffline  = Device::where('status', 'offline')->count();
            $hotels = Hotel::withCount(['rooms'])->orderBy('name')->get();

            return view('dashboard.index', compact(
                'totalHotels',
                'totalRooms',
                'occupiedRooms',
                'totalBanners',
                'devicesOnline',
                'devicesOffline',
                'hotels'
            ));
        }

        $hotelId = $user->hotel_id;
        $hotel   = Hotel::find($hotelId);

        if (!$hotel) {
            abort(403, 'Hotel not found for this user.');
        }

        $totalHotels    = 1;
        $totalRooms     = Room::where('hotel_id', $hotelId)->count();
        $occupiedRooms  = Room::where('hotel_id', $hotelId)->where('status', 'occupied')->count();
        $totalBanners   = Banner::where('hotel_id', $hotelId)->where('is_active', true)->count();
        $devicesOnline  = Device::where('hotel_id', $hotelId)->where('status', 'online')->count();
        $devicesOffline = Device::where('hotel_id', $hotelId)->where('status', 'offline')->count();

        return view('dashboard.index', compact(
            'totalHotels',
            'totalRooms',
            'occupiedRooms',
            'totalBanners',
            'devicesOnline',
            'devicesOffline',
            'hotel'
        ));
    }
}

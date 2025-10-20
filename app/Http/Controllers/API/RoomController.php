<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index($hotel_id)
    {
        $rooms = Room::where('hotel_id', $hotel_id)->get(['id', 'room_number', 'guest_name', 'status', 'checkin', 'checkout']);

        return response()->json($rooms);
    }
}

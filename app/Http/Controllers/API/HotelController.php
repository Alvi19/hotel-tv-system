<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function show($hotel_id)
    {
        $hotel = Hotel::findOrFail($hotel_id);

        return response()->json([
            'id' => $hotel->id,
            'name' => $hotel->name,
            'description' => $hotel->description,
            'address' => $hotel->address,
            'phone' => $hotel->phone,
            'email' => $hotel->email,
            'website' => $hotel->website,
            'logo_url' => asset('storage/' . $hotel->logo_url),
            'background_image_url' => asset('storage/' . $hotel->background_image_url),
        ]);
    }
}

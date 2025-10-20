<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    public function show($hotel_id)
    {
        try {
            $hotel = Hotel::find($hotel_id);

            if (!$hotel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel not found'
                ], 404);
            }

            // Publish ke HiveMQ
            try {
                $mqtt = new MqttService();
                $topic = "hotel/{$hotel->id}/info";

                $payload = [
                    'event' => 'hotel_info',
                    'hotel_id' => $hotel->id,
                    'name' => $hotel->name,
                    'description' => $hotel->description,
                    'address' => $hotel->address,
                    'phone' => $hotel->phone,
                    'email' => $hotel->email,
                    'website' => $hotel->website,
                    'logo_url' => asset('storage/' . $hotel->logo_url),
                    'background_image_url' => asset('storage/' . $hotel->background_image_url),
                    'timestamp' => now()->toDateTimeString(),
                ];

                $mqtt->publish($topic, $payload);
            } catch (\Throwable $e) {
                Log::error("❌ MQTT publish error in HotelController: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'data' => $hotel
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Hotel API error: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    // public function show($hotel_id)
    // {
    //     try {
    //         $hotel = Hotel::find($hotel_id);

    //         if (!$hotel) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Hotel not found'
    //             ], 404);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'data' => $hotel
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Server error'
    //         ], 500);
    //     }
    // }
}

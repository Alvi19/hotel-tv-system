<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\MqttService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function index($hotel_id)
    {
        try {
            $today = Carbon::today();

            $banners = Banner::where('hotel_id', $hotel_id)
                ->where('is_active', true)
                ->where(function ($q) use ($today) {
                    $q->whereNull('active_from')
                        ->orWhere(function ($q2) use ($today) {
                            $q2->where('active_from', '<=', $today)
                                ->where('active_to', '>=', $today);
                        });
                })
                ->orderBy('created_at', 'desc')
                ->get(['id', 'title', 'description', 'image_url']);

            $banners->transform(function ($banner) {
                $banner->image_url = asset('storage/' . $banner->image_url);
                return $banner;
            });

            // ✅ Publish ke HiveMQ
            try {
                $mqtt = new MqttService();
                $mqtt->publish("hotel/{$hotel_id}/banners", [
                    'event' => 'banners_update',
                    'hotel_id' => $hotel_id,
                    'data' => $banners,
                    'timestamp' => now()->toDateTimeString(),
                ]);
            } catch (\Throwable $e) {
                Log::error("❌ MQTT publish error (banners): " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'data' => $banners,
            ]);
        } catch (\Throwable $e) {
            Log::error("❌ BannerController error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error',
            ], 500);
        }
    }

    // public function index($hotel_id)
    // {
    //     $today = Carbon::today();

    //     $banners = Banner::where('hotel_id', $hotel_id)
    //         ->where('is_active', true)
    //         ->where(function ($q) use ($today) {
    //             $q->whereNull('active_from')
    //                 ->orWhere(function ($q2) use ($today) {
    //                     $q2->where('active_from', '<=', $today)
    //                         ->where('active_to', '>=', $today);
    //                 });
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->get(['id', 'title', 'description', 'image_url']);

    //     $banners->transform(function ($banner) {
    //         $banner->image_url = asset('storage/' . $banner->image_url);
    //         return $banner;
    //     });

    //     return response()->json($banners);
    // }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index($hotel_id)
    {
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

        return response()->json($banners);
    }
}

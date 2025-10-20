<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index($hotel_id)
    {
        $contents = Content::where('hotel_id', $hotel_id)
            ->where('is_active', true)
            ->orderBy('type')
            ->get(['id', 'title', 'type', 'image_url', 'body']);

        $contents->transform(function ($content) {
            $content->image_url = $content->image_url ? asset('storage/' . $content->image_url) : null;
            return $content;
        });

        return response()->json($contents);
    }
}

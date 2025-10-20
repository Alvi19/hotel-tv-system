<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function index($hotel_id)
    {
        $shortcuts = Shortcut::where('hotel_id', $hotel_id)
            ->where('is_active', true)
            ->orderBy('order_no')
            ->get(['id', 'title', 'icon_url', 'type', 'target', 'order_no']);

        $shortcuts->transform(function ($shortcut) {
            $shortcut->icon_url = $shortcut->icon_url ? asset('storage/' . $shortcut->icon_url) : null;
            return $shortcut;
        });

        return response()->json($shortcuts);
    }
}

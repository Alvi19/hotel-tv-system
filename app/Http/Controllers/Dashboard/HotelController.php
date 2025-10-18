<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        return view('dashboard.hotel.index');
    }

    public function edit()
    {
        $hotel = Hotel::findOrFail(auth()->user()->hotel_id);
        return view('dashboard.hotels.edit', compact('hotel'));
    }

    public function update(Request $request)
    {
        $hotel = Hotel::findOrFail(auth()->user()->hotel_id);

        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|image',
            'background_image_url' => 'nullable|image',
        ]);

        $data = $request->only(['name', 'description', 'address', 'phone', 'email', 'website']);

        if ($request->hasFile('logo_url')) {
            if ($hotel->logo_url) Storage::disk('public')->delete($hotel->logo_url);
            $data['logo_url'] = $request->file('logo_url')->store('uploads/logos', 'public');
        }

        if ($request->hasFile('background_image_url')) {
            if ($hotel->background_image_url) Storage::disk('public')->delete($hotel->background_image_url);
            $data['background_image_url'] = $request->file('background_image_url')->store('uploads/backgrounds', 'public');
        }

        $hotel->update($data);

        return redirect()->back()->with('success', 'Hotel info updated successfully.');
    }
}

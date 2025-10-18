<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function index()
    {
        return view('dashboard.hotel.index');
    }

    public function edit()
    {
        $hotel = Hotel::find(Auth::user()->hotel_id);
        return view('dashboard.hotels.edit', compact('hotel'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|image',
            'background_image_url' => 'nullable|image',
        ]);

        $hotel = Hotel::find(Auth::user()->hotel_id);

        if ($request->hasFile('logo_url')) {
            $hotel->logo_url = $request->file('logo_url')->store('uploads/logos', 'public');
        }
        if ($request->hasFile('background_image_url')) {
            $hotel->background_image_url = $request->file('background_image_url')->store('uploads/backgrounds', 'public');
        }

        $hotel->update($request->only(['name', 'description', 'address', 'phone', 'email', 'website']));

        return redirect()->back()->with('success', 'Hotel information updated successfully.');
    }
}

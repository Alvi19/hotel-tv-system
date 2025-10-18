<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::orderBy('id', 'desc')->get();
        return view('dashboard.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('dashboard.hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|image|mimes:jpg,png,jpeg',
            'background_image_url' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        $data = $request->only(['name', 'description', 'address', 'phone', 'email', 'website']);

        if ($request->hasFile('logo_url')) {
            $data['logo_url'] = $request->file('logo_url')->store('uploads/logos', 'public');
        }

        if ($request->hasFile('background_image_url')) {
            $data['background_image_url'] = $request->file('background_image_url')->store('uploads/backgrounds', 'public');
        }

        Hotel::create($data);

        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('dashboard.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo_url' => 'nullable|image|mimes:jpg,png,jpeg',
            'background_image_url' => 'nullable|image|mimes:jpg,png,jpeg',
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

        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        if ($hotel->logo_url) Storage::disk('public')->delete($hotel->logo_url);
        if ($hotel->background_image_url) Storage::disk('public')->delete($hotel->background_image_url);
        $hotel->delete();

        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}

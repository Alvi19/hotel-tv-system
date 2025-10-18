<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;
        $banners = Banner::where('hotel_id', $hotelId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('dashboard.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after_or_equal:active_from',
        ]);

        $imagePath = $request->file('image_url')->store('uploads/banners', 'public');

        Banner::create([
            'hotel_id' => Auth::user()->hotel_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $imagePath,
            'active_from' => $request->active_from,
            'active_to' => $request->active_to,
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit($id)
    {
        $banner = Banner::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        return view('dashboard.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after_or_equal:active_from',
        ]);

        $data = $request->only(['title', 'description', 'active_from', 'active_to', 'is_active']);

        if ($request->hasFile('image_url')) {
            if ($banner->image_url) Storage::disk('public')->delete($banner->image_url);
            $data['image_url'] = $request->file('image_url')->store('uploads/banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = Banner::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        if ($banner->image_url) Storage::disk('public')->delete($banner->image_url);
        $banner->delete();

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $banners = $user->isSuperAdmin()
            ? Banner::with('hotel')->orderBy('created_at', 'desc')->get()
            : Banner::where('hotel_id', $user->hotel_id)
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
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'image_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'active_from' => 'nullable|date',
            'active_to' => 'nullable|date|after_or_equal:active_from',
            'hotel_id' => $user->isSuperAdmin() ? 'required|exists:hotels,id' : 'nullable',
        ]);

        $imagePath = $request->file('image_url')->store('uploads/banners', 'public');

        $hotelId = $user->isSuperAdmin() ? $request->hotel_id : $user->hotel_id;

        Banner::create([
            'hotel_id' => $hotelId,
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $imagePath,
            'active_from' => $request->active_from,
            'active_to' => $request->active_to,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('dashboard.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $banner = $user->isSuperAdmin()
            ? Banner::with('hotel')->findOrFail($id)
            : Banner::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $hotels = $user->isSuperAdmin() ? Hotel::orderBy('name')->get() : null;

        return view('dashboard.banners.edit', compact('banner', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $banner = $user->isSuperAdmin()
            ? Banner::findOrFail($id)
            : Banner::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:200',
            'description' => 'sometimes|nullable|string',
            'image_url' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
            'active_from' => 'sometimes|nullable|date',
            'active_to' => 'sometimes|nullable|date|after_or_equal:active_from',
            'hotel_id' => $user->isSuperAdmin() ? 'sometimes|exists:hotels,id' : 'nullable',
            'is_active' => 'sometimes|boolean',
        ]);

        // Ambil data yang dikirim saja
        $data = $request->only([
            'title',
            'description',
            'active_from',
            'active_to',
            'is_active'
        ]);

        // Jika checkbox tidak dikirim (tidak dicentang), pastikan false
        $data['is_active'] = $request->has('is_active');

        if ($user->isSuperAdmin() && $request->filled('hotel_id')) {
            $data['hotel_id'] = $request->hotel_id;
        }

        // Handle file upload jika ada
        if ($request->hasFile('image_url')) {
            if ($banner->image_url) {
                Storage::disk('public')->delete($banner->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('uploads/banners', 'public');
        }

        // Update hanya kolom yang dikirim
        $banner->fill($data)->save();

        return redirect()->route('dashboard.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = Banner::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        if ($banner->image_url) Storage::disk('public')->delete($banner->image_url);
        $banner->delete();

        return redirect()->route('dashboard.banners.index')->with('success', 'Banner deleted successfully.');
    }
}

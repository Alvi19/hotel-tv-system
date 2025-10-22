<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminHotelController extends Controller
{
    /**
     * ✅ Super Admin — List semua hotel
     */
    public function index()
    {
        $hotels = Hotel::orderBy('created_at', 'desc')->get();
        return view('dashboard.hotels.index', compact('hotels'));
    }

    /**
     * ✅ Form tambah hotel baru
     */
    public function create()
    {
        return view('dashboard.hotels.create');
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('dashboard.hotels.show', compact('hotel'));
    }

    /**
     * ✅ Simpan hotel baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:hotels,name',
            'description' => 'nullable|string',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:100',
            'website'     => 'nullable|url|max:255',
            'logo_url'    => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'background_image_url' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
            'video_url'   => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200',
            'text_running' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'address', 'phone', 'email', 'website', 'text_running']);
        $safeName = str_replace(' ', '_', strtolower($request->name));
        $timestamp = now()->format('YmdHis');

        // Upload files
        $data['logo_url'] = $this->uploadFile($request, 'logo_url', "uploads/logos", "{$safeName}_{$timestamp}_logo");
        $data['background_image_url'] = $this->uploadFile($request, 'background_image_url', "uploads/backgrounds", "{$safeName}_{$timestamp}_background");
        $data['video_url'] = $this->uploadFile($request, 'video_url', "uploads/videos", "{$safeName}_{$timestamp}_video");

        $hotel = Hotel::create($data);
        Log::info('🏨 New hotel created', ['hotel' => $hotel]);

        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * ✅ Form edit hotel
     */
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('dashboard.hotels.edit', compact('hotel'));
    }

    /**
     * ✅ Update hotel (Super Admin)
     */
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:100',
            'website'     => 'nullable|url|max:255',
            'logo_url'    => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'background_image_url' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
            'video_url'   => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:51200',
            'text_running' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'address', 'phone', 'email', 'website', 'text_running']);
        $safeName = str_replace(' ', '_', strtolower($hotel->name));
        $timestamp = now()->format('YmdHis');

        // Replace uploads if new file uploaded
        $data['logo_url'] = $this->uploadFile($request, 'logo_url', "uploads/logos", "{$safeName}_{$timestamp}_logo", $hotel->logo_url);
        $data['background_image_url'] = $this->uploadFile($request, 'background_image_url', "uploads/backgrounds", "{$safeName}_{$timestamp}_background", $hotel->background_image_url);
        $data['video_url'] = $this->uploadFile($request, 'video_url', "uploads/videos", "{$safeName}_{$timestamp}_video", $hotel->video_url);

        $hotel->update($data);
        Log::info('💾 Hotel updated', ['hotel_id' => $hotel->id]);

        return redirect()->route('dashboard.hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * ✅ Hapus hotel
     */
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);

        foreach (['logo_url', 'background_image_url', 'video_url'] as $field) {
            if ($hotel->$field && Storage::disk('public')->exists($hotel->$field)) {
                Storage::disk('public')->delete($hotel->$field);
            }
        }

        $hotel->delete();
        Log::info('🗑️ Hotel deleted', ['id' => $id]);
        return redirect()->back()->with('success', 'Hotel deleted successfully.');
    }

    /**
     * 🔧 Helper: Upload file & hapus lama
     */
    private function uploadFile($request, $field, $folder, $filename, $oldFile = null)
    {
        if (!$request->hasFile($field)) {
            return $oldFile;
        }

        $file = $request->file($field);
        $extension = $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, "{$filename}.{$extension}", 'public');

        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        return $path;
    }
}

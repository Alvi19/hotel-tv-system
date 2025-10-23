<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Hotel;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Tampilkan daftar konten
     */
    public function index()
    {
        $user = Auth::user();

        $contents = $user->isSuperAdmin()
            ? Content::with(['hotel'])->orderBy('hotel_id')->orderBy('type')->get()
            : Content::where('hotel_id', $user->hotel_id)->orderBy('type')->get();

        return view('dashboard.contents.index', compact('contents'));
    }

    /**
     * Form create content
     */
    public function create()
    {
        $user = Auth::user();

        $hotels = $user->isSuperAdmin() ? Hotel::orderBy('name')->get() : null;
        $roomCategories = RoomCategory::orderBy('name')->get();

        return view('dashboard.contents.create', compact('hotels', 'roomCategories'));
    }

    /**
     * Simpan data content
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:about,room_type,nearby_place,facility,event,promotion,policy',
            'body' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'room_type_id' => 'nullable|exists:room_categories,id',
            'hotel_id' => $user->isSuperAdmin() ? 'required|exists:hotels,id' : 'nullable',
        ]);

        $hotelId = $user->isSuperAdmin() ? $request->hotel_id : $user->hotel_id;

        $data = $request->only(['title', 'type', 'body', 'room_type_id']);
        $data['hotel_id'] = $hotelId;
        $data['is_active'] = $request->has('is_active');

        // Custom file name handling (like banner)
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = str_replace(' ', '_', strtolower($request->title)) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/contents', $filename, 'public');
            $data['image_url'] = 'uploads/contents/' . $filename;
        }

        Content::create($data);

        return redirect()->route('dashboard.contents.index')->with('success', 'Content added successfully.');
    }

    /**
     * Form edit content
     */
    public function edit($id)
    {
        $user = Auth::user();

        $content = $user->isSuperAdmin()
            ? Content::with('hotel')->findOrFail($id)
            : Content::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $hotels = $user->isSuperAdmin() ? Hotel::orderBy('name')->get() : null;
        $roomCategories = RoomCategory::orderBy('name')->get();

        return view('dashboard.contents.edit', compact('content', 'hotels', 'roomCategories'));
    }

    /**
     * Update data content
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $content = $user->isSuperAdmin()
            ? Content::findOrFail($id)
            : Content::where('hotel_id', $user->hotel_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:about,room_type,nearby_place,facility,event,promotion,policy',
            'body' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'room_type_id' => 'nullable|exists:room_categories,id',
            'hotel_id' => $user->isSuperAdmin() ? 'sometimes|exists:hotels,id' : 'nullable',
        ]);

        $data = $request->only(['title', 'type', 'body', 'room_type_id']);
        $data['is_active'] = $request->has('is_active');

        if ($user->isSuperAdmin() && $request->filled('hotel_id')) {
            $data['hotel_id'] = $request->hotel_id;
        }

        // 📷 Replace old image (optional)
        if ($request->hasFile('image_url')) {
            if ($content->image_url && Storage::disk('public')->exists($content->image_url)) {
                Storage::disk('public')->delete($content->image_url);
            }

            $file = $request->file('image_url');
            $filename = str_replace(' ', '_', strtolower($request->title)) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/contents', $filename, 'public');
            $data['image_url'] = 'uploads/contents/' . $filename;
        }

        $content->update($data);

        return redirect()->route('dashboard.contents.index')->with('success', 'Content updated successfully.');
    }

    /**
     * Hapus content
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $content = $user->isSuperAdmin()
            ? Content::findOrFail($id)
            : Content::where('hotel_id', $user->hotel_id)->findOrFail($id);

        if ($content->image_url) {
            Storage::disk('public')->delete($content->image_url);
        }

        $content->delete();

        return redirect()->route('dashboard.contents.index')->with('success', 'Content deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;
        $contents = Content::where('hotel_id', $hotelId)
            ->orderBy('type')
            ->get();

        return view('dashboard.contents.index', compact('contents'));
    }

    public function create()
    {
        return view('dashboard.contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:about,facilities,services,contact',
            'body' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'body']);
        $data['hotel_id'] = Auth::user()->hotel_id;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('uploads/contents', 'public');
        }

        Content::create($data);

        return redirect()->route('dashboard.contents.index')->with('success', 'Content created successfully.');
    }

    public function edit($id)
    {
        $content = Content::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        return view('dashboard.contents.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $content = Content::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:about,facilities,services,contact',
            'body' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'body']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image_url')) {
            if ($content->image_url) Storage::disk('public')->delete($content->image_url);
            $data['image_url'] = $request->file('image_url')->store('uploads/contents', 'public');
        }

        $content->update($data);

        return redirect()->route('dashboard.contents.index')->with('success', 'Content updated successfully.');
    }

    public function destroy($id)
    {
        $content = Content::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        if ($content->image_url) Storage::disk('public')->delete($content->image_url);
        $content->delete();

        return redirect()->route('dashboard.contents.index')->with('success', 'Content deleted.');
    }
}

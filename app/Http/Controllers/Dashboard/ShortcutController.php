<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShortcutController extends Controller
{
    public function index()
    {
        $hotelId = Auth::user()->hotel_id;
        $shortcuts = Shortcut::where('hotel_id', $hotelId)
            ->orderBy('order_no')
            ->get();

        return view('dashboard.shortcuts.index', compact('shortcuts'));
    }

    public function create()
    {
        return view('dashboard.shortcuts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'type' => 'required|in:youtube,netflix,iptv,web,app',
            'target' => 'nullable|string|max:255',
            'icon_url' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'order_no' => 'integer|min:0',
        ]);

        $data = $request->only(['title', 'type', 'target', 'order_no']);
        $data['hotel_id'] = Auth::user()->hotel_id;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon_url')) {
            $data['icon_url'] = $request->file('icon_url')->store('uploads/shortcuts', 'public');
        }

        Shortcut::create($data);

        return redirect()->route('dashboard.shortcuts.index')->with('success', 'Shortcut created successfully.');
    }

    public function edit($id)
    {
        $shortcut = Shortcut::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);
        return view('dashboard.shortcuts.edit', compact('shortcut'));
    }

    public function update(Request $request, $id)
    {
        $shortcut = Shortcut::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'type' => 'required|in:youtube,netflix,iptv,web,app',
            'target' => 'nullable|string|max:255',
            'icon_url' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'order_no' => 'integer|min:0',
        ]);

        $data = $request->only(['title', 'type', 'target', 'order_no']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon_url')) {
            if ($shortcut->icon_url) Storage::disk('public')->delete($shortcut->icon_url);
            $data['icon_url'] = $request->file('icon_url')->store('uploads/shortcuts', 'public');
        }

        $shortcut->update($data);

        return redirect()->route('dashboard.shortcuts.index')->with('success', 'Shortcut updated successfully.');
    }

    public function destroy($id)
    {
        $shortcut = Shortcut::where('hotel_id', Auth::user()->hotel_id)->findOrFail($id);

        if ($shortcut->icon_url) Storage::disk('public')->delete($shortcut->icon_url);
        $shortcut->delete();

        return redirect()->route('dashboard.shortcuts.index')->with('success', 'Shortcut deleted successfully.');
    }
}

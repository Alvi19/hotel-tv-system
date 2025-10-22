<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomCategoryController extends Controller
{
    public function __construct()
    {
        // Hanya super admin yang boleh akses
        $this->middleware('role:it_admin');
    }

    /**
     * ✅ List semua kategori kamar
     */
    public function index()
    {
        $categories = RoomCategory::orderBy('name')->get();
        return view('dashboard.room_categories.index', compact('categories'));
    }

    /**
     * ✅ Form tambah kategori
     */
    public function create()
    {
        return view('dashboard.room_categories.create');
    }

    /**
     * ✅ Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:room_categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        RoomCategory::create($request->only(['name', 'description']));

        return redirect()->route('dashboard.room-categories.index')
            ->with('success', 'Room category created successfully.');
    }

    /**
     * ✅ Form edit kategori
     */
    public function edit(RoomCategory $roomCategory)
    {
        return view('dashboard.room_categories.edit', compact('roomCategory'));
    }

    /**
     * ✅ Update kategori
     */
    public function update(Request $request, RoomCategory $roomCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:room_categories,name,' . $roomCategory->id,
            'description' => 'nullable|string|max:255',
        ]);

        $roomCategory->update($request->only(['name', 'description']));

        return redirect()->route('dashboard.room-categories.index')
            ->with('success', 'Room category updated successfully.');
    }

    /**
     * ✅ Hapus kategori
     */
    public function destroy(RoomCategory $roomCategory)
    {
        $roomCategory->delete();

        return redirect()->route('dashboard.room-categories.index')
            ->with('success', 'Room category deleted successfully.');
    }
}

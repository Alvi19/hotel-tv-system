<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function index()
    // {
    //     $this->authorizeItAdmin();

    //     $users = User::with('hotel')->orderBy('role')->get();
    //     return view('dashboard.users.index', compact('users'));
    // }

    // // form tambah staff
    // public function create()
    // {
    //     $this->authorizeItAdmin();

    //     $hotels = Hotel::all();
    //     return view('dashboard.users.create', compact('hotels'));
    // }

    // // simpan user baru
    // public function store(Request $request)
    // {
    //     $this->authorizeItAdmin();

    //     $request->validate([
    //         'name' => 'required|string|unique:users',
    //         'email' => 'nullable|email|unique:users',
    //         'password' => 'required|string|min:6',
    //         'role' => 'required|in:it_admin,hotel_staff',
    //         'hotel_id' => 'nullable|exists:hotels,id',
    //     ]);

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role,
    //         'hotel_id' => $request->hotel_id,
    //     ]);

    //     return redirect()->route('dashboard.users.index')->with('success', 'User created successfully.');
    // }

    // // form edit user
    // public function edit($id)
    // {
    //     $this->authorizeItAdmin();

    //     $user = User::findOrFail($id);
    //     $hotels = Hotel::all();

    //     return view('dashboard.users.edit', compact('user', 'hotels'));
    // }

    // // update user
    // public function update(Request $request, $id)
    // {
    //     $this->authorizeItAdmin();

    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|unique:users,name,' . $id,
    //         'email' => 'nullable|email|unique:users,email,' . $id,
    //         'password' => 'nullable|string|min:6',
    //         'role' => 'required|in:it_admin,hotel_staff',
    //         'hotel_id' => 'nullable|exists:hotels,id',
    //     ]);

    //     $data = $request->only(['name', 'role', 'hotel_id']);

    //     if ($request->filled('password')) {
    //         $data['password'] = Hash::make($request->password);
    //     }

    //     $user->update($data);

    //     return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    // }

    // // hapus user
    // public function destroy($id)
    // {
    //     $this->authorizeItAdmin();

    //     User::findOrFail($id)->delete();

    //     return redirect()->route('dashboard.users.index')->with('success', 'User deleted successfully.');
    // }

    // private function authorizeItAdmin()
    // {
    //     if (Auth::user()->role !== 'it_admin') {
    //         abort(403, 'Unauthorized access');
    //     }
    // }

    public function index()
    {
        // Super Admin bisa lihat semua user
        $users = User::with(['role', 'hotel'])->get();

        return view('dashboard.users.index', compact('users'));
    }

    // ➕ CREATE
    public function create()
    {
        // Hanya IT Admin (Super Admin)
        $roles = Role::all();
        $hotels = Hotel::all();

        return view('dashboard.users.create', compact('roles', 'hotels'));
    }

    // 💾 STORE
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'role_id'   => 'required|exists:roles,id',
            'hotel_id'  => 'nullable|exists:hotels,id',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id  = $request->role_id;
        $user->hotel_id = $request->hotel_id;
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'User created successfully.');
    }

    // ✏️ EDIT
    public function edit($id)
    {
        $editUser = User::findOrFail($id);
        $roles = Role::all();
        $hotels = Hotel::all();

        return view('dashboard.users.edit', compact('editUser', 'roles', 'hotels'));
    }

    // 🔄 UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role_id'  => 'required|exists:roles,id',
            'hotel_id' => 'nullable|exists:hotels,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role_id;
        $user->hotel_id = $request->hotel_id;
        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    }

    // ❌ DESTROY
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        // Hanya user yang punya izin manage_roles yang bisa mengakses
        $this->middleware(['auth', 'permission:manage_roles']);
    }

    /**
     * Menampilkan daftar role
     */
    public function index()
    {
        $user = Auth::user();

        $roles = $user->isGlobalRole()
            ? Role::with(['hotel', 'permissions'])->get()
            : Role::with('permissions')->where('hotel_id', $user->hotel_id)->get();

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Form tambah role
     */
    public function create()
    {
        $user = Auth::user();
        $permissions = Permission::all();
        $hotels = $user->isGlobalRole() ? Hotel::all() : null;

        return view('dashboard.roles.create', compact('hotels', 'permissions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'created_by' => $user->id,
            'scope' => $user->isSuperAdmin() ? 'global' : 'hotel',
            'hotel_id' => $user->hotel_id,
        ]);

        $syncData = [];
        foreach ($request->permissions ?? [] as $permissionId => $actions) {
            $syncData[$permissionId] = ['actions' => implode(',', $actions)];
        }

        // $role->permissions()->sync($syncData);
        // Tambahkan default permission "dashboard:view" jika belum ada
        $dashboardPermission = Permission::where('module', 'dashboard')->first();
        if ($dashboardPermission && !isset($syncData[$dashboardPermission->id])) {
            $syncData[$dashboardPermission->id] = ['actions' => 'view'];
        }

        $role->permissions()->sync($syncData);


        return redirect()->route('dashboard.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Edit role
     */
    public function edit(Role $role)
    {
        $this->authorizeEdit($role);

        $permissions = Permission::orderBy('module')->get();
        $hotels = Auth::user()->isGlobalRole() ? Hotel::all() : null;

        // Ambil semua permission_id + actions dari pivot
        $rolePermissions = $role->permissions->mapWithKeys(function ($perm) {
            return [$perm->id => explode(',', $perm->pivot->actions ?? '')];
        });

        return view('dashboard.roles.edit', compact('role', 'permissions', 'hotels', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorizeEdit($role);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'display_name' => 'nullable|string',
            'permissions' => 'nullable|array',
            'hotel_id' => 'nullable|exists:hotels,id',
        ]);

        $updateData = $request->only(['name', 'display_name']);
        if (Auth::user()->isGlobalRole()) {
            $updateData['hotel_id'] = $request->hotel_id;
        }

        $role->update($updateData);

        // Simpan mapping actions per module
        $syncData = [];
        foreach ($request->permissions ?? [] as $permissionId => $actions) {
            $syncData[$permissionId] = ['actions' => implode(',', $actions)];
        }

        $role->permissions()->sync($syncData);

        return redirect()->route('dashboard.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Hapus role
     */
    public function destroy(Role $role)
    {
        $user = Auth::user();

        // hanya global role yang bisa hapus
        if (!$user->isGlobalRole()) {
            abort(403, 'Unauthorized');
        }

        $role->delete();

        return redirect()->route('dashboard.roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Pastikan user hanya bisa edit role miliknya
     */
    protected function authorizeEdit(Role $role)
    {
        $user = Auth::user();

        // global role bisa edit semua
        if ($user->isGlobalRole()) return true;

        // role hotel hanya bisa edit role dari hotel yang sama
        if ($role->hotel_id !== $user->hotel_id) {
            abort(403, 'Unauthorized action.');
        }

        return true;
    }

    /**
     * Simpan role baru
     */
    // public function store(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'name' => 'required|string|unique:roles,name',
    //         'display_name' => 'nullable|string',
    //         'hotel_id' => 'nullable|exists:hotels,id',
    //         'permissions' => 'nullable|array',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'display_name' => $request->display_name,
    //         'created_by' => $user->id,
    //     ];

    //     // Tentukan scope berdasarkan siapa pembuatnya
    //     if ($user->isGlobalRole()) {
    //         $data['scope'] = $request->hotel_id ? 'hotel' : 'global';
    //         $data['hotel_id'] = $request->hotel_id;
    //     } else {
    //         $data['scope'] = 'hotel';
    //         $data['hotel_id'] = $user->hotel_id;
    //     }

    //     $role = Role::create($data);

    //     if ($request->permissions) {
    //         $role->permissions()->sync($request->permissions);
    //     }

    //     return redirect()->route('dashboard.roles.index')->with('success', 'Role created successfully.');
    // }
}

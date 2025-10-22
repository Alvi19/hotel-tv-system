<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:it_admin');
    }

    public function index()
    {
        $perms = Permission::all();
        return view('dashboard.permissions.index', compact('perms'));
    }

    public function create()
    {
        return view('dashboard.permissions.create');
    }

    public function store(Request $r)
    {
        $r->validate(['key' => 'required|unique:permissions,key', 'description' => 'nullable']);
        Permission::create($r->only('key', 'description'));
        return redirect()->route('dashboard.permissions.index')->with('success', 'Permission saved.');
    }
}

{{-- @extends('layouts.app')

@section('title', 'Create New Role')

@section('content')
    <div class="p-6 space-y-6">

        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
                <i class="bi bi-person-gear text-info"></i> Create Role
            </h3>
            <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card bg-base-300 shadow-xl border border-base-200">
            <div class="card-body">
                <form action="{{ route('dashboard.roles.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">Role Name (System)</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 @error('name') input-error @enderror"
                            placeholder="e.g. hotel_admin, receptionist" required />
                        @error('name')
                            <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300">Display Name (Optional)</span>
                        </label>
                        <input type="text" name="display_name" value="{{ old('display_name') }}"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400"
                            placeholder="e.g. Hotel Administrator" />
                    </div>

                    @if (auth()->user()->isGlobalRole())
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text text-gray-300">Assign to Hotel (optional)</span>
                            </label>
                            <select name="hotel_id" class="select select-bordered w-full bg-base-200 text-white">
                                <option value="">— Global Role —</option>
                                @foreach (\App\Models\Hotel::orderBy('name')->get() as $hotel)
                                    <option value="{{ $hotel->id }}"
                                        {{ (int) old('hotel_id') === $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="label">
                            <span class="label-text text-gray-300">Assign Permissions</span>
                        </label>

                        <div
                            class="bg-base-200 rounded-lg p-4 max-h-72 overflow-y-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @forelse($permissions as $perm)
                                <label class="flex items-start gap-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                        class="checkbox checkbox-primary checkbox-sm mt-1"
                                        {{ is_array(old('permissions')) && in_array($perm->id, old('permissions')) ? 'checked' : '' }} />
                                    <div>
                                        <div class="text-white font-medium">
                                            {{ ucfirst(str_replace('_', ' ', $perm->key)) }}</div>
                                        <div class="text-sm text-gray-400">{{ $perm->description ?? '-' }}</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-sm text-gray-400 italic">No permissions available.</p>
                            @endforelse
                        </div>

                        @error('permissions')
                            <p class="text-error text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center pt-6">
                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>

                        <button type="submit" class="btn btn-primary text-white">
                            <i class="bi bi-save me-1"></i> Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}



@extends('layouts.app')
@section('title', 'Create Role')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-2xl font-semibold text-white">Create Role</h3>
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card bg-base-300 border border-base-200 shadow-xl">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.roles.store') }}" class="space-y-6">
                @csrf

                {{-- 🔹 Basic Info --}}
                <div>
                    <label class="label text-gray-300 font-semibold">Role Name (System)</label>
                    <input type="text" name="name" class="input input-bordered w-full bg-base-200 text-white"
                        placeholder="e.g. hotel_staff" required />
                </div>

                <div>
                    <label class="label text-gray-300 font-semibold">Display Name</label>
                    <input type="text" name="display_name" class="input input-bordered w-full bg-base-200 text-white"
                        placeholder="e.g. Hotel Staff" />
                </div>

                {{-- 🔹 Permission Matrix --}}
                <div class="overflow-x-auto bg-base-200 rounded-lg p-4">
                    <table class="table w-full text-sm text-gray-300">
                        <thead>
                            <tr class="text-white border-b border-base-300">
                                <th>Module</th>
                                <th class="text-center">Create</th>
                                <th class="text-center">Read</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Delete</th>
                                <th class="text-center">Checkin</th>
                                <th class="text-center">Checkout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $perm)
                                @php
                                    $actions = explode(',', $perm->actions ?? '');
                                @endphp
                                <tr class="hover:bg-base-300">
                                    <td class="font-semibold capitalize text-white">{{ ucfirst($perm->module) }}</td>

                                    @foreach(['create', 'view', 'edit', 'delete', 'checkin', 'checkout'] as $action)
                                        <td class="text-center">
                                            @if(in_array($action, $actions))
                                                <input type="checkbox"
                                                    name="permissions[{{ $perm->id }}][]"
                                                    value="{{ $action }}"
                                                    class="checkbox checkbox-sm checkbox-primary" />
                                            @else
                                                <span class="text-gray-600">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 🔹 Buttons --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="bi bi-save me-1"></i> Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-2xl font-semibold text-white">
                Edit Role: {{ $role->display_name ?? $role->name }}
            </h3>
            <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card bg-base-300 border border-base-200 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.roles.update', $role->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- 🔹 Basic Info --}}
                    <div>
                        <label class="label text-gray-300 font-semibold">Role Name (System)</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                            class="input input-bordered w-full bg-base-200 text-white" placeholder="e.g. hotel_staff"
                            required />
                    </div>

                    <div>
                        <label class="label text-gray-300 font-semibold">Display Name</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $role->display_name) }}"
                            class="input input-bordered w-full bg-base-200 text-white" placeholder="e.g. Hotel Staff" />
                    </div>

                    {{-- 🔹 Assign Hotel --}}
                    @if (isset($hotels) && auth()->user()->isGlobalRole())
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text text-gray-300">Assign to Hotel (optional)</span>
                            </label>
                            <select name="hotel_id" class="select select-bordered w-full bg-base-200 text-white">
                                <option value="">{{ __('— Global Role —') }}</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}"
                                        {{ (int) old('hotel_id', $role->hotel_id) === $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

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
                                @foreach ($permissions as $perm)
                                    @php
                                        $actions = explode(',', $perm->actions ?? '');
                                        $selected = $rolePermissions[$perm->id] ?? [];
                                    @endphp
                                    <tr class="hover:bg-base-300">
                                        <td class="font-semibold capitalize text-white">{{ ucfirst($perm->module) }}</td>

                                        @foreach (['create', 'view', 'edit', 'delete', 'checkin', 'checkout'] as $action)
                                            <td class="text-center">
                                                @if (in_array($action, $actions))
                                                    <input type="checkbox" name="permissions[{{ $perm->id }}][]"
                                                        value="{{ $action }}"
                                                        class="checkbox checkbox-sm checkbox-primary"
                                                        {{ in_array($action, $selected) ? 'checked' : '' }}>
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
                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline btn-accent">Cancel</a>
                        <button type="submit" class="btn btn-primary text-white">
                            <i class="bi bi-save me-1"></i> Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

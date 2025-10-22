@extends('layouts.app')
@section('title', 'Add New User')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
            <i class="bi bi-person-plus-fill text-info"></i> Add New User
        </h3>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline btn-accent">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-error shadow-lg">
            <div>
                <i class="bi bi-exclamation-triangle"></i>
                <span>
                    <strong>There were some problems with your input:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
            </div>
        </div>
    @endif

    {{-- Card --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl">
        <div class="card-body space-y-4">
            <form method="POST" action="{{ route('dashboard.users.store') }}">
                @csrf

                {{-- Username --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Username</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g., johndoe"
                        class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 @error('name') input-error @enderror"
                        required
                    />
                    @error('name')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Email</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="e.g., user@example.com"
                        class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 @error('email') input-error @enderror"
                        required
                    />
                    @error('email')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Password</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 @error('password') input-error @enderror"
                        required
                    />
                    @error('password')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Role</span>
                    </label>
                    <select
                        name="role_id"
                        class="select select-bordered w-full bg-base-200 text-white @error('role_id') select-error @enderror"
                        required
                    >
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Hotel (optional) --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Assign Hotel (optional)</span>
                    </label>
                    <select
                        name="hotel_id"
                        class="select select-bordered w-full bg-base-200 text-white"
                    >
                        <option value="">-- No Hotel --</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-5">
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline btn-accent">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

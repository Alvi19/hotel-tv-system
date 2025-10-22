@extends('layouts.app')
@section('title', 'Edit Room')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
            <i class="bi bi-pencil-square text-info"></i> Edit Room
        </h3>

        <a href="{{ route('dashboard.rooms.index') }}" class="btn btn-outline btn-accent">
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
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </span>
            </div>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl">
        <div class="card-body space-y-4">
            <form method="POST" action="{{ route('dashboard.rooms.update', $room->id) }}">
                @csrf
                @method('PUT')

                {{-- 🏨 Hotel (Super Admin Only) --}}
                @if (auth()->user()->isSuperAdmin())
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Assign to Hotel</span>
                        </label>

                        <select name="hotel_id" class="select select-bordered w-full bg-base-200 text-white" required>
                            <option value="">— Select Hotel —</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}" {{ (int) old('hotel_id', $room->hotel_id) === $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('hotel_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                @endif

                {{-- 🚪 Room Number --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Room Number</span>
                    </label>
                    <input type="text"
                           name="room_number"
                           value="{{ old('room_number', $room->room_number) }}"
                           placeholder="e.g., 101, 202B"
                           class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400 @error('room_number') input-error @enderror"
                           required />
                    @error('room_number')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- 🏷️ Room Category --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Category</span>
                    </label>

                    <select name="category_id" class="select select-bordered w-full bg-base-200 text-white">
                        <option value="">— Select Category —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (int) old('category_id', $room->category_id) === $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- ⚙️ Status --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Status</span>
                    </label>
                    <select name="status" class="select select-bordered w-full bg-base-200 text-white">
                        <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>

                    @error('status')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- ✅ Buttons --}}
                <div class="flex justify-end gap-3 pt-5">
                    <a href="{{ route('dashboard.rooms.index') }}" class="btn btn-outline btn-accent">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success text-white">
                        <i class="bi bi-check-circle"></i> Update Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

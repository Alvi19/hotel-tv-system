@extends('layouts.app')

@section('title', 'Edit Device')

@section('content')
<div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-gradient-to-r from-warning to-orange-500 rounded-xl">
                <i class="bi bi-pencil-square text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-semibold text-white">Edit Device</h3>
        </div>

        <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline btn-accent gap-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- CARD --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl hover:shadow-2xl transition-all duration-300">
        <div class="card-body space-y-6">

            <form action="{{ route('dashboard.devices.update', $device->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- 🆔 DEVICE ID --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Device ID</span>
                    </label>
                    <input type="text" value="{{ $device->device_id }}" disabled
                           class="input input-bordered w-full bg-base-200 text-white cursor-not-allowed" />
                </div>

                {{-- 🏨 HOTEL (Super Admin Only) --}}
                @if (Auth::user()->isSuperAdmin() && $device->hotel)
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Assigned Hotel</span>
                        </label>
                        <input type="text" value="{{ $device->hotel->name }}" disabled
                               class="input input-bordered w-full bg-base-200 text-white cursor-not-allowed" />
                    </div>
                @endif

                {{-- 🛏 LINKED ROOM --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Linked Room</span>
                    </label>
                    <select name="room_id"
                            class="select select-bordered w-full bg-base-200 text-white focus:ring-2 focus:ring-info">
                        <option value="">-- Not Linked --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ $device->room_id == $room->id ? 'selected' : '' }}>
                                Nomor Kamar {{ $room->room_number }}
                                @if ($room->hotel)
                                    — {{ $room->hotel->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ⚙️ FIRMWARE VERSION --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Firmware Version</span>
                    </label>
                    <input type="text" name="firmware_version"
                           value="{{ old('firmware_version', $device->firmware_version) }}"
                           placeholder="e.g., v1.0.5"
                           class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" />
                </div>

                {{-- 🌐 STATUS --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-gray-300 font-medium">Device Status</span>
                    </label>
                    <div class="flex items-center gap-6 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="online"
                                   class="radio radio-success"
                                   {{ $device->status === 'online' ? 'checked' : '' }}>
                            <span class="text-green-400 font-medium">Online</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="offline"
                                   class="radio radio-error"
                                   {{ $device->status === 'offline' ? 'checked' : '' }}>
                            <span class="text-gray-400 font-medium">Offline</span>
                        </label>
                    </div>
                </div>

                {{-- ⏱ INFO SECTION --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <div class="p-4 bg-base-200 rounded-lg border border-base-300">
                        <p class="text-sm text-gray-400 mb-1 flex items-center gap-2">
                            <i class="bi bi-clock-history"></i> Last Seen
                        </p>
                        <p class="text-white font-medium">
                            {{ $device->last_seen ? $device->last_seen->diffForHumans() : 'Never' }}
                        </p>
                    </div>

                    <div class="p-4 bg-base-200 rounded-lg border border-base-300">
                        <p class="text-sm text-gray-400 mb-1 flex items-center gap-2">
                            <i class="bi bi-calendar-check"></i> Registered At
                        </p>
                        <p class="text-white font-medium">
                            {{ $device->registered_at ? $device->registered_at->format('d M Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline btn-accent gap-2">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary gap-2">
                        <i class="bi bi-save"></i> Update Device
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Register New Device')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-cpu text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Register New Device</h3>
            </div>

            <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline btn-accent gap-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="card bg-base-300 border border-base-200 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="card-body space-y-6">

                <form action="{{ route('dashboard.devices.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- 🏨 ASSIGN HOTEL (Super Admin Only) --}}
                    @if (Auth::user()->isSuperAdmin())
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-gray-300 font-medium">Assign to Hotel <span
                                        class="text-error">*</span></span>
                            </label>
                            <div class="relative">
                                <i class="bi bi-building text-info absolute left-3 top-3.5 text-lg"></i>
                                <select name="hotel_id" id="hotelSelect"
                                    class="select select-bordered w-full bg-base-200 text-white pl-10 focus:outline-none focus:ring-2 focus:ring-info"
                                    required>
                                    <option value="">-- Choose Hotel --</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    {{-- 🛏 LINKED ROOM --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Linked Room</span>
                        </label>
                        <div class="relative">
                            <i class="bi bi-door-open text-info absolute left-3 top-3.5 text-lg"></i>
                            <select name="room_id" id="roomSelect"
                                class="select select-bordered w-full bg-base-200 text-white pl-10 focus:outline-none focus:ring-2 focus:ring-info">
                                <option value="">-- Select Room --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" data-hotel="{{ $room->hotel_id }}">
                                        Nomor Kamar {{ $room->room_number }}
                                        @if ($room->hotel)
                                            — {{ $room->hotel->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('room_id')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- 🔌 DEVICE ID --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">
                                Device ID <span class="text-error">*</span>
                            </span>
                        </label>
                        <input type="text" name="device_id" placeholder="Enter unique device ID"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" required />
                        @error('device_id')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- ⚙️ FIRMWARE VERSION --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Firmware Version</span>
                        </label>
                        <input type="text" name="firmware_version" placeholder="e.g., v1.0.3"
                            class="input input-bordered w-full bg-base-200 text-white placeholder-gray-400" />
                        @error('firmware_version')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- 🌐 DEVICE STATUS --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-gray-300 font-medium">Device Status</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="online" class="radio radio-success"
                                    {{ old('status') === 'online' ? 'checked' : '' }}>
                                <span class="text-gray-300">Online</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="offline" class="radio radio-error"
                                    {{ old('status', 'offline') === 'offline' ? 'checked' : '' }}>
                                <span class="text-gray-300">Offline</span>
                            </label>
                        </div>
                        @error('status')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline btn-accent gap-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary gap-2">
                            <i class="bi bi-save"></i> Save Device
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- 🔁 FILTER ROOMS BY HOTEL --}}
    @if (Auth::user()->isSuperAdmin())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const hotelSelect = document.getElementById('hotelSelect');
                    const roomSelect = document.getElementById('roomSelect');
                    const allOptions = Array.from(roomSelect.options).filter(opt => opt.value !== "");

                    hotelSelect.addEventListener('change', () => {
                        const selectedHotel = hotelSelect.value;
                        roomSelect.innerHTML = '<option value="">-- Select Room --</option>';

                        if (!selectedHotel) {
                            allOptions.forEach(opt => roomSelect.appendChild(opt));
                            return;
                        }

                        allOptions.forEach(opt => {
                            if (opt.dataset.hotel === selectedHotel) {
                                roomSelect.appendChild(opt);
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endif
@endsection

@extends('layouts.app')
@section('title', 'Edit Device')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Device
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.devices.update', $device->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Device ID</label>
                    <input type="text" class="form-control" value="{{ $device->device_id }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Firmware Version</label>
                    <input type="text" name="firmware_version" class="form-control" value="{{ $device->firmware_version }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Linked Room</label>
                    <select name="room_id" class="form-select">
                        <option value="">-- Not Linked --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $device->room_id == $room->id ? 'selected' : '' }}>
                                {{ $room->room_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

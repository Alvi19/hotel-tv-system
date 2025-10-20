@extends('layouts.app')
@section('title', 'Register Device')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-plus-circle"></i> Register New Device
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.devices.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Device ID</label>
                    <input type="text" name="device_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Firmware Version</label>
                    <input type="text" name="firmware_version" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Linked Room</label>
                    <select name="room_id" class="form-select">
                        <option value="">-- Select Room --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.devices.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button class="btn btn-success"><i class="bi bi-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

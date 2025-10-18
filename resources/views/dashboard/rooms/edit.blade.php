@extends('layouts.app')
@section('title', 'Edit Room')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mb-4 fw-semibold text-white">Edit Room</h3>

    <div class="card glass-card p-4">
        <form action="{{ route('dashboard.rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Room Number</label>
                <input type="text"
                       name="room_number"
                       value="{{ $room->room_number }}"
                       class="form-control glass-input"
                       placeholder="Enter room number"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-light">Status</label>
                <select name="status" class="form-select glass-input text-white">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard.rooms.index') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="bi bi-check2-circle me-1"></i> Update Room
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .glass-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        color: #e2e8f0;
    }

    .glass-input {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        color: #f8fafc;
        transition: 0.3s ease;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 2px rgba(99,102,241,0.4);
        color: #fff;
    }

    .glass-input::placeholder {
        color: rgba(255,255,255,0.6);
    }

    select.glass-input option {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    .btn-gradient {
        background: linear-gradient(90deg, #6366f1, #38bdf8);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 12px rgba(99,102,241,0.4);
    }

    .btn-outline-light {
        border-color: rgba(255,255,255,0.3);
        color: #e2e8f0;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }

    h3 {
        color: #f8fafc;
    }

    label {
        color: #cbd5e1;
    }
</style>
@endpush
@endsection

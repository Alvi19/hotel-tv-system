@extends('layouts.app')
@section('title', 'Rooms')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold text-white">Room Management</h3>
        <a href="{{ route('dashboard.rooms.create') }}" class="btn btn-gradient px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Room
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-alert">{{ session('success') }}</div>
    @endif

    @if($rooms->isEmpty())
        <div class="alert alert-info text-center glass-alert">
            No rooms found. Start by adding one.
        </div>
    @else
        <div class="row g-4">
            @foreach($rooms as $room)
                <div class="col-md-4 col-lg-3">
                    <div class="card room-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-semibold text-white">
                                    <i class="bi bi-door-open me-1 text-info"></i> {{ $room->room_number }}
                                </h5>
                                <span class="badge status-badge
                                    @if($room->status == 'available') bg-available
                                    @elseif($room->status == 'occupied') bg-occupied
                                    @else bg-maintenance @endif">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>

                            <p class="text-muted small mb-2">
                                @if($room->guest_name)
                                    <strong class="text-white"><i class="bi bi-person text-gray-50"></i> {{ $room->guest_name }}</strong>
                                @else
                                    <em class="text-secondary">No guest</em>
                                @endif
                            </p>

                            <p class="room-time small mb-3">
                                <span class="label"> <i class="bi bi-clock text-info"></i> Check-in:</span>
                                <span class="value">{{ $room->checkin ? $room->checkin->format('d M Y H:i') : '-' }}</span><br>

                                <span class="label"> <i class=" bi bi-box-arrow-right"></i> Checkout:</span>
                                <span class="value">{{ $room->checkout ? $room->checkout->format('d M Y H:i') : '-' }}</span>
                            </p>


                            <div class="d-flex justify-content-between align-items-center gap-3 mt-3 mb-2">
                                <div class="btn-group d-flex gap-2">
                                    <a href="{{ route('dashboard.rooms.edit', $room->id) }}" class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('dashboard.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Delete this room?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>

                                @if($room->status === 'available')
                                    <form action="{{ route('dashboard.rooms.checkin', $room->id) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        <input type="text" name="guest_name" class="form-control form-control-sm glass-input" placeholder="Guest name" required>
                                        <button class="btn btn-success btn-sm"><i class="bi bi-person-plus"></i></button>
                                    </form>
                                @elseif($room->status === 'occupied')
                                    <form action="{{ route('dashboard.rooms.checkout', $room->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary btn-sm">
                                            <i class="bi bi-box-arrow-right"></i> Checkout
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    .glass-input {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        color: #e2e8f0;
    }
    .glass-input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .room-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        transition: all 0.3s ease;
        color: #e2e8f0;
    }

    .room-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 6px;
        text-transform: capitalize;
    }

    .bg-available {
        background: linear-gradient(90deg, #10b981, #34d399);
        color: #fff;
    }

    .bg-occupied {
        background: linear-gradient(90deg, #facc15, #fbbf24);
        color: #000;
    }

    .bg-maintenance {
        background: linear-gradient(90deg, #9ca3af, #6b7280);
        color: #fff;
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
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }

    .glass-alert {
        background: rgba(56,189,248,0.15);
        border: 1px solid rgba(56,189,248,0.3);
        color: #e0f2fe;
        border-radius: 10px;
        backdrop-filter: blur(12px);
    }

    h3 {
        color: #f8fafc;
    }
</style>
@endpush
@endsection

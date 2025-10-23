@extends('layouts.app')
@section('title', 'Devices')

@section('content')
<div class="container-fluid">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-white">⚡ Devices (STB)</h3>
        <a href="{{ route('dashboard.devices.create') }}" class="btn btn-primary gap-2">
            <i class="bi bi-plus-circle"></i> Register Device
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-white">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Device ID</th>
                    <th>Room</th>
                    <th>Firmware</th>
                    <th>Status</th>
                    <th>Last Seen</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($devices as $device)
                    <tr>
                        {{-- Index --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- Device Info --}}
                        <td class="fw-semibold">{{ $device->device_id }}</td>
                        <td>{{ $device->room?->room_number ?? '-' }}</td>
                        <td>{{ $device->firmware_version ?? '-' }}</td>

                        {{-- STATUS --}}
                        <td>
                            @if ($device->status === 'online')
                                <span class="badge bg-success d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-circle-fill text-success" style="font-size: 0.6rem"></i> Online
                                </span>
                            @elseif ($device->status === 'offline')
                                <span class="badge bg-secondary d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-circle-fill text-secondary" style="font-size: 0.6rem"></i> Offline
                                </span>
                            @else
                                <span class="badge bg-danger">Unknown</span>
                            @endif
                        </td>

                        {{-- LAST SEEN --}}
                        <td>
                            @if ($device->last_seen)
                                <span title="{{ $device->last_seen->format('d M Y H:i') }}">
                                    {{ $device->last_seen->diffForHumans() }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td>
                            <a href="{{ route('dashboard.devices.edit', $device->id) }}" class="btn btn-sm btn-warning text-dark me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('dashboard.devices.destroy', $device->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this device?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            No devices found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

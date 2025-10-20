@extends('layouts.app')
@section('title', 'Devices')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">⚡ Devices (STB)</h3>
        <a href="{{ route('dashboard.devices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Register Device
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $device->device_id }}</td>
                        <td>{{ $device->room?->room_number ?? '-' }}</td>
                        <td>{{ $device->firmware_version ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($device->status == 'online') bg-success
                                @elseif($device->status == 'offline') bg-secondary
                                @else bg-danger @endif">
                                {{ ucfirst($device->status) }}
                            </span>
                        </td>
                        <td>{{ $device->last_seen ? $device->last_seen->format('d M Y H:i') : '-' }}</td>
                        <td>
                            <a href="{{ route('dashboard.devices.edit', $device->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('dashboard.devices.destroy', $device->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this device?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No devices found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

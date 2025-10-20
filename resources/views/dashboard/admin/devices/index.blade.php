@extends('layouts.app')
@section('title', 'All Devices')
@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4">All Devices (Admin View)</h3>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Hotel</th>
                    <th>Device ID</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th>Firmware</th>
                    <th>Last Seen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devices as $device)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $device->hotel->name ?? '-' }}</td>
                        <td>{{ $device->device_id }}</td>
                        <td>{{ $device->room?->room_number ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($device->status == 'online') bg-success
                                @elseif($device->status == 'offline') bg-secondary
                                @else bg-danger @endif">
                                {{ ucfirst($device->status) }}
                            </span>
                        </td>
                        <td>{{ $device->firmware_version ?? '-' }}</td>
                        <td>{{ $device->last_seen ? $device->last_seen->format('d M Y H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No devices found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Rooms')
@section('content')
<div class="container">
    <h3>Room Management</h3>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Room Number</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Check-In</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $room->room_number }}</td>
                <td>{{ $room->guest_name ?? '-' }}</td>
                <td>{{ ucfirst($room->status) }}</td>
                <td>{{ $room->checkin ? $room->checkin->format('Y-m-d H:i') : '-' }}</td>
                <td>
                    @if($room->status == 'available')
                    <form method="POST" action="/dashboard/rooms/{{ $room->id }}/checkin" class="d-inline">
                        @csrf
                        <input type="text" name="guest_name" placeholder="Guest name" class="form-control form-control-sm d-inline w-auto">
                        <button class="btn btn-sm btn-success">Check-in</button>
                    </form>
                    @else
                    <form method="POST" action="/dashboard/rooms/{{ $room->id }}/checkout" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-warning">Checkout</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Welcome, {{ auth()->user()->name }}</h3>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2>{{ $roomsCount }}</h2>
                <p>Total Rooms</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2>{{ $occupiedRooms }}</h2>
                <p>Occupied Rooms</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2>{{ $bannersCount }}</h2>
                <p>Active Banners</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h2>{{ $devicesOnline }}</h2>
                <p>Devices Online</p>
            </div>
        </div>
    </div>
</div>
@endsection

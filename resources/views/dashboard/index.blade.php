@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container mt-3">
    <h4>Welcome, {{ auth()->user()->username }}</h4>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm">
                <h2>{{ $roomsCount }}</h2>
                <p>Total Rooms</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm">
                <h2>{{ $devicesCount }}</h2>
                <p>Devices</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm">
                <h2>{{ $bannersCount }}</h2>
                <p>Banners</p>
            </div>
        </div>
    </div>
</div>
@endsection

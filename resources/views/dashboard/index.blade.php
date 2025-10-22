@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="p-6 space-y-10">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-bold text-white">
                Welcome back, {{ auth()->user()->name }} 👋
            </h3>
            <p class="text-gray-400 text-sm">
                {{ auth()->user()->role->display_name ?? ucfirst(auth()->user()->role->name ?? 'User') }}
            </p>
        </div>
        <span class="badge badge-primary badge-lg">
            {{ ucfirst(auth()->user()->role->scope ?? 'Hotel') }}
        </span>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-info text-4xl mb-2">
                <i class="bi bi-building"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $totalHotels ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Total Hotels</p>
        </div>

        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-warning text-4xl mb-2">
                <i class="bi bi-door-open"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $totalRooms ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Total Rooms</p>
        </div>

        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-success text-4xl mb-2">
                <i class="bi bi-person-check"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $occupiedRooms ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Occupied Rooms</p>
        </div>

        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-error text-4xl mb-2">
                <i class="bi bi-image"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $totalBanners ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Active Banners</p>
        </div>

        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-success text-4xl mb-2">
                <i class="bi bi-tv"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $devicesOnline ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Devices Online</p>
        </div>

        <div class="card glass text-center p-4 hover:scale-[1.02] transition-all duration-300">
            <div class="text-gray-400 text-4xl mb-2">
                <i class="bi bi-tv"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">{{ $devicesOffline ?? 0 }}</h2>
            <p class="text-gray-400 text-sm">Devices Offline</p>
        </div>
    </div>

    {{-- Super Admin View --}}
    @if(auth()->user()->isGlobalRole())
        <div class="mt-12">
            <h4 class="text-xl font-semibold mb-4 text-info flex items-center gap-2">
                <i class="bi bi-graph-up-arrow"></i> Hotel Overview
            </h4>
            <div class="card glass shadow-md">
                <div class="overflow-x-auto">
                    <table class="table w-full text-sm">
                        <thead>
                            <tr class="text-white bg-base-200">
                                <th>Hotel Name</th>
                                <th>Total Rooms</th>
                                <th>Occupied</th>
                                <th>Banners</th>
                                <th>Devices (Online)</th>
                                <th>Devices (Offline)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hotels as $hotel)
                                <tr class="hover:bg-base-200">
                                    <td class="font-semibold">{{ $hotel->name }}</td>
                                    <td>{{ $hotel->rooms_count }}</td>
                                    <td>{{ \App\Models\Room::where('hotel_id', $hotel->id)->where('status', 'occupied')->count() }}</td>
                                    <td>{{ \App\Models\Banner::where('hotel_id', $hotel->id)->where('is_active', true)->count() }}</td>
                                    <td>{{ \App\Models\Device::where('hotel_id', $hotel->id)->where('status', 'online')->count() }}</td>
                                    <td>{{ \App\Models\Device::where('hotel_id', $hotel->id)->where('status', 'offline')->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        {{-- Hotel Staff/Admin View --}}
        <div class="mt-12">
            <h4 class="text-xl font-semibold mb-4 text-info flex items-center gap-2">
                <i class="bi bi-building"></i> {{ $hotel->name ?? 'Hotel Information' }}
            </h4>
            <div class="card glass p-6 text-gray-300 space-y-1">
                <p><strong>Address:</strong> {{ $hotel->address ?? '-' }}</p>
                <p><strong>Email:</strong> {{ $hotel->email ?? '-' }}</p>
                <p><strong>Phone:</strong> {{ $hotel->phone ?? '-' }}</p>
                <p><strong>Website:</strong> {{ $hotel->website ?? '-' }}</p>
            </div>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')
@section('title', 'Room Management')

@section('content')
<div class="p-6 h-[calc(100vh-100px)] overflow-y-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
            <i class="bi bi-door-open text-info"></i> Room Management
        </h3>

        @canAccess('rooms', 'create')
            <a href="{{ route('dashboard.rooms.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Add Room
            </a>
        @endcanAccess
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('dashboard.rooms.index') }}" class="mb-8">
        <div class="flex flex-wrap gap-3 items-center">
            <select name="category_id" onchange="this.form.submit()" class="select select-bordered select-sm w-64 bg-base-200 text-white">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($categoryFilter == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @if ($categoryFilter)
                <a href="{{ route('dashboard.rooms.index') }}" class="btn btn-outline btn-accent btn-sm">
                    <i class="bi bi-x-circle"></i> Clear Filter
                </a>
            @endif
        </div>
    </form>

    {{-- Data --}}
    @if ($rooms->isEmpty())
        <div class="alert alert-info text-center">No rooms found for the selected filter.</div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($rooms as $room)
                <div class="card bg-base-200/60 shadow-md backdrop-blur-sm border border-base-300 hover:border-info transition">
                    <div class="card-body text-white p-5">

                        {{-- Header Room --}}
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="card-title text-lg text-info">
                                <i class="bi bi-door-open me-1"></i> {{ $room->room_number }}
                            </h2>
                            <span class="badge
                                @if ($room->status == 'available') badge-success
                                @elseif($room->status == 'occupied') badge-warning
                                @else badge-error @endif">
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>

                        {{-- Category --}}
                        @if ($room->category)
                            <p class="text-sm text-info mb-2">
                                <i class="bi bi-tags"></i> {{ $room->category->name }}
                            </p>
                        @endif

                        {{-- Hotel info (super admin) --}}
                        @if (Auth::user()->isSuperAdmin())
                            <p class="text-sm text-gray-400 mb-2">
                                <i class="bi bi-building"></i> {{ $room->hotel->name ?? '-' }}
                            </p>
                        @endif

                        {{-- Guest --}}
                        <p class="text-sm mb-2">
                            @if ($room->guest_name)
                                <span class="text-white font-semibold">
                                    <i class="bi bi-person"></i> {{ $room->guest_name }}
                                </span>
                            @else
                                <em class="text-gray-500">No guest</em>
                            @endif
                        </p>

                        {{-- Check-in/out --}}
                        <div class="text-sm space-y-1 mb-3">
                            <p>
                                <i class="bi bi-clock text-info"></i>
                                Check-in:
                                <span class="text-gray-300">
                                    {{ $room->checkin ? $room->checkin->format('d M Y H:i') : '-' }}
                                </span>
                            </p>
                            <p>
                                <i class="bi bi-box-arrow-right text-info"></i>
                                Checkout:
                                <span class="text-gray-300">
                                    {{ $room->checkout ? $room->checkout->format('d M Y H:i') : '-' }}
                                </span>
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex gap-2">
                                {{-- Edit --}}
                                @canAccess('rooms', 'edit')
                                    <a href="{{ route('dashboard.rooms.edit', $room->id) }}"
                                       class="btn btn-sm btn-outline btn-info" title="Edit Room">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endcanAccess

                                {{-- Delete --}}
                                @canAccess('rooms', 'delete')
                                    <form action="{{ route('dashboard.rooms.destroy', $room->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this room?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline btn-error" title="Delete Room">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcanAccess
                            </div>

                            {{-- Checkin / Checkout --}}
                            @if ($room->status === 'available')
                                @canAccess('rooms', 'checkin')
                                    <form action="{{ route('dashboard.rooms.checkin', $room->id) }}" method="POST"
                                          class="flex gap-2">
                                        @csrf
                                        <input type="text" name="guest_name"
                                               class="input input-bordered input-sm w-28"
                                               placeholder="Guest" required>
                                        <button class="btn btn-success btn-sm" title="Check-in">
                                            <i class="bi bi-person-plus"></i>
                                        </button>
                                    </form>
                                @endcanAccess
                            @elseif($room->status === 'occupied')
                                @canAccess('rooms', 'checkout')
                                    <form action="{{ route('dashboard.rooms.checkout', $room->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-secondary btn-sm" title="Checkout Guest">
                                            <i class="bi bi-box-arrow-right"></i>
                                        </button>
                                    </form>
                                @endcanAccess
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

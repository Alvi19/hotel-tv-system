@extends('layouts.app')

@section('title', 'Banner Promotions')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-r from-primary to-info rounded-xl">
                    <i class="bi bi-megaphone text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white">Banner Promotions</h3>

            </div>

            <a href="{{ route('dashboard.banners.create') }}" class="btn btn-primary gap-2">
                <i class="bi bi-plus-circle"></i> Add Banner
            </a>
        </div>

        {{-- Grid Banners --}}
        @if ($banners->isEmpty())
            <div class="alert alert-info shadow-lg bg-info/20 border border-info/30 text-white mt-6">
                <div class="flex items-center gap-2">
                    <i class="bi bi-info-circle text-info text-xl"></i>
                    <span>No banners found.</span>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                @foreach ($banners as $banner)
                    <div
                        class="card bg-base-300 border border-base-200 shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                        {{-- Banner Image --}}
                        @if ($banner->image_url)
                            <figure class="relative h-40 overflow-hidden rounded-t-xl">
                                <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}"
                                    class="object-cover w-full h-full transform hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 right-2">
                                    @if ($banner->is_active)
                                        <div class="badge badge-success px-3 py-2 text-xs">
                                            <i class="bi bi-check-circle me-1"></i> Active
                                        </div>
                                    @else
                                        <div class="badge badge-error px-3 py-2 text-xs">
                                            <i class="bi bi-x-circle me-1"></i> Inactive
                                        </div>
                                    @endif
                                </div>
                            </figure>
                        @else
                            <figure
                                class="flex items-center justify-center h-40 bg-base-200 text-gray-500 italic rounded-t-xl">
                                No image available
                            </figure>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body p-5 space-y-3">
                            <h2 class="card-title text-lg text-white">
                                <i class="bi bi-flag-fill text-info"></i>
                                <span>{{ $banner->title }}</span>
                            </h2>

                            @if (Auth::user()->isSuperAdmin())
                                <p class="text-sm text-gray-400">
                                    <i class="bi bi-building"></i> {{ $banner->hotel->name ?? '-' }}
                                </p>
                            @endif

                            <p class="text-sm text-gray-400 line-clamp-3">
                                {{ $banner->description ?? 'No description provided.' }}
                            </p>

                            {{-- Active Dates --}}
                            <div class="text-sm text-gray-500">
                                <span>{{ $banner->active_from ?? '-' }}</span>
                                <span class="text-gray-400"> — </span>
                                <span>{{ $banner->active_to ?? '-' }}</span>
                            </div>

                            {{-- Actions --}}
                            <div class="flex justify-between pt-3 border-t border-base-200">
                                <a href="{{ route('dashboard.banners.edit', $banner->id) }}"
                                    class="btn btn-sm btn-warning text-black flex items-center gap-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('dashboard.banners.destroy', $banner->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this banner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error text-white flex items-center gap-1">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

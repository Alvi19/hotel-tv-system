@extends('layouts.app')

@section('title', 'Hotel Details')

@section('content')
<div class="p-0 h-[calc(100vh-100px)] overflow-y-auto bg-gradient-to-b from-base-200/30 to-base-300">

    {{-- 🏨 HEADER SECTION (Video overlay on background image) --}}
    <div class="relative w-full h-[300px] md:h-[400px] overflow-hidden rounded-b-2xl shadow-lg">

        {{-- Background Image --}}
        @if($hotel->background_image_url)
            <img src="{{ asset('storage/' . $hotel->background_image_url) }}"
                 alt="Background"
                 class="object-cover w-full h-full brightness-75">
        @else
            <div class="flex items-center justify-center h-full bg-base-200 text-gray-500 italic">
                No Background Image
            </div>
        @endif

        {{-- Video Overlay --}}
        @if($hotel->video_url)
            <video autoplay muted loop playsinline
                   class="absolute inset-0 w-full h-full object-cover brightness-[0.7] opacity-70 hover:opacity-90 transition-all duration-700">
                <source src="{{ asset('storage/' . $hotel->video_url) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-t from-base-300/90 via-base-300/30 to-transparent"></div>

        {{-- Hotel Info Overlay --}}
        <div class="absolute bottom-6 left-6 right-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white flex items-center gap-3 drop-shadow-lg">
                    <i class="bi bi-building text-info"></i> {{ $hotel->name }}
                </h1>
                <p class="text-gray-200 text-sm mt-1 max-w-2xl leading-relaxed drop-shadow">
                    {{ $hotel->description ?: 'No description available.' }}
                </p>
            </div>

            @if($hotel->website)
                <a href="{{ $hotel->website }}" target="_blank"
                   class="btn btn-info btn-sm gap-2 hover:scale-105 transition-all duration-300 shadow-lg">
                    <i class="bi bi-globe"></i> Visit Website
                </a>
            @endif
        </div>
    </div>

    {{-- 🧾 MAIN CONTENT SECTION --}}
    <div class="p-6 space-y-8">

        {{-- 🎯 Running Text --}}
        @if($hotel->text_running)
            <div class="bg-gradient-to-r from-info/10 to-transparent border border-info/20 rounded-lg p-4 shadow-md">
                <p class="text-sm text-info italic">
                    <i class="bi bi-megaphone-fill"></i> “{{ $hotel->text_running }}”
                </p>
            </div>
        @endif

        {{-- 💡 Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- LEFT - Hotel Information (with Logo) --}}
            <div class="card bg-base-300 border border-base-200 shadow-md hover:shadow-xl transition-all duration-300">
                <div class="card-body space-y-5">
                    <div class="flex items-center justify-between border-b border-base-200 pb-2">
                        <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                            <i class="bi bi-info-circle text-info"></i> Information
                        </h3>
                    </div>

                    {{-- 🪪 Hotel Logo --}}
                    <div class="flex flex-col items-center space-y-2">
                        <p class="text-sm text-gray-400">Hotel Logo</p>
                        @if($hotel->logo_url)
                            <img src="{{ asset('storage/' . $hotel->logo_url) }}" alt="Logo"
                                 class="rounded-xl shadow-lg w-32 h-32 object-cover border border-base-200 hover:scale-105 transition-transform duration-300">
                        @else
                            <p class="text-gray-500 italic">No logo uploaded</p>
                        @endif
                    </div>

                    {{-- 🧾 Information Fields --}}
                    <div class="grid grid-cols-2 gap-y-3 text-sm pt-2">
                        <p class="text-gray-400">📍 Address:</p>
                        <p class="text-white font-medium">{{ $hotel->address ?: '-' }}</p>

                        <p class="text-gray-400">📞 Phone:</p>
                        <p class="text-white font-medium">{{ $hotel->phone ?: '-' }}</p>

                        <p class="text-gray-400">📧 Email:</p>
                        <p class="text-white font-medium">{{ $hotel->email ?: '-' }}</p>

                        <p class="text-gray-400">🌐 Website:</p>
                        <p>
                            @if($hotel->website)
                                <a href="{{ $hotel->website }}" target="_blank" class="text-info hover:underline">
                                    {{ $hotel->website }}
                                </a>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </p>

                        <p class="text-gray-400">📅 Created At:</p>
                        <p class="text-white font-medium">
                            {{ $hotel->created_at ? $hotel->created_at->format('d M Y, H:i') : '-' }}
                        </p>

                        <p class="text-gray-400">🔄 Updated At:</p>
                        <p class="text-white font-medium">
                            {{ $hotel->updated_at ? $hotel->updated_at->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT - Media Section (Background Image only) --}}
            <div class="card bg-base-300 border border-base-200 shadow-md hover:shadow-xl transition-all duration-300">
                <div class="card-body space-y-5">
                    <div class="flex items-center justify-between border-b border-base-200 pb-2">
                        <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                            <i class="bi bi-image text-info"></i> Media
                        </h3>
                    </div>

                    {{-- 🖼️ Background Image --}}
                    <div class="space-y-2">
                        <p class="text-sm text-gray-400">Background Image</p>
                        @if($hotel->background_image_url)
                            <img src="{{ asset('storage/' . $hotel->background_image_url) }}"
                                 alt="Background Image"
                                 class="rounded-xl shadow-lg w-full h-48 object-cover border border-base-200 hover:scale-[1.02] transition-transform duration-300">
                        @else
                            <p class="text-gray-500 italic">No background image uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔙 Back Button --}}
        <div class="flex justify-end pt-4">
            <a href="{{ route('dashboard.hotels.index') }}"
               class="btn btn-outline btn-accent gap-2 hover:scale-105 transition-all duration-200">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection

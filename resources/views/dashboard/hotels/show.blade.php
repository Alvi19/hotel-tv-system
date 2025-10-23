@extends('layouts.app')

@section('title', 'Hotel Details')

@section('content')
    <div class="p-0 h-[calc(100vh-100px)] overflow-y-auto bg-gradient-to-b from-base-200/30 to-base-300">

        <div class="relative w-full h-[480px] md:h-[550px] overflow-hidden shadow-lg">

            @if ($hotel->video_url)
                <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover brightness-[0.7]">
                    <source src="{{ asset('storage/' . $hotel->video_url) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @elseif($hotel->background_image_url)
                <img src="{{ asset('storage/' . $hotel->background_image_url) }}" alt="Hotel Background"
                    class="absolute inset-0 w-full h-full object-cover brightness-75">
            @else
                <div class="flex items-center justify-center h-full bg-base-200 text-gray-500 italic">
                    No Background Media
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-base-300/60 via-base-300/20 to-transparent"></div>

            @if ($hotel->logo_url)
                <div class="absolute top-6 left-1/2 -translate-x-1/2 z-30">
                    <img src="{{ asset('storage/' . $hotel->logo_url) }}" alt="Hotel Logo"
                        class="w-20 h-20 md:w-24 md:h-24 object-contain rounded-xl border-2 border-base-100/70
                            drop-shadow-[0_4px_10px_rgba(0,0,0,0.6)] hover:scale-105 transition-transform duration-500">
                </div>
            @endif

            @if ($hotel->text_running)
                <div class="absolute bottom-0 w-full py-2 overflow-hidden z-30">
                    <div class="whitespace-nowrap animate-marquee">
                        <p class="inline-block text-info italic font-medium text-sm md:text-base tracking-wide">
                            <i class="bi bi-megaphone-fill text-info mr-2"></i>
                            “{{ $hotel->text_running }}”
                            <span class="mx-6 text-gray-400">•</span>
                            <i class="bi bi-megaphone-fill text-info mr-2"></i>
                            “{{ $hotel->text_running }}”
                            <span class="mx-6 text-gray-400">•</span>
                            <i class="bi bi-megaphone-fill text-info mr-2"></i>
                            “{{ $hotel->text_running }}”
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex justify-center relative z-20 mt-10 md:mt-14">
            <div
                class="bg-base-300/70 backdrop-blur-md border border-base-200 rounded-2xl shadow-2xl
                w-[92%] md:w-[70%] text-center p-6 md:p-8 transition-all duration-500 hover:shadow-[0_0_30px_rgba(0,255,255,0.15)]">
                <h1 class="text-3xl md:text-4xl font-bold text-white flex justify-center items-center gap-2 mb-3">
                    <i class="bi bi-building text-info"></i> {{ $hotel->name }}
                </h1>
                <p class="text-gray-200 text-sm md:text-base mb-4 leading-relaxed">
                    {{ $hotel->description ?: 'No description available.' }}
                </p>
                @if ($hotel->website)
                    <a href="{{ $hotel->website }}" target="_blank"
                        class="btn btn-info btn-sm gap-2 hover:scale-105 transition-transform duration-300 shadow-md">
                        <i class="bi bi-globe"></i> Visit Website
                    </a>
                @endif
            </div>
        </div>

        <div class="px-6 md:px-16 space-y-10 mt-12">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="card bg-base-300 border border-base-200 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="card-body space-y-4">
                        <div class="flex items-center gap-2 border-b border-base-200 pb-2">
                            <i class="bi bi-info-circle text-info text-xl"></i>
                            <h3 class="text-xl font-semibold text-white">Hotel Information</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-y-3 text-sm pt-2">
                            <p class="text-gray-400"><i class="bi bi-geo-alt text-red-600 text-xl"></i> Address:</p>
                            <p class="text-white font-medium">{{ $hotel->address ?: '-' }}</p>

                            <p class="text-gray-400"><i class="bi bi-telephone text-info text-xl"></i> Phone:</p>
                            <p class="text-white font-medium">{{ $hotel->phone ?: '-' }}</p>

                            <p class="text-gray-400"><i class="bi bi-envelope text-white text-xl"></i> Email:</p>
                            <p class="text-white font-medium">{{ $hotel->email ?: '-' }}</p>

                            <p class="text-gray-400"><i class="bi bi-globe text-info text-xl"></i> Website:</p>
                            <p>
                                @if ($hotel->website)
                                    <a href="{{ $hotel->website }}" target="_blank" class="text-info hover:underline">
                                        {{ $hotel->website }}
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </p>

                            <p class="text-gray-400"><i class="bi bi-clock text-white text-xl"></i> Created At:</p>
                            <p class="text-white font-medium">
                                {{ $hotel->created_at ? $hotel->created_at->format('d M Y, H:i') : '-' }}
                            </p>

                            <p class="text-gray-400"><i class="bi bi-clock text-white text-xl"></i> Updated At:</p>
                            <p class="text-white font-medium">
                                {{ $hotel->updated_at ? $hotel->updated_at->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-300 border border-base-200 shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="card-body space-y-4">
                        <div class="flex items-center gap-2 border-b border-base-200 pb-2">
                            <i class="bi bi-image text-info text-xl"></i>
                            <h3 class="text-xl font-semibold text-white">Media Preview</h3>
                        </div>

                        @if ($hotel->background_image_url)
                            <img src="{{ asset('storage/' . $hotel->background_image_url) }}" alt="Background Image"
                                class="rounded-xl shadow-lg w-full h-56 object-cover border border-base-200 hover:scale-[1.02] transition-transform duration-300">
                        @else
                            <p class="text-gray-500 italic">No background image uploaded</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <a href="{{ route('dashboard.hotels.index') }}"
                    class="btn btn-outline btn-accent gap-2 hover:scale-105 transition-all duration-200">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
@endsection

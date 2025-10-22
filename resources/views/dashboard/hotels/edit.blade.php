@extends('layouts.app')
@section('title', 'Edit Hotel')

@section('content')
    <div class="p-6 h-[calc(100vh-100px)] overflow-y-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
                <i class="bi bi-pencil-square text-info"></i>
                Edit Hotel
            </h3>
            <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-outline btn-accent">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div>
                    <i class="bi bi-exclamation-triangle"></i>
                    <span><strong>There were some issues:</strong></span>
                </div>
                <ul class="list-disc list-inside ml-4 mt-2 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card --}}
        <div class="card bg-base-300 border border-base-200 shadow-xl">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.hotels.update', $hotel->id) }}"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Hotel Name --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Hotel Name <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $hotel->name) }}" required
                            class="input input-bordered w-full" />
                    </div>

                    {{-- Description --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Description</span>
                        </label>
                        <textarea name="description" rows="3" class="textarea textarea-bordered w-full">{{ old('description', $hotel->description) }}</textarea>
                    </div>
                    {{-- 🏃 Running Text --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Running Text</span>
                        </label>
                        <textarea name="text_running" rows="3" placeholder="e.g. Welcome to Grand Hotel! Enjoy your stay..."
                            class="textarea textarea-bordered w-full">{{ old('text_running', $hotel->text_running) }}</textarea>
                        <span class="text-sm text-gray-400 mt-1">*Displayed as scrolling text on the hotel display or
                            dashboard.</span>
                    </div>

                    {{-- Address / Phone / Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Address</span>
                            </label>
                            <input type="text" name="address" value="{{ old('address', $hotel->address) }}"
                                class="input input-bordered w-full" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Phone</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $hotel->phone) }}"
                                class="input input-bordered w-full" />
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Email</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $hotel->email) }}"
                                class="input input-bordered w-full" />
                        </div>
                    </div>

                    {{-- Website --}}
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Website</span>
                        </label>
                        <input type="url" name="website" value="{{ old('website', $hotel->website) }}"
                            class="input input-bordered w-full" />
                    </div>

                    <hr class="border-base-200">

                    {{-- Current Media + Uploads --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        {{-- Logo --}}
                        <div class="space-y-2">
                            <label class="label">
                                <span class="label-text font-medium">Current Logo</span>
                            </label>

                            @if ($hotel->logo_url)
                                <img src="{{ asset('storage/' . $hotel->logo_url) }}" alt="Logo"
                                    class="w-20 h-20 object-cover rounded shadow mb-2">
                            @else
                                <p class="text-sm text-muted">No logo uploaded</p>
                            @endif

                            <input type="file" name="logo_url" accept="image/*"
                                class="file-input file-input-bordered w-full" />
                        </div>

                        {{-- Background --}}
                        <div class="space-y-2">
                            <label class="label">
                                <span class="label-text font-medium">Background Image</span>
                            </label>

                            @if ($hotel->background_image_url)
                                <img src="{{ asset('storage/' . $hotel->background_image_url) }}" alt="Background"
                                    class="w-28 h-20 object-cover rounded shadow mb-2">
                            @else
                                <p class="text-sm text-muted">No background uploaded</p>
                            @endif

                            <input type="file" name="background_image_url" accept="image/*"
                                class="file-input file-input-bordered w-full" />
                        </div>

                        {{-- Video --}}
                        <div class="space-y-2">
                            <label class="label">
                                <span class="label-text font-medium">Intro Video</span>
                            </label>

                            @if ($hotel->video_url)
                                <video controls class="w-full rounded shadow mb-2" style="max-height:120px;">
                                    <source src="{{ asset('storage/' . $hotel->video_url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <p class="text-sm text-muted">No video uploaded</p>
                            @endif

                            <input type="file" name="video_url" accept="video/*"
                                class="file-input file-input-bordered w-full" />
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-outline btn-accent">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update Hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

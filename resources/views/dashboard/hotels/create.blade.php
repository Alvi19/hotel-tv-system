@extends('layouts.app')

@section('title', 'Add New Hotel')

@section('content')
<div class="p-6 h-[calc(100vh-100px)] overflow-y-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h3 class="text-2xl font-semibold text-white flex items-center gap-2">
            <i class="bi bi-building-add text-info"></i>
            Add New Hotel
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
                <span>There were some issues:</span>
            </div>
            <ul class="list-disc list-inside ml-4 mt-2 text-sm">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card bg-base-300 border border-base-200 shadow-xl">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.hotels.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Basic Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Hotel Name <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="name" placeholder="e.g. Grand Hotel" required class="input input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Email</span>
                        </label>
                        <input type="email" name="email" placeholder="e.g. contact@hotel.com" class="input input-bordered w-full" />
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description" rows="3" placeholder="Brief description about the hotel" class="textarea textarea-bordered w-full"></textarea>
                </div>

                {{-- 🏃 Running Text --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium">Running Text</span>
                    </label>
                    <textarea name="text_running" rows="2" placeholder="e.g. Welcome to Grand Hotel! Enjoy your stay..." class="textarea textarea-bordered w-full"></textarea>
                    <span class="text-sm text-gray-400 mt-1">*This text will be displayed as scrolling text on hotel screens or dashboard.</span>
                </div>

                {{-- Address & Contact --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Address</span>
                        </label>
                        <input type="text" name="address" placeholder="Hotel address" class="input input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Phone</span>
                        </label>
                        <input type="text" name="phone" placeholder="e.g. +62 21 1234567" class="input input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Website</span>
                        </label>
                        <input type="url" name="website" placeholder="https://hotel.com" class="input input-bordered w-full" />
                    </div>
                </div>

                <hr class="border-base-200">

                {{-- Uploads --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Upload Logo</span>
                        </label>
                        <input type="file" name="logo_url" accept="image/*" class="file-input file-input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Background Image</span>
                        </label>
                        <input type="file" name="background_image_url" accept="image/*" class="file-input file-input-bordered w-full" />
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-medium">Intro Video</span>
                        </label>
                        <input type="file" name="video_url" accept="video/*" class="file-input file-input-bordered w-full" />
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-outline btn-accent">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="bi bi-check-circle me-1"></i> Save Hotel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

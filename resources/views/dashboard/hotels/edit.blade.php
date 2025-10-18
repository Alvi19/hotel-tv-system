@extends('layouts.app')
@section('title', 'Edit Hotel')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mb-4 fw-semibold text-white">Edit Hotel Information</h3>

    <div class="card glass-card p-4">
        <form action="{{ route('dashboard.hotel.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Hotel Name</label>
                <input type="text" name="name" value="{{ $hotel->name }}" class="form-control glass-input" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Description</label>
                <textarea name="description" rows="3" class="form-control glass-input">{{ $hotel->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Address</label>
                <input type="text" name="address" value="{{ $hotel->address }}" class="form-control glass-input">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Phone</label>
                <input type="text" name="phone" value="{{ $hotel->phone }}" class="form-control glass-input">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Email</label>
                <input type="email" name="email" value="{{ $hotel->email }}" class="form-control glass-input">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Website</label>
                <input type="url" name="website" value="{{ $hotel->website }}" class="form-control glass-input">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Logo (optional)</label><br>
                @if($hotel->logo_url)
                    <div class="preview-box mb-3">
                        <img src="{{ asset('storage/'.$hotel->logo_url) }}" alt="logo" class="img-preview">
                    </div>
                @endif
                <input type="file" name="logo_url" class="form-control glass-input">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-light">Background Image (optional)</label><br>
                @if($hotel->background_image_url)
                    <div class="preview-box mb-3">
                        <img src="{{ asset('storage/'.$hotel->background_image_url) }}" alt="bg" class="img-preview">
                    </div>
                @endif
                <input type="file" name="background_image_url" class="form-control glass-input">
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard.hotels.index') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button class="btn btn-gradient px-4">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .glass-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        color: #e2e8f0;
    }

    .glass-input {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        color: #f8fafc;
        transition: 0.3s ease;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 2px rgba(99,102,241,0.4);
        color: #fff;
    }

    .glass-input::placeholder {
        color: rgba(255,255,255,0.6);
    }

    .preview-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        display: inline-block;
        padding: 6px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    }

    .img-preview {
        width: 100px;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }

    .btn-gradient {
        background: linear-gradient(90deg, #6366f1, #38bdf8);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 12px rgba(99,102,241,0.4);
    }

    .btn-outline-light {
        border-color: rgba(255,255,255,0.3);
        color: #e2e8f0;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }

    h3 {
        color: #f8fafc;
    }

    label {
        color: #cbd5e1;
    }
</style>
@endpush
@endsection

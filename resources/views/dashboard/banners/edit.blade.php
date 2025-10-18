@extends('layouts.app')
@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mb-4 fw-semibold text-white">Edit Banner</h3>
    <div class="card glass-card p-4">
        <form action="{{ route('dashboard.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Title</label>
                <input type="text"
                       name="title"
                       value="{{ $banner->title }}"
                       class="form-control glass-input"
                       placeholder="Enter banner title"
                       required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Description</label>
                <textarea name="description" class="form-control glass-input" rows="3" placeholder="Enter description...">{{ $banner->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-light">Banner Image</label><br>
                @if($banner->image_url)
                    <div class="preview-box mb-3">
                        <img src="{{ asset('storage/' . $banner->image_url) }}"
                             alt="Current Image"
                             class="img-preview">
                    </div>
                @endif
                <input type="file" name="image_url" class="form-control glass-input" accept="image/*">
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-light">Active From</label>
                    <input type="date"
                           name="active_from"
                           value="{{ $banner->active_from }}"
                           class="form-control glass-input">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-light">Active To</label>
                    <input type="date"
                           name="active_to"
                           value="{{ $banner->active_to }}"
                           class="form-control glass-input">
                </div>
            </div>
            <div class="form-check mb-4">
                <input type="checkbox"
                       class="form-check-input"
                       id="is_active"
                       name="is_active"
                       value="1"
                       {{ $banner->is_active ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label text-light">Active</label>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard.banners.index') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="bi bi-check2-circle me-1"></i> Update Banner
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

    select.glass-input option {
        background-color: #1e293b;
        color: #e2e8f0;
    }

    .preview-box {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 6px;
        display: inline-block;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .img-preview {
        width: 220px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: transform 0.3s ease;
    }

    .img-preview:hover {
        transform: scale(1.03);
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

    .form-check-input {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .form-check-input:checked {
        background-color: #38bdf8;
        border-color: #38bdf8;
    }
</style>
@endpush
@endsection

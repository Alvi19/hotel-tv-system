@extends('layouts.app')
@section('title', 'Edit Shortcut')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mb-4 fw-semibold text-white">Edit Shortcut</h3>

    <div class="card glass-card p-4">
        <form action="{{ route('dashboard.shortcuts.update', $shortcut->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Title</label>
                <input type="text" name="title" class="form-control glass-input"
                       value="{{ $shortcut->title }}" required placeholder="Shortcut title">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Type</label>
                <select name="type" class="form-select glass-input" required>
                    @foreach(['youtube','netflix','iptv','web','app'] as $type)
                        <option value="{{ $type }}" {{ $shortcut->type == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Target URL / App ID</label>
                <input type="text" name="target" class="form-control glass-input"
                       value="{{ $shortcut->target }}" placeholder="https://example.com">
            </div>

            <div class="mb-4">
                {{-- <label class="form-label fw-semibold text-light">Icon</label> --}}
                <div class="icon-preview-box text-center mb-3">
                    @if($shortcut->icon_url)
                        <img id="previewImage" src="{{ asset('storage/'.$shortcut->icon_url) }}" alt="icon"
                             class="icon-preview rounded">
                    @else
                        <img id="previewImage" class="icon-preview d-none" alt="icon">
                    @endif
                </div>
                <input type="file" name="icon_url" id="iconInput" class="form-control glass-input" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-light">Order</label>
                <input type="number" name="order_no" class="form-control glass-input"
                       value="{{ $shortcut->order_no }}" min="0" placeholder="Display order">
            </div>

            <div class="form-check form-switch mb-4">
                <input type="checkbox" name="is_active" class="form-check-input" id="isActiveSwitch"
                       {{ $shortcut->is_active ? 'checked' : '' }}>
                <label for="isActiveSwitch" class="form-check-label text-light">Active</label>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('dashboard.shortcuts.index') }}" class="btn btn-outline-light px-4">
                    <i class="bi bi-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="bi bi-check2-circle me-1"></i> Update Shortcut
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
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        color: #f8fafc;
        transition: 0.3s ease;
    }

    .glass-input:focus {
        background: rgba(255,255,255,0.15);
        box-shadow: 0 0 0 2px rgba(99,102,241,0.4);
        color: #fff;
    }

    .glass-input::placeholder {
        color: rgba(255,255,255,0.6);
    }

    .icon-preview-box {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        display: inline-block;
        padding: 8px;
    }

    .icon-preview {
        width: 90px;
        height: 90px;
        object-fit: contain;
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .icon-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(56,189,248,0.6);
    }

    .btn-gradient {
        background: linear-gradient(90deg, #6366f1, #38bdf8);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 10px rgba(99,102,241,0.4);
    }

    .btn-outline-light {
        border-color: rgba(255,255,255,0.3);
        color: #f8fafc;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }

    label {
        color: #cbd5e1;
    }

    h3 {
        color: #f8fafc;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('iconInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewImage = document.getElementById('previewImage');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImage.src = evt.target.result;
                previewImage.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection

@extends('layouts.app')
@section('title', 'Banners')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold text-white">Banner Promotions</h3>
        <a href="{{ route('dashboard.banners.create') }}" class="btn btn-gradient px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Banner
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success glass-alert">{{ session('success') }}</div>
    @endif

    <!-- Banner List -->
    <div class="row g-4">
        @forelse($banners as $banner)
            <div class="col-md-4 col-lg-3">
                <div class="card banner-card h-100">
                    @if($banner->image_url)
                        <div class="banner-image-wrapper">
                            <img src="{{ asset('storage/' . $banner->image_url) }}"
                                 class="card-img-top banner-image"
                                 alt="Banner Image">
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-semibold text-white mb-2">{{ $banner->title }}</h6>
                        <p class="text-muted small mb-3">{{ $banner->description ?? '-' }}</p>

                        <!-- Status -->
                        <span class="badge status-badge
                            @if($banner->status == 'Active') bg-active
                            @elseif($banner->status == 'Upcoming') bg-upcoming
                            @else bg-inactive @endif">
                            {{ $banner->status }}
                        </span>

                        <!-- Date Info -->
                        <p class="banner-dates small mt-2">
                            🗓️ {{ $banner->active_from }} — {{ $banner->active_to }}
                        </p>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('dashboard.banners.edit', $banner->id) }}"
                               class="btn btn-sm btn-outline-light">
                               <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('dashboard.banners.destroy', $banner->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center glass-alert">
                No banners found.
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    /* ===== Glass Card ===== */
    .banner-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px;
        color: #e2e8f0;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        transition: all 0.3s ease;
    }

    .banner-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.35);
    }

    /* ===== Banner Image ===== */
    .banner-image-wrapper {
        overflow: hidden;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
    }

    .banner-image {
        height: 160px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .banner-card:hover .banner-image {
        transform: scale(1.05);
    }

    /* ===== Status Badges ===== */
    .status-badge {
        font-size: 0.75rem;
        padding: 6px 10px;
        border-radius: 6px;
        text-transform: capitalize;
        font-weight: 500;
    }

    .bg-active {
        background: linear-gradient(90deg, #10b981, #34d399);
        color: #fff;
    }

    .bg-upcoming {
        background: linear-gradient(90deg, #facc15, #fbbf24);
        color: #000;
    }

    .bg-inactive {
        background: linear-gradient(90deg, #9ca3af, #6b7280);
        color: #fff;
    }

    /* ===== Buttons ===== */
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

    /* ===== Alerts ===== */
    .glass-alert {
        background: rgba(56,189,248,0.15);
        border: 1px solid rgba(56,189,248,0.3);
        color: #e0f2fe;
        border-radius: 10px;
        backdrop-filter: blur(12px);
    }

    /* ===== Texts ===== */
    .banner-dates {
        color: #94a3b8;
    }

    h3 {
        color: #f8fafc;
    }
</style>
@endpush
@endsection

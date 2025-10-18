@extends('layouts.app')
@section('title', 'Shortcuts')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold text-white">Shortcuts</h3>
        <a href="{{ route('dashboard.shortcuts.create') }}" class="btn btn-gradient">
            <i class="bi bi-plus-circle me-1"></i> Add Shortcut
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm glass-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($shortcuts as $shortcut)
            <div class="col-md-4 col-lg-3">
                <div class="card glass-card text-center p-4 h-100 position-relative">

                    <div class="icon-wrapper d-flex justify-content-center align-items-center mb-3">
                        @if($shortcut->icon_url)
                            <img src="{{ asset('storage/'.$shortcut->icon_url) }}"
                                 class="shortcut-icon"
                                 alt="Icon">
                        @else
                            <i class="bi bi-globe2 fs-1 text-cyan-400"></i>
                        @endif
                    </div>

                    <h6 class="fw-semibold text-white">{{ $shortcut->title }}</h6>
                    <p class="text-muted small mb-2">{{ ucfirst($shortcut->type) }}</p>

                    @if($shortcut->target)
                        <a href="{{ $shortcut->target }}" target="_blank" class="shortcut-link">
                            {{ Str::limit($shortcut->target, 30) }}
                        </a>
                    @else
                        <span class="text-muted small">No target URL</span>
                    @endif

                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('dashboard.shortcuts.edit', $shortcut->id) }}"
                           class="btn btn-sm btn-outline-light">
                           <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('dashboard.shortcuts.destroy', $shortcut->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this shortcut?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <div class="mt-3">
                        <span class="badge
                            {{ $shortcut->is_active ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                            {{ $shortcut->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert glass-alert text-center text-light mt-3">No shortcuts available.</div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .glass-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.1);
        color: #e2e8f0;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.35);
    }

    .icon-wrapper {
        height: 90px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .shortcut-icon {
        width: 70px;
        height: 70px;
        object-fit: contain;
        border-radius: 12px;
        background: rgba(255,255,255,0.08);
        padding: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: 0.3s ease;
    }

    .shortcut-icon:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(56,189,248,0.5);
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
        border-radius: 8px;
        transition: 0.3s ease;
    }

    .btn-outline-light:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }

    .btn-outline-danger {
        border-color: rgba(239,68,68,0.6);
        color: #ef4444;
        border-radius: 8px;
    }

    .btn-outline-danger:hover {
        background: rgba(239,68,68,0.15);
        color: #fff;
    }

    .bg-gradient-success {
        background: linear-gradient(90deg, #22c55e, #4ade80);
        color: #fff;
        border-radius: 10px;
        font-weight: 500;
        padding: 5px 12px;
    }

    .bg-gradient-secondary {
        background: linear-gradient(90deg, #475569, #64748b);
        color: #fff;
        border-radius: 10px;
        font-weight: 500;
        padding: 5px 12px;
    }

    .shortcut-link {
        color: #38bdf8;
        font-size: 0.9rem;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .shortcut-link:hover {
        text-decoration: underline;
        color: #7dd3fc;
    }

    .glass-alert {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #bbf7d0;
        border-radius: 10px;
    }
</style>
@endpush
@endsection

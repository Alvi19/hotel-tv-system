@extends('layouts.app')
@section('title', 'Contents')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Hotel Contents</h3>
        <a href="{{ route('dashboard.contents.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Content
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse($contents as $content)
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 h-100">
                    @if($content->image_url)
                        <img src="{{ asset('storage/'.$content->image_url) }}" class="card-img-top" alt="Image" style="height:140px;object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $content->title }}</h6>
                        <p class="text-muted small">{{ ucfirst($content->type) }}</p>
                        <span class="badge {{ $content->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('dashboard.contents.edit', $content->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('dashboard.contents.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Delete this content?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">No contents found.</div>
        @endforelse
    </div>
</div>
@endsection

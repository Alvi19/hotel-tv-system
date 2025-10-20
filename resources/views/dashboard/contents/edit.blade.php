@extends('layouts.app')
@section('title', 'Edit Content')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Content
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $content->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select">
                        @foreach(['about', 'facilities', 'services', 'contact'] as $type)
                            <option value="{{ $type }}" {{ $content->type == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Image</label><br>
                    @if($content->image_url)
                        <img src="{{ asset('storage/'.$content->image_url) }}" alt="image" class="img-thumbnail mb-2" width="200">
                    @endif
                    <input type="file" name="image_url" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content Body</label>
                    <textarea name="body" class="form-control" rows="5">{{ $content->body }}</textarea>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input" {{ $content->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.contents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Add Content')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-plus-circle"></i> Add Content
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.contents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="about">About</option>
                        <option value="facilities">Facilities</option>
                        <option value="services">Services</option>
                        <option value="contact">Contact</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Image</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content Body</label>
                    <textarea name="body" class="form-control" rows="5" placeholder="Write the content details..."></textarea>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input" checked>
                    <label class="form-check-label">Active</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.contents.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button class="btn btn-success"><i class="bi bi-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

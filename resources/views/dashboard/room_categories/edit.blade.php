@extends('layouts.app')
@section('title', 'Edit Room Category')

@section('content')
<div class="container mt-3">
    <h3 class="text-light mb-3">Edit Room Category</h3>

    <form action="{{ route('dashboard.room-categories.update', $roomCategory->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label text-light">Category Name</label>
            <input type="text" name="name" value="{{ $roomCategory->name }}" class="form-control bg-dark text-light" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-light">Description (optional)</label>
            <textarea name="description" class="form-control bg-dark text-light" rows="3">{{ $roomCategory->description }}</textarea>
        </div>

        <button class="btn btn-success"><i class="bi bi-check-circle"></i> Update</button>
        <a href="{{ route('dashboard.room-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

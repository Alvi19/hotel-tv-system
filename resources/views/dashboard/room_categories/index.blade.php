@extends('layouts.app')
@section('title', 'Room Categories')

@section('content')
<div class="container mt-3">
    <h3 class="text-light mb-3">Manage Room Categories</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('dashboard.room-categories.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add Category
    </a>

    <table class="table table-bordered table-dark table-striped align-middle">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Name</th>
                <th>Description</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('dashboard.room-categories.edit', $cat->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('dashboard.room-categories.destroy', $cat->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this category?')"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

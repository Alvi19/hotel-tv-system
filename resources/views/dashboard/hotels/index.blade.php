@extends('layouts.app')
@section('title', 'Manage Hotels')
@section('content')
<div class="p-6 h-[calc(100vh-100px)] overflow-y-auto">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-light"><i class="bi bi-building-fill me-2"></i>Manage Hotels</h3>
        <a href="{{ route('dashboard.hotels.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Hotel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card bg-transparent border border-secondary shadow-sm">
        <div class="card-body p-0">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Logo</th>
                        <th style="width: 130px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hotels as $hotel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->address ?? '-' }}</td>
                            <td>{{ $hotel->email ?? '-' }}</td>
                            <td>
                                @if($hotel->website)
                                    <a href="{{ $hotel->website }}" target="_blank" class="text-info text-decoration-none">
                                        {{ $hotel->website }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($hotel->logo_url)
                                    <img src="{{ asset('storage/'.$hotel->logo_url) }}" alt="logo" width="50" class="rounded shadow">
                                @else
                                    <span class="text-muted">No Logo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dashboard.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('dashboard.hotels.show', $hotel->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('dashboard.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this hotel?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No hotels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

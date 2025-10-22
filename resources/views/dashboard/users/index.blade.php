@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-light"><i class="bi bi-people me-2"></i>Manage Users</h3>
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <div class="card bg-transparent border border-secondary shadow-sm">
        <div class="card-body p-0">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:5%">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Hotel</th>
                        <th style="width:15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <span class="badge
                                    {{ $u->role?->name === 'it_admin' ? 'bg-primary' : 'bg-success' }}">
                                    {{ ucfirst($u->role?->display_name ?? $u->role?->name ?? '-') }}
                                </span>
                            </td>
                            <td>{{ $u->hotel?->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('dashboard.users.edit', $u->id) }}"
                                   class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form method="POST" action="{{ route('dashboard.users.destroy', $u->id) }}"
                                      class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this user?')"
                                            class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

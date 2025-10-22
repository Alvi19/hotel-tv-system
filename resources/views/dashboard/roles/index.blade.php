@extends('layouts.app')

@section('title', 'Manage Roles')

@section('content')
<div class="container mt-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-light">
            <i class="bi bi-person-gear me-2 text-info"></i> Manage Roles
        </h3>
        @if(auth()->user()->canAccess('manage_roles'))
            <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add Role
            </a>
        @endif
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Role Table --}}
    <div class="card bg-dark text-light shadow-lg border-0">
        <div class="card-body">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Display Name</th>
                        <th>Scope</th>
                        <th>Hotel</th>
                        <th>Permissions</th>
                        <th>Created By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold text-info">
                                <i class="bi bi-shield-lock me-1"></i> {{ ucfirst($role->name) }}
                            </td>
                            <td>{{ $role->display_name ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $role->scope === 'global' ? 'info' : 'success' }}">
                                    {{ ucfirst($role->scope) }}
                                </span>
                            </td>
                            <td>{{ $role->hotel->name ?? '— Global —' }}</td>

                            {{-- Permissions --}}
                            <td>
                                @if ($role->permissions->count())
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            {{ $role->permissions->count() }} Permissions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            @foreach ($role->permissions as $perm)
                                                <li class="dropdown-item small">
                                                    <i class="bi bi-key me-1 text-info"></i> {{ $perm->key }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>

                            {{-- Created By --}}
                            <td>{{ $role->creator->name ?? 'System' }}</td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                   class="btn btn-sm btn-warning me-1" title="Edit Role">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(auth()->user()->isGlobalRole() && auth()->user()->canAccess('manage_roles'))
                                    <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this role?')"
                                            title="Delete Role">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                <i class="bi bi-info-circle me-1"></i> No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-dark th {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu-dark {
        background-color: #1e293b;
    }

    .dropdown-item:hover {
        background-color: #334155;
    }

    .btn-outline-light.dropdown-toggle {
        border-color: rgba(255, 255, 255, 0.3);
        color: #e2e8f0;
    }

    .btn-outline-light.dropdown-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .badge.bg-info {
        background: linear-gradient(90deg, #38bdf8, #0ea5e9);
    }

    .badge.bg-success {
        background: linear-gradient(90deg, #22c55e, #16a34a);
    }
</style>
@endpush

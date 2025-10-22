@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-light"><i class="bi bi-pencil-square me-2"></i>Edit User</h3>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Alert Validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="card bg-transparent border border-secondary shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.users.update', $editUser->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold text-light">Username</label>
                    <input type="text" name="name" value="{{ old('name', $editUser->name) }}"
                           class="form-control bg-dark text-light border-secondary" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-light">Email</label>
                    <input type="email" name="email" value="{{ old('email', $editUser->email) }}"
                           class="form-control bg-dark text-light border-secondary" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-light">Password (leave blank to keep current)</label>
                    <input type="password" name="password"
                           class="form-control bg-dark text-light border-secondary" placeholder="New password (optional)">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-light">Role</label>
                    <select name="role_id" class="form-select bg-dark text-light border-secondary" required>
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $editUser->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-light">Assign Hotel (optional)</label>
                    <select name="hotel_id" class="form-select bg-dark text-light border-secondary">
                        <option value="">-- No Hotel --</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ $editUser->hotel_id == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="container mt-3">
    <h3>Edit User</h3>

    <form method="POST" action="{{ route('dashboard.users.update', $user->id) }}">
        @csrf @method('PUT')

        <label>Username</label>
        <input type="text" name="username" value="{{ $user->username }}" class="form-control mb-2" required>

        <label>New Password (optional)</label>
        <input type="password" name="password" class="form-control mb-2">

        <label>Role</label>
        <select name="role" class="form-select mb-2" required>
            <option value="hotel_staff" {{ $user->role == 'hotel_staff' ? 'selected' : '' }}>Hotel Staff</option>
            <option value="it_admin" {{ $user->role == 'it_admin' ? 'selected' : '' }}>IT Admin</option>
        </select>

        <label>Assign Hotel (optional)</label>
        <select name="hotel_id" class="form-select mb-3">
            <option value="">-- No Hotel --</option>
            @foreach($hotels as $hotel)
                <option value="{{ $hotel->id }}" {{ $user->hotel_id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
            @endforeach
        </select>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

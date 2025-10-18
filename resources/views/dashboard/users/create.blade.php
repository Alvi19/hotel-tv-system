@extends('layouts.app')
@section('title', 'Add New User')
@section('content')
<div class="container mt-3">
    <h3>Add New User</h3>

    <form method="POST" action="{{ route('dashboard.users.store') }}">
        @csrf

        <label>Username</label>
        <input type="text" name="name" class="form-control mb-2" required>

        <label>Password</label>
        <input type="password" name="password" class="form-control mb-2" required>

        <label>Email</label>
        <input type="email" name="email" class="form-control mb-2">

        <label>Role</label>
        <select name="role" class="form-select mb-2" required>
            <option value="hotel_staff">Hotel Staff</option>
            <option value="it_admin">IT Admin</option>
        </select>

        <label>Assign Hotel (optional)</label>
        <select name="hotel_id" class="form-select mb-3">
            <option value="">-- No Hotel --</option>
            @foreach($hotels as $hotel)
                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
            @endforeach
        </select>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

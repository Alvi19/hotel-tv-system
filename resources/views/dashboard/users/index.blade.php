@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<div class="container mt-3">
    <h3>Manage Users</h3>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary mb-3">+ Add New User</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Role</th>
                <th>Hotel</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td><span class="badge bg-{{ $u->role == 'it_admin' ? 'primary' : 'success' }}">{{ $u->role }}</span></td>
                <td>{{ $u->hotel?->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('dashboard.users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('dashboard.users.destroy', $u->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

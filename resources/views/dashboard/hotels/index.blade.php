@extends('layouts.app')
@section('title', 'Manage Hotels')
@section('content')
<div class="container mt-3">
    <h3>Manage Hotels</h3>

    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <a href="{{ route('dashboard.hotels.create') }}" class="btn btn-primary mb-3">+ Add New Hotel</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Website</th>
                <th>Logo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hotels as $hotel)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $hotel->name }}</td>
                <td>{{ $hotel->address }}</td>
                <td>{{ $hotel->email }}</td>
                <td>{{ $hotel->website }}</td>
                <td>
                    @if($hotel->logo_url)
                        <img src="{{ asset('storage/'.$hotel->logo_url) }}" alt="logo" width="50">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('dashboard.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dashboard.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this hotel?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

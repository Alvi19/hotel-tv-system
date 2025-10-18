@extends('layouts.app')
@section('title', 'Edit Hotel Info')
@section('content')
<div class="container">
    <h3>Edit Hotel Information</h3>

    <form action="{{ route('dashboard.hotel.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ $hotel->name }}" class="form-control mb-2">

        <label>Description</label>
        <textarea name="description" class="form-control mb-2">{{ $hotel->description }}</textarea>

        <label>Address</label>
        <input type="text" name="address" value="{{ $hotel->address }}" class="form-control mb-2">

        <label>Phone</label>
        <input type="text" name="phone" value="{{ $hotel->phone }}" class="form-control mb-2">

        <label>Email</label>
        <input type="email" name="email" value="{{ $hotel->email }}" class="form-control mb-2">

        <label>Website</label>
        <input type="url" name="website" value="{{ $hotel->website }}" class="form-control mb-2">

        <label>Logo</label>
        <input type="file" name="logo_url" class="form-control mb-2">

        <label>Background Image</label>
        <input type="file" name="background_image_url" class="form-control mb-3">

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@extends('layouts.auth')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ url('/login') }}">
    @csrf
    <div class="mb-3 text-start">
        <label for="username" class="form-label">Username</label>
        <input type="text"
               class="form-control @error('username') is-invalid @enderror"
               name="name"
               id="name"
               value="{{ old('name') }}"
               placeholder="Masukkan username"
               required autofocus>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <input type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password"
               id="password"
               placeholder="Masukkan password"
               required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>

    <p class="text-muted mt-3" style="font-size: 0.9rem;">
        <b>Username:</b> it_admin / hotel_staff <br>
        <b>Password:</b> password123
    </p>
</form>
@endsection

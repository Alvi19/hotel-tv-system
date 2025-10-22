@extends('layouts.auth')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3 text-start">
            <label for="name" class="form-label fw-semibold">Username / Email</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                value="{{ old('name') }}" placeholder="Masukkan username atau email" required autofocus>
            @error('name')
                <span class="invalid-feedback d-block text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-start position-relative">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password"
                id="password" placeholder="Masukkan password" required>
            <i class="bi bi-eye-slash position-absolute" id="togglePassword"
                style="top: 70%; right: 15px; transform: translateY(-50%);
                  color: rgba(255,255,255,0.6); cursor: pointer; transition: 0.3s;">
            </i>
            @error('password')
                <span class="invalid-feedback d-block text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-login w-100">Login</button>
        <p class="text-muted mt-4" style="font-size: 0.9rem;">
            <b>Username:</b> it_admin / hotel_staff <br>
            <b>Password:</b> password123
        </p>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
                this.style.color = isPassword ? '#00c6ff' : 'rgba(255,255,255,0.6)';
            });
        });
    </script>
@endsection

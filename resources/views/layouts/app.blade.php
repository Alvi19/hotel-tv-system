<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Dashboard')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            position: fixed;
            color: #fff;
            padding-top: 1rem;
        }
        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #495057;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            margin-left: 250px;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white mb-4">🏨 Hotel Dashboard</h4>
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-house"></i> Dashboard</a>

        @if(auth()->user()->isHotelStaff())
        <a href="/dashboard/hotel/edit" class="{{ request()->is('dashboard/hotel*') ? 'active' : '' }}"><i class="bi bi-building"></i> Hotel Info</a>
        <a href="/dashboard/rooms" class="{{ request()->is('dashboard/rooms*') ? 'active' : '' }}"><i class="bi bi-door-open"></i> Rooms</a>
        <a href="/dashboard/banners" class="{{ request()->is('dashboard/banners*') ? 'active' : '' }}"><i class="bi bi-image"></i> Banners</a>
        <a href="/dashboard/shortcuts" class="{{ request()->is('dashboard/shortcuts*') ? 'active' : '' }}"><i class="bi bi-grid"></i> Shortcuts</a>
        <a href="/dashboard/contents" class="{{ request()->is('dashboard/contents*') ? 'active' : '' }}"><i class="bi bi-info-circle"></i> Contents</a>
        @endif

        @if(auth()->user()->isItAdmin())
        <a href="/dashboard/admin/hotels" class="{{ request()->is('dashboard/admin/hotels*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Manage Hotels</a>
        <a href="/dashboard/admin/staffs" class="{{ request()->is('dashboard/admin/staffs*') ? 'active' : '' }}"><i class="bi bi-person-gear"></i> Manage Staff</a>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Welcome, {{ auth()->user()->username }}</span>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>

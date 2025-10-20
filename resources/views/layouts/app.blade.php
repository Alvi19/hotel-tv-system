<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel IPTV Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===== BASE ===== */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #0f172a, #1e293b);
            color: #e2e8f0;
            overflow-x: hidden;
            overflow-y: hidden; /* ✅ hilangkan scroll global */
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
            box-shadow: 5px 0 15px rgba(0,0,0,0.2);
            z-index: 100;
        }

        .sidebar-header {
            text-align: center;
            padding: 2rem 0 1rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #f8fafc;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            color: #cbd5e1;
            display: flex;
            align-items: center;
            padding: 12px 22px;
            gap: 12px;
            font-size: 0.95rem;
            text-decoration: none;
            transition: 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-left: 3px solid #38bdf8;
        }

        .sidebar a.active {
            color: #fff;
            background: rgba(99, 102, 241, 0.2);
            border-left: 3px solid #6366f1;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            height: 70px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-left: 260px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: fixed; /* ✅ fix di atas */
            top: 0;
            width: calc(100% - 260px);
            z-index: 99;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: #f8fafc;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .navbar .user-info {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 260px;
            padding: 30px;
            padding-top: 100px; /* ✅ beri ruang navbar */
            height: calc(100vh - 70px);
            overflow-y: auto; /* ✅ hanya scroll di dalam content */
        }

        /* ===== CARD STYLE ===== */
        .card {
            background: linear-gradient(145deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
            color: #e2e8f0;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .card h2 {
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 0.2rem;
        }

        .card p {
            color: #94a3b8;
            margin-bottom: 0;
        }

        /* ===== LOGOUT BUTTON ===== */
        .logout-btn {
            background: linear-gradient(90deg, #ef4444, #dc2626);
            border: none;
            color: #fff;
            border-radius: 8px;
            padding: 10px;
            margin: 20px;
            transition: 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(90deg, #dc2626, #b91c1c);
            transform: scale(1.05);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
                position: fixed;
                z-index: 999;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar {
                margin-left: 0;
                width: 100%;
            }

            .content {
                margin-left: 0;
                padding-top: 100px;
                height: calc(100vh - 70px);
            }
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            color: #f8fafc;
            font-size: 1.6rem;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-header">
                <i class="bi bi-building me-2"></i> Admin
            </div>

            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            @if(auth()->user()->isHotelStaff())
                <a href="/dashboard/hotel/edit" class="{{ request()->is('dashboard/hotel*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Hotel Info
                </a>
                <a href="/dashboard/rooms" class="{{ request()->is('dashboard/rooms*') ? 'active' : '' }}">
                    <i class="bi bi-door-open"></i> Rooms
                </a>
                <a href="/dashboard/banners" class="{{ request()->is('dashboard/banners*') ? 'active' : '' }}">
                    <i class="bi bi-image"></i> Banners
                </a>
                <a href="/dashboard/shortcuts" class="{{ request()->is('dashboard/shortcuts*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Shortcuts
                </a>
                <a href="/dashboard/contents" class="{{ request()->is('dashboard/contents*') ? 'active' : '' }}">
                    <i class="bi bi-info-circle"></i> Contents
                </a>
                <a href="{{ route('dashboard.devices.index') }}" class="{{ request()->is('dashboard/devices*') ? 'active' : '' }}">
                    <i class="bi bi-tv"></i> Devices
                </a>
            @endif

            @if(auth()->check() && auth()->user()->isItAdmin())
                <hr class="border-secondary opacity-25">
                <a href="/dashboard/users" class="{{ request()->is('dashboard/users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Manage Users
                </a>
                <a href="/dashboard/hotels" class="{{ request()->is('dashboard/hotels*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Manage Hotels
                </a>
                <a href="{{ route('dashboard.admin.devices.index') }}" class="{{ request()->is('dashboard/admin/devices*') ? 'active' : '' }}">
                    <i class="bi bi-hdd-network"></i> Manage Devices
                </a>
            @endif
        </div>

        <form method="POST" action="{{ route('logout') }}" class="text-center mb-3">
            @csrf
            <button type="submit" class="logout-btn w-75">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar">
        <button class="sidebar-toggle d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <span class="navbar-brand">Hotel IPTV Dashboard</span>
        <span class="user-info">{{ auth()->user()->name }}</span>
    </nav>

    <!-- ===== CONTENT ===== -->
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    </script>

    @stack('scripts')
</body>
</html>

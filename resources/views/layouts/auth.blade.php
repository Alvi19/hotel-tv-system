<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel IPTV Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('{{ asset('images/hotel_bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 400px;
            padding: 2rem;
        }
        .logo {
            width: 80px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <img src="{{ asset('images/hotel_logo.png') }}" class="logo" alt="Hotel Logo">
        <h4 class="mb-3">Hotel IPTV System</h4>
        @yield('content')
    </div>
</body>
</html>

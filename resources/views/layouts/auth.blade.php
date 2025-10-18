<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel IPTV Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Efek blur card */
        .login-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2.5rem;
            width: 380px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            animation: fadeIn 1s ease-out;
        }

        /* Logo */
        .logo {
            width: 90px;
            margin-bottom: 1.2rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
        }

        /* Input style */
        .form-control {
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 2px rgba(0, 255, 255, 0.4);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Tombol login */
        .btn-login {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(0, 198, 255, 0.4);
        }

        /* Eye icon */
        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .input-group-text:hover {
            color: #00c6ff;
        }

        /* Footer info */
        .text-muted {
            color: rgba(255,255,255,0.75) !important;
            font-size: 0.9rem;
        }

        /* Animasi */
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>
    <div class="login-card">
        <img src="{{ asset('images/hotel_logo.png') }}" alt="Hotel Logo" class="logo">
        <h4 class="fw-semibold mb-4">Hotel IPTV System</h4>
        @yield('content')
    </div>
</body>
</html>

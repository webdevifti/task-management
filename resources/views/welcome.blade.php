<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_option('site_name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Hero Banner Animation */
        @keyframes slide {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        .hero {
            height: 100vh;
            background: linear-gradient(120deg, #4e54c8, #8f94fb);
            background-size: 200% 200%;
            animation: slide 8s ease infinite;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .hero .btn {
            margin-top: 30px;
            padding: 10px 20px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{get_option('site_name')}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::user())
                        <li class="nav-item">
                            @if (user_logged_in())
                                <a class="nav-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                            @endif
                            @if (admin_logged_in())
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            @endif
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Welcome to Our {{get_option('site_name')}}</h1>
            <p>Track your task, create,edit,manage your task with this system.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

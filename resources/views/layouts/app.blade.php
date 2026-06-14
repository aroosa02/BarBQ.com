<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | BarBQ.com</title>

    <!-- Theme Detection Script (Inlined to avoid flicker) -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('barbq-theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="BarBQ.com" height="40"
                    class="me-2 rounded-circle shadow-sm">
                <span class="fs-4">BarBQ<span class="text-bbq-pink">.com</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu') ? 'active fw-bold' : '' }}"
                            href="{{ route('menu') }}">Menu</a>
                    </li>
                    @yield('nav-links')
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @include('components.theme-toggle')
                    <div class="vr mx-2"></div>
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-user-circle"></i> {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-bbq-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-bbq-primary">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @include('components.alert')
        @yield('content')
    </main>

    <footer class="py-4 mt-5 border-top">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <small class="text-muted">Built for University Semester Project</small>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
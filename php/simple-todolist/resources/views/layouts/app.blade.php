<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - MyTodos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        html {
            min-height: 100%;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .container {
            flex: 1; /* This makes the container grow to push footer down */
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .btn {
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Footer Styles */
        .footer {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0 1rem;
            margin-top: auto; /* Push footer to bottom */
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.25rem;
            transition: all 0.2s;
        }

        .footer-social a:hover {
            color: white;
            transform: translateY(-2px);
        }

        .footer-copyright {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 768px) {
            body {
                margin-bottom: 350px; /* Increased for mobile */
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('todos.index') }}">
                <i class="bi bi-check2-circle"></i> MyTodos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('todos.index') ? 'active' : '' }}" href="{{ route('todos.index') }}">
                            <i class="bi bi-list-task"></i> All Todos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('todos.finished') ? 'active' : '' }}" href="{{ route('todos.finished') }}">
                            <i class="bi bi-check-circle"></i> Completed
                        </a>
                    </li>
                </ul>

                @auth
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Hello, {{ auth()->user()->name }}</span>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="user-avatar me-2">
                            @else
                                <i class="bi bi-person-circle fs-4 me-2"></i>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-gear"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Display Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h5><i class="bi bi-lightning-charge"></i> Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('todos.index') }}"><i class="bi bi-list-task"></i> My Todos</a></li>
                        <li><a href="{{ route('todos.create') }}"><i class="bi bi-plus-circle"></i> Create Todo</a></li>
                        <li><a href="{{ route('todos.finished') }}"><i class="bi bi-check-circle"></i> Completed Tasks</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5><i class="bi bi-info-circle"></i> Support</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact.index') }}"><i class="bi bi-chat-dots"></i> Contact Us</a></li>
                        <li><a href="{{ route('about') }}"><i class="bi bi-info-circle"></i> About Us</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5><i class="bi bi-file-text"></i> Legal</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('privacy-policy') }}"><i class="bi bi-shield-check"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}"><i class="bi bi-file-earmark-text"></i> Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-logo">
                    <i class="bi bi-check2-circle"></i>
                    MyTodos
                </div>

                <div class="footer-copyright">
                    © {{ date('Y') }} MyTodos. All rights reserved.
                </div>

                <div class="footer-social">
                    <a href="#" title="Twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @stack('scripts')
</body>
</html>

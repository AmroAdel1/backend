<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - MyTodos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated background circles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite ease-in-out;
        }
        
        body::before {
            width: 500px;
            height: 500px;
            top: -250px;
            right: -250px;
            animation-delay: 0s;
        }
        
        body::after {
            width: 400px;
            height: 400px;
            bottom: -200px;
            left: -200px;
            animation-delay: 5s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-50px) rotate(180deg);
            }
        }
        
        .auth-container {
            width: 100%;
            max-width: 450px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }
        
        .auth-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            flex-shrink: 0;
        }
        
        .auth-logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }
        
        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
        }
        
        .auth-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .auth-body {
            padding: 2rem;
            overflow-y: auto;
            flex: 1;
        }
        
        /* Custom scrollbar */
        .auth-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .auth-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .auth-body::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        
        .auth-body::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-label i {
            color: #6b7280;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 1.0625rem;
            color: #9ca3af;
            font-size: 1.125rem;
            z-index: 2;
            pointer-events: none;
            line-height: 1;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            width: 100%;
            height: 3.125rem;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
            background-image: none; /* Remove Bootstrap's validation icon */
        }
        
        .invalid-feedback {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 0.9rem;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0.25rem;
            z-index: 2;
            font-size: 1.125rem;
            line-height: 1;
        }
        
        .password-toggle:hover {
            color: #667eea;
        }
        
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin: 0;
        }
        
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            border: 2px solid #d1d5db;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        /* Prevent checkbox from changing color/border when invalid */
        .form-check-input.is-invalid {
            border-color: #d1d5db !important;
            background-color: white !important;
        }
        
        .form-check-input.is-invalid:checked {
            background-color: #667eea !important;
            border-color: #667eea !important;
        }
        
        .form-check-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            outline: 0;
        }
        
        /* Keep blue shadow even when invalid */
        .form-check-input.is-invalid:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25) !important;
        }
        
        .form-check-label {
            font-size: 0.875rem;
            color: #6b7280;
            cursor: pointer;
            user-select: none;
            line-height: 1.5;
        }
        
        /* Prevent label text color from changing when invalid */
        .form-check-input.is-invalid ~ .form-check-label {
            color: #6b7280 !important;
        }
        
        .form-check-label a {
            color: #f5576c;
            text-decoration: none;
        }
        
        .form-check-label a:hover {
            text-decoration: underline;
        }
        
        /* Error message alignment for checkbox */
        .form-check ~ .invalid-feedback {
            margin-left: 0;
            margin-top: 0.375rem;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 0.5rem;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn:hover {
            border-color: #d1d5db;
            background-color: #f9fafb;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .divider span {
            padding: 0 1rem;
        }
        
        .auth-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
        }
        
        .auth-footer p {
            margin: 0;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
            font-size: 0.875rem;
            justify-content: left;
            text-align: center;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .alert i {
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        /* Back to Login button (left side) */
        .back-to-login {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }
        
        .back-to-login a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .back-to-login a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }
        
        /* Go to Register button (right side) */
        .go-to-register {
            position: absolute;
            top: 2rem;
            right: 2rem;
            z-index: 10;
        }
        
        .go-to-register a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .go-to-register a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(3px);
        }
        
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
        
            .auth-container {
                max-height: 95vh;
            }
        
            .auth-card {
                max-height: 95vh;
            }
        
            .auth-header {
                padding: 2rem 1.5rem;
            }
        
            .auth-logo {
                width: 60px;
                height: 60px;
                font-size: 1.75rem;
            }
        
            .auth-header h1 {
                font-size: 1.5rem;
            }
        
            .auth-body {
                padding: 1.5rem;
            }
        
            .back-to-login {
                top: 1rem;
                left: 1rem;
            }
        
            .go-to-register {
                top: 1rem;
                right: 1rem;
            }
        }
    </style>
</head>
<body>
    @if (Request::routeIs('auth.login'))
    <div class="go-to-register">
        <a href="{{ route('auth.register') }}">
            Go To Register
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    @else
        <div class="back-to-login">
            <a href="{{ route('auth.login') }}">
                <i class="bi bi-arrow-left"></i>
                Back to Login
            </a>
        </div>
    @endif

    <div class="auth-container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

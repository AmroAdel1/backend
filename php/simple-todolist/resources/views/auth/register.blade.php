@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="auth-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <div class="auth-logo">
            <i class="bi bi-person-plus"></i>
        </div>
        <h1>Create Account</h1>
        <p>Join MyTodos and start organizing your tasks</p>
    </div>

    <div class="auth-body">
        {{-- Error Messages --}}
        {{-- @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif --}}

        <form method="POST" action="{{ route('auth.register') }}">
            @csrf

            {{-- Name Field --}}
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="bi bi-person"></i>
                    Full Name
                </label>
                <div class="input-group-custom">
                    <i class="input-icon bi bi-person"></i>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           placeholder="John Doe"
                           value="{{ old('name') }}"
                           autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Email Field --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i>
                    Email Address
                </label>
                <div class="input-group-custom">
                    <i class="input-icon bi bi-envelope"></i>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           placeholder="you@example.com"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Password Field --}}
            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i>
                    Password
                </label>
                <div class="input-group-custom">
                    <i class="input-icon bi bi-lock"></i>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Minimum 8 characters">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="bi bi-eye" id="password-icon"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                <small style="display: block; margin-top: 0.375rem; color: #6b7280; font-size: 0.75rem;">
                    <i class="bi bi-info-circle"></i> Must be at least 8 characters long
                </small>
            </div>

            {{-- Confirm Password Field --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-fill"></i>
                    Confirm Password
                </label>
                <div class="input-group-custom">
                    <i class="input-icon bi bi-lock-fill"></i>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Re-enter your password">   <!-- error('password_confirmation') is-invalid enderror -->
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="bi bi-eye" id="password_confirmation-icon"></i>
                    </button>
                    {{-- @error('password_confirmation')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror --}}

                    {{-- <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                </div>
            </div>

            {{-- Terms and Conditions --}}
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input @error('terms') is-invalid @enderror"
                        id="terms"
                        name="terms">
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#" style="color: #f5576c; text-decoration: none;">Terms & Conditions</a> and <a href="#" style="color: #f5576c; text-decoration: none;">Privacy Policy</a>
                    </label>
                </div>
                @error('terms')
                    <div class="invalid-feedback" style="display: flex; margin-left: 0;">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Register Button --}}
            <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="bi bi-person-plus"></i>
                Create Account
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider">
            <span>OR</span>
        </div>

        {{-- Social Registration --}}
        <button type="button" class="btn" style="width: 100%; padding: 0.875rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; background: white; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.2s;">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.64 9.20443C17.64 8.56625 17.5827 7.95262 17.4764 7.36353H9V10.8449H13.8436C13.635 11.9699 13.0009 12.9231 12.0477 13.5613V15.8194H14.9564C16.6582 14.2526 17.64 11.9453 17.64 9.20443Z" fill="#4285F4"/>
                <path d="M9 18C11.43 18 13.4673 17.1941 14.9564 15.8195L12.0477 13.5613C11.2418 14.1013 10.2109 14.4204 9 14.4204C6.65591 14.4204 4.67182 12.8372 3.96409 10.71H0.957275V13.0418C2.43818 15.9831 5.48182 18 9 18Z" fill="#34A853"/>
                <path d="M3.96409 10.71C3.78409 10.17 3.68182 9.59318 3.68182 9C3.68182 8.40682 3.78409 7.83 3.96409 7.29V4.95818H0.957275C0.347727 6.17318 0 7.54773 0 9C0 10.4523 0.347727 11.8268 0.957275 13.0418L3.96409 10.71Z" fill="#FBBC05"/>
                <path d="M9 3.57955C10.3214 3.57955 11.5077 4.03364 12.4405 4.92545L15.0218 2.34409C13.4632 0.891818 11.4259 0 9 0C5.48182 0 2.43818 2.01682 0.957275 4.95818L3.96409 7.29C4.67182 5.16273 6.65591 3.57955 9 3.57955Z" fill="#EA4335"/>
            </svg>
            Sign up with Google
        </button>
    </div>

    <div class="auth-footer">
        <p>
            Already have an account?
            <a href="{{ route('auth.login') }}">Sign in instead</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    confirmInput.addEventListener('input', function() {
        if (this.value && this.value !== passwordInput.value) {
            this.style.borderColor = '#ef4444';
        } else if (this.value === passwordInput.value) {
            this.style.borderColor = '#10b981';
        }
    });
    // composer require laravel/socialite   // google login
</script>
@endpush
@endsection


<!--
    1. Install Laravel Socialite
Install the Socialite package via Composer:
bash
composer require laravel/socialite

2. Configure Google OAuth Credentials
Set up OAuth credentials in the Google Cloud Console. Create a new project, configure the OAuth consent screen, and create OAuth client ID credentials for a web application. You'll need to add your application's redirect URI (e.g., http://localhost:8000/auth/google/callback). Make sure to save the generated Client ID and Client Secret.
3. Update Laravel Configuration
Add the Google Client ID, Client Secret, and redirect URI to your .env file and configure the config/services.php file to use these environment variables for Google authentication.
4. Prepare the Database
Add a google_id column to your users table to store the unique Google user ID. Create a migration to add this nullable string column and then run the migration.
5. Define Routes
In your routes/web.php file, define two routes: one to initiate the Google redirect and another to handle the callback from Google. These routes should point to a dedicated controller.
6. Create the Controller Logic
Create a controller (e.g., GoogleAuthController) to manage the authentication flow. This controller will handle redirecting the user to Google using Socialite and processing the callback. In the callback method, Socialite retrieves the user's information from Google. You'll then use this information to find or create a user in your database, log them in, and redirect them to a specified page.
7. Add the Button to Your View
Finally, add a link in your login or registration Blade view that points to the route you defined for initiating the Google redirect. This link will serve as the "Sign up with Google" or "Continue with Google" button.
-->

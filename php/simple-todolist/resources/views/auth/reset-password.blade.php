@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1>Reset Password</h1>
        <p>Enter your new password</p>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Hidden Token --}}
            <input type="hidden" name="token" value="{{ $token }}">

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
                           value="{{ old('email', request()->email) }}"
                           autofocus>
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
                    New Password
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
                           placeholder="Re-enter your password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="bi bi-eye" id="password_confirmation-icon"></i>
                    </button>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-primary">
                <i class="bi bi-shield-check"></i>
                Reset Password
            </button>
        </form>
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
</script>
@endpush
@endsection

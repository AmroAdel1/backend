@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="bi bi-key"></i>
        </div>
        <h1>Forgot Password?</h1>
        <p>Enter your email and we'll send you a reset link</p>
    </div>

    <div class="auth-body">
        {{-- Success Message --}}
        @if(session('status'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

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
                           value="{{ old('email') }}"
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-primary">
                <i class="bi bi-envelope"></i>
                Send Reset Link
            </button>
        </form>

        {{-- Back to Login --}}
        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('auth.login') }}" style="font-size: 0.875rem; color: #667eea; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-arrow-left"></i>
                Back to Login
            </a>
        </div>
    </div>
</div>
@endsection

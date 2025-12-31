@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<style>
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .page-header h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .page-header p {
        margin: 0.75rem 0 0;
        opacity: 0.95;
        font-size: 1.1rem;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .content-card h2 {
        color: #667eea;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .contact-form .form-group {
        margin-bottom: 1.5rem;
    }

    .contact-form label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .contact-form input.is-invalid,
    .contact-form textarea.is-invalid {
        border-color: #ef4444;
    }

    .contact-form textarea {
        resize: vertical;
        min-height: 150px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .info-item {
        background: #f9fafb;
        padding: 1.75rem;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        transition: all 0.2s;
    }

    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .info-item h4 {
        color: #667eea;
        margin-bottom: 0.75rem;
        font-size: 1.15rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-item p {
        color: #6b7280;
        margin: 0;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .content-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h1>
            <i class="bi bi-envelope"></i>
            Contact Us
        </h1>
        <p>We'd love to hear from you! Get in touch with the MyTodos team.</p>
    </div>

    <div class="content-card">
        <h2>Send Us a Message</h2>
        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"
                       id="name"
                       name="name"
                       class="@error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="John Doe">
                @error('name')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="@error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text"
                       id="subject"
                       name="subject"
                       class="@error('subject') is-invalid @enderror"
                       value="{{ old('subject') }}"
                       placeholder="How can we help you?">
                @error('subject')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message"
                          name="message"
                          class="@error('message') is-invalid @enderror"
                          placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-send"></i>
                Send Message
            </button>
        </form>
    </div>

    <div class="content-card">
        <h2>Other Ways to Reach Us</h2>
        <div class="info-grid">
            <div class="info-item">
                <h4><i class="bi bi-envelope-fill"></i> Email</h4>
                <p>support@mytodos.com</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-telephone-fill"></i> Phone</h4>
                <p>+1 (555) 123-4567</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-geo-alt-fill"></i> Address</h4>
                <p>123 Todo Street<br>Productivity City, PC 12345</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-clock-fill"></i> Business Hours</h4>
                <p>Monday - Friday<br>9:00 AM - 5:00 PM EST</p>
            </div>
        </div>
    </div>
</div>
@endsection

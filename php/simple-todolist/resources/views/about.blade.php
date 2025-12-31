@extends('layouts.app')

@section('title', 'About Us')

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

    .content-card h3 {
        color: #764ba2;
        font-size: 1.35rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .content-card p {
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 1.25rem;
        font-size: 1rem;
    }

    .content-card ul {
        color: #4b5563;
        line-height: 1.8;
        margin-left: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .content-card li {
        margin-bottom: 0.75rem;
    }

    .content-card li strong {
        color: #667eea;
        font-weight: 600;
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
        font-size: 0.95rem;
    }

    .cta-link {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .cta-link:hover {
        color: #764ba2;
        text-decoration: underline;
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
            <i class="bi bi-info-circle"></i>
            About Us
        </h1>
        <p>Empowering productivity, one task at a time.</p>
    </div>

    <div class="content-card">
        <h2>Our Story</h2>
        <p>
            MyTodos was born from a simple idea: task management should be intuitive, efficient, and beautiful.
            In 2025, our team set out to create a platform that helps individuals and teams stay organized
            without the complexity of traditional project management tools.
        </p>
        <p>
            We believe that productivity isn't about doing more—it's about doing what matters. That's why
            we've designed MyTodos to be simple yet powerful, helping you focus on your priorities and
            achieve your goals.
        </p>
    </div>

    <div class="content-card">
        <h2>Our Mission</h2>
        <p>
            To provide the world's most intuitive task management platform that helps people accomplish
            their goals efficiently and with joy.
        </p>

        <h3>What We Value</h3>
        <ul>
            <li><strong>Simplicity:</strong> We believe the best tools are the ones that get out of your way.</li>
            <li><strong>Efficiency:</strong> Every feature is designed to save you time and mental energy.</li>
            <li><strong>Privacy:</strong> Your tasks and data are yours alone—we take security seriously.</li>
            <li><strong>Accessibility:</strong> Great productivity tools should be available to everyone.</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Why Choose MyTodos?</h2>
        <div class="info-grid">
            <div class="info-item">
                <h4><i class="bi bi-bullseye"></i> Focused Design</h4>
                <p>Clean interface that keeps you focused on what matters most.</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-lightning-charge"></i> Lightning Fast</h4>
                <p>Quick loading times and responsive interactions.</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-shield-lock"></i> Secure & Private</h4>
                <p>Your data is encrypted and protected at all times.</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-phone"></i> Cross-Platform</h4>
                <p>Access your todos from any device, anywhere.</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <h2>Join Our Community</h2>
        <p>
            MyTodos is trusted by thousands of users worldwide who manage their daily tasks, projects,
            and goals with our platform. Whether you're a student, professional, freelancer, or team leader,
            MyTodos adapts to your workflow.
        </p>
        <p>
            Ready to take control of your productivity? <a href="{{ route('todos.index') }}" class="cta-link">Get started today!</a>
        </p>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Privacy Policy')

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
        font-size: 1rem;
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
            <i class="bi bi-shield-lock"></i>
            Privacy Policy
        </h1>
        <p>Last updated: {{ date('F d, Y') }}</p>
    </div>

    <div class="content-card">
        <h2>Introduction</h2>
        <p>
            At MyTodos, we take your privacy seriously. This Privacy Policy explains how we collect, use,
            disclose, and safeguard your information when you use our task management platform.
        </p>
        <p>
            Please read this privacy policy carefully. If you do not agree with the terms of this privacy
            policy, please do not access the application.
        </p>
    </div>

    <div class="content-card">
        <h2>Information We Collect</h2>

        <h3>Personal Information</h3>
        <p>We may collect personal information that you voluntarily provide to us when you:</p>
        <ul>
            <li>Register for an account</li>
            <li>Create and manage tasks</li>
            <li>Contact our support team</li>
            <li>Subscribe to our newsletter</li>
        </ul>
        <p>This information may include:</p>
        <ul>
            <li>Name and email address</li>
            <li>Account credentials</li>
            <li>Task and project data</li>
            <li>Profile information</li>
        </ul>

        <h3>Automatically Collected Information</h3>
        <p>When you use MyTodos, we may automatically collect certain information, including:</p>
        <ul>
            <li>Device information (IP address, browser type, operating system)</li>
            <li>Usage data (pages viewed, time spent, features used)</li>
            <li>Cookies and similar tracking technologies</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Provide, operate, and maintain our services</li>
            <li>Improve and personalize your experience</li>
            <li>Process your transactions and manage your account</li>
            <li>Send you updates, notifications, and support messages</li>
            <li>Protect against fraudulent or illegal activity</li>
            <li>Comply with legal obligations</li>
            <li>Analyze usage patterns to improve our platform</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Data Security</h2>
        <p>
            We implement appropriate technical and organizational security measures to protect your
            personal information against unauthorized access, alteration, disclosure, or destruction.
        </p>
        <p>Our security measures include:</p>
        <ul>
            <li>Encryption of data in transit and at rest</li>
            <li>Regular security audits and testing</li>
            <li>Secure authentication mechanisms</li>
            <li>Limited access to personal data</li>
            <li>Regular backups and disaster recovery procedures</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Data Sharing and Disclosure</h2>
        <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>
        <ul>
            <li><strong>Service Providers:</strong> We may share data with trusted third-party service providers who assist us in operating our platform.</li>
            <li><strong>Legal Requirements:</strong> We may disclose information if required by law or in response to valid legal requests.</li>
            <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred.</li>
            <li><strong>With Your Consent:</strong> We may share information with your explicit permission.</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Your Privacy Rights</h2>
        <p>You have the right to:</p>
        <ul>
            <li>Access the personal information we hold about you</li>
            <li>Request correction of inaccurate or incomplete data</li>
            <li>Request deletion of your personal information</li>
            <li>Object to or restrict certain processing activities</li>
            <li>Export your data in a portable format</li>
            <li>Withdraw consent at any time</li>
        </ul>
        <p>To exercise these rights, please contact us at <a href="mailto:privacy@mytodos.com" style="color: #667eea; font-weight: 600;">privacy@mytodos.com</a>.</p>
    </div>

    <div class="content-card">
        <h2>Cookies and Tracking Technologies</h2>
        <p>
            We use cookies and similar tracking technologies to enhance your experience. You can control
            cookie preferences through your browser settings. However, disabling cookies may affect the
            functionality of our platform.
        </p>
    </div>

    <div class="content-card">
        <h2>Children's Privacy</h2>
        <p>
            MyTodos is not intended for users under the age of 13. We do not knowingly collect personal
            information from children. If you believe we have collected information from a child, please
            contact us immediately.
        </p>
    </div>

    <div class="content-card">
        <h2>Changes to This Privacy Policy</h2>
        <p>
            We may update this Privacy Policy from time to time. We will notify you of any changes by
            posting the new Privacy Policy on this page and updating the "Last updated" date.
        </p>
    </div>

    <div class="content-card">
        <h2>Contact Us</h2>
        <p>If you have questions or concerns about this Privacy Policy, please contact us:</p>
        <div class="info-grid">
            <div class="info-item">
                <h4><i class="bi bi-envelope-fill"></i> Email</h4>
                <p>privacy@mytodos.com</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-geo-alt-fill"></i> Address</h4>
                <p>123 Todo Street<br>Productivity City, PC 12345</p>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Terms of Service')

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
            <i class="bi bi-file-text"></i>
            Terms of Service
        </h1>
        <p>Last updated: {{ date('F d, Y') }}</p>
    </div>

    <div class="content-card">
        <h2>Agreement to Terms</h2>
        <p>
            By accessing or using MyTodos, you agree to be bound by these Terms of Service and all applicable
            laws and regulations. If you do not agree with any of these terms, you are prohibited from using
            or accessing this platform.
        </p>
    </div>

    <div class="content-card">
        <h2>Use License</h2>
        <p>
            Permission is granted to temporarily access and use MyTodos for personal, non-commercial purposes.
            This is the grant of a license, not a transfer of title, and under this license you may not:
        </p>
        <ul>
            <li>Modify or copy the materials</li>
            <li>Use the materials for any commercial purpose or public display</li>
            <li>Attempt to decompile or reverse engineer any software contained on MyTodos</li>
            <li>Remove any copyright or other proprietary notations from the materials</li>
            <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>User Account Responsibilities</h2>
        <p>When you create an account with us, you must provide accurate, complete, and current information. You are responsible for:</p>
        <ul>
            <li>Maintaining the confidentiality of your account and password</li>
            <li>All activities that occur under your account</li>
            <li>Notifying us immediately of any unauthorized use of your account</li>
            <li>Ensuring that you exit from your account at the end of each session</li>
        </ul>
        <p>
            We reserve the right to refuse service, terminate accounts, or remove or edit content at our
            sole discretion.
        </p>
    </div>

    <div class="content-card">
        <h2>Acceptable Use Policy</h2>
        <p>You agree not to use MyTodos to:</p>
        <ul>
            <li>Upload, transmit, or distribute any content that is illegal, harmful, threatening, abusive, harassing, defamatory, vulgar, obscene, or otherwise objectionable</li>
            <li>Impersonate any person or entity or misrepresent your affiliation with a person or entity</li>
            <li>Interfere with or disrupt the platform or servers or networks connected to the platform</li>
            <li>Attempt to gain unauthorized access to any portion of the platform or any other systems or networks</li>
            <li>Use any automated means to access the platform for any purpose without our express written permission</li>
            <li>Collect or harvest any personally identifiable information from the platform</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Content Ownership and Usage Rights</h2>

        <h3>Your Content</h3>
        <p>
            You retain all rights to any content you submit, post, or display on or through MyTodos.
            By submitting content, you grant us a worldwide, non-exclusive, royalty-free license to use,
            copy, reproduce, process, adapt, modify, publish, transmit, display, and distribute such content
            for the purpose of providing our services to you.
        </p>

        <h3>Our Content</h3>
        <p>
            The platform and its original content (excluding content provided by users), features, and
            functionality are and will remain the exclusive property of MyTodos and its licensors.
        </p>
    </div>

    <div class="content-card">
        <h2>Data Backup and Loss</h2>
        <p>
            While we implement regular backups and security measures, you are responsible for maintaining
            your own backup copies of any data you store on MyTodos. We are not liable for any loss or
            corruption of your data.
        </p>
    </div>

    <div class="content-card">
        <h2>Service Availability</h2>
        <p>
            We strive to provide reliable and uninterrupted service, but we do not guarantee that:
        </p>
        <ul>
            <li>The platform will be available at all times or without interruption</li>
            <li>Defects will be corrected immediately</li>
            <li>The platform will be free from viruses or other harmful components</li>
            <li>The results obtained from using the platform will be accurate or reliable</li>
        </ul>
        <p>
            We reserve the right to modify, suspend, or discontinue the platform (or any part thereof)
            at any time with or without notice.
        </p>
    </div>

    <div class="content-card">
        <h2>Limitation of Liability</h2>
        <p>
            To the maximum extent permitted by applicable law, MyTodos shall not be liable for any indirect,
            incidental, special, consequential, or punitive damages, or any loss of profits or revenues,
            whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible losses.
        </p>
    </div>

    <div class="content-card">
        <h2>Indemnification</h2>
        <p>
            You agree to defend, indemnify, and hold harmless MyTodos and its licensors, employees,
            contractors, agents, officers, and directors from any claims, damages, obligations, losses,
            liabilities, costs, or expenses arising from:
        </p>
        <ul>
            <li>Your use of and access to the platform</li>
            <li>Your violation of any term of these Terms of Service</li>
            <li>Your violation of any third-party right, including intellectual property rights</li>
            <li>Any claim that your content caused damage to a third party</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Payment and Subscription Terms</h2>
        <p>
            If you choose to purchase a paid subscription or service:
        </p>
        <ul>
            <li>All fees are in USD and are non-refundable except as required by law</li>
            <li>Subscriptions automatically renew unless cancelled before the renewal date</li>
            <li>We reserve the right to change our pricing with 30 days' notice</li>
            <li>You are responsible for all applicable taxes</li>
        </ul>
    </div>

    <div class="content-card">
        <h2>Termination</h2>
        <p>
            We may terminate or suspend your account immediately, without prior notice or liability,
            for any reason, including if you breach the Terms of Service.
        </p>
        <p>
            Upon termination, your right to use the platform will immediately cease. If you wish to
            terminate your account, you may simply discontinue using the platform or contact us.
        </p>
    </div>

    <div class="content-card">
        <h2>Governing Law</h2>
        <p>
            These Terms shall be governed and construed in accordance with the laws of the jurisdiction
            in which MyTodos operates, without regard to its conflict of law provisions.
        </p>
    </div>

    <div class="content-card">
        <h2>Changes to Terms</h2>
        <p>
            We reserve the right to modify or replace these Terms at any time. If a revision is material,
            we will try to provide at least 30 days' notice prior to any new terms taking effect.
        </p>
        <p>
            By continuing to access or use our platform after revisions become effective, you agree to be
            bound by the revised terms.
        </p>
    </div>

    <div class="content-card">
        <h2>Contact Information</h2>
        <p>If you have any questions about these Terms of Service, please contact us:</p>
        <div class="info-grid">
            <div class="info-item">
                <h4><i class="bi bi-envelope-fill"></i> Email</h4>
                <p>legal@mytodos.com</p>
            </div>
            <div class="info-item">
                <h4><i class="bi bi-geo-alt-fill"></i> Address</h4>
                <p>123 Todo Street<br>Productivity City, PC 12345</p>
            </div>
        </div>
    </div>
</div>
@endsection

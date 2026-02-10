<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" type="image/x-icon">
    
    <title>Datascope | Fuliza Limit Increase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    /* =========================
    M-PESA THEME COLORS
    ========================= */
    :root {
        --mpesa-green: #00A859;
        --mpesa-green-dark: #008547;
        --mpesa-gold: #FFB700;
        --mpesa-light: #F0F9F5;
        --mpesa-gray: #6B7280;
        --mpesa-dark: #111827;
        --border: #D1D5DB;
        --shadow: 0 10px 25px rgba(0,168,89,0.08);
        --radius: 12px;
    }
    
    /* =========================
    BASE STYLES
    ========================= */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #F0F9F5 0%, #FFFFFF 100%);
        color: var(--mpesa-dark);
        line-height: 1.6;
        min-height: 100vh;
    }
    
    /* =========================
    TOP BAR - M-PESA STYLE
    ========================= */
    .topbar {
        background: white;
        border-bottom: 3px solid var(--mpesa-green);
        padding: 16px 24px;
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0,168,89,0.1);
    }
    
    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .logo {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--mpesa-green), var(--mpesa-green-dark));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(0,168,89,0.2);
    }
    
    .brand-text h2 {
        font-size: 18px;
        font-weight: 800;
        color: var(--mpesa-green-dark);
        letter-spacing: -0.5px;
    }
    
    .brand-text p {
        font-size: 12px;
        color: var(--mpesa-gray);
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .mpesa-badge {
        background: var(--mpesa-green);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
    }
    
    .support-btn {
        background: white;
        border: 2px solid var(--mpesa-green);
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--mpesa-green);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .support-btn:hover {
        background: var(--mpesa-green);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,168,89,0.2);
    }
    
    .support-btn::before {
        content: "📦";
        font-size: 16px;
    }
    
    /* =========================
    HERO SECTION - M-PESA STYLE
    ========================= */
    .hero {
        padding: 60px 20px;
        display: flex;
        justify-content: center;
    }
    
    .hero-card {
        background: white;
        max-width: 600px;
        width: 100%;
        padding: 40px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        text-align: center;
        border: 2px solid var(--mpesa-green);
        position: relative;
        overflow: hidden;
    }
    
    .hero-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--mpesa-green), var(--mpesa-gold));
    }
    
    .mpesa-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #E8F7F0, #F0F9F5);
        color: var(--mpesa-green-dark);
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
        border: 1px solid rgba(0,168,89,0.1);
    }
    
    .mpesa-dot {
        width: 10px;
        height: 10px;
        background: var(--mpesa-green);
        border-radius: 50%;
        position: relative;
        animation: pulse-green 2s infinite;
    }
    
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(0,168,89,0.4); }
        70% { box-shadow: 0 0 0 10px rgba(0,168,89,0); }
        100% { box-shadow: 0 0 0 0 rgba(0,168,89,0); }
    }
    
    .hero h1 {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 16px;
        line-height: 1.2;
    }
    
    .hero-title {
        background: linear-gradient(135deg, var(--mpesa-green), var(--mpesa-green-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    
    .hero-subtitle {
        color: var(--mpesa-gold);
        font-weight: 700;
    }
    
    .hero p {
        color: var(--mpesa-gray);
        font-size: 17px;
        margin-bottom: 32px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
    }
    
    .cta-btn {
        background: linear-gradient(135deg, var(--mpesa-green), var(--mpesa-green-dark));
        color: white;
        border: none;
        padding: 20px 40px;
        border-radius: 12px;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.5px;
    }
    
    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,168,89,0.25);
    }
    
    .cta-btn::after {
        content: "→";
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .cta-btn:hover::after {
        opacity: 1;
        right: 25px;
    }
    
    .trust-badges {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }
    
    .trust-badge {
        background: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        color: var(--mpesa-gray);
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    .trust-badge:hover {
        border-color: var(--mpesa-green);
        transform: translateY(-2px);
    }
    
    .trust-badge.mpesa-highlight {
        background: linear-gradient(135deg, #FFFBEB, #FEF3C7);
        border-color: var(--mpesa-gold);
        color: #92400E;
        font-weight: 600;
    }
    
    /* =========================
    PACKAGES SECTION - M-PESA STYLE
    ========================= */
    .packages-section {
        padding: 60px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-title h2 {
        font-size: 32px;
        font-weight: 800;
        color: var(--mpesa-green-dark);
        margin-bottom: 12px;
        position: relative;
        display: inline-block;
    }
    
    .section-title h2::after {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--mpesa-gold);
        border-radius: 2px;
    }
    
    .section-title p {
        color: var(--mpesa-gray);
        font-size: 17px;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 60px;
    }
    
    .package-card {
        background: white;
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: var(--shadow);
        border: 2px solid transparent;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .package-card:hover {
        border-color: var(--mpesa-green);
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,168,89,0.15);
    }
    
    .package-card.popular {
        border-color: var(--mpesa-gold);
        position: relative;
        transform: scale(1.02);
    }
    
    .popular-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: linear-gradient(135deg, var(--mpesa-gold), #FF9900);
        color: #92400E;
        padding: 8px 24px;
        font-size: 12px;
        font-weight: 800;
        border-bottom-left-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .package-header {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--mpesa-light);
    }
    
    .package-limit {
        font-size: 28px;
        font-weight: 800;
        color: var(--mpesa-green-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .package-limit::before {
        content: "💰";
        font-size: 24px;
    }
    
    .package-fee {
        font-size: 24px;
        color: var(--mpesa-green);
        font-weight: 700;
        background: var(--mpesa-light);
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-block;
    }
    
    .package-features {
        list-style: none;
        margin-bottom: 30px;
        flex-grow: 1;
    }
    
    .package-features li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        color: var(--mpesa-dark);
        font-size: 15px;
        padding: 4px 0;
    }
    
    .package-features li::before {
        content: "✓";
        color: var(--mpesa-green);
        font-weight: bold;
        font-size: 16px;
        background: var(--mpesa-light);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .select-btn {
        background: linear-gradient(135deg, var(--mpesa-green), var(--mpesa-green-dark));
        color: white;
        border: none;
        padding: 16px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: auto;
    }
    
    .select-btn:hover {
        background: linear-gradient(135deg, var(--mpesa-green-dark), #006B38);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,168,89,0.25);
    }
    
    /* =========================
    PAYMENT MODAL - M-PESA STYLE
    ========================= */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }
    
    .modal-card {
        background: white;
        border-radius: var(--radius);
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.4s ease;
        border: 3px solid var(--mpesa-green);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    @keyframes slideIn {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .modal-header {
        padding: 24px;
        border-bottom: 2px solid var(--mpesa-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, var(--mpesa-light), white);
    }
    
    .modal-header h3 {
        font-size: 22px;
        font-weight: 800;
        color: var(--mpesa-green-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-header h3::before {
        content: "💳";
        font-size: 24px;
    }
    
    .close-btn {
        background: var(--mpesa-light);
        border: none;
        font-size: 24px;
        color: var(--mpesa-gray);
        cursor: pointer;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .close-btn:hover {
        background: var(--mpesa-green);
        color: white;
        transform: rotate(90deg);
    }
    
    .modal-body {
        padding: 30px;
    }
    
    .selected-package {
        background: linear-gradient(135deg, var(--mpesa-light), #E8F7F0);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        text-align: center;
        border: 2px solid var(--mpesa-green);
    }
    
    .selected-package h4 {
        font-size: 20px;
        font-weight: 700;
        color: var(--mpesa-green-dark);
        margin-bottom: 8px;
    }
    
    .selected-package p {
        color: var(--mpesa-green);
        font-weight: 800;
        font-size: 18px;
        background: white;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-block;
        border: 1px solid var(--mpesa-green);
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-group label {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: var(--mpesa-dark);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-group label::before {
        font-size: 18px;
    }
    
    #idNumber + .form-group label::before {
        content: "🆔";
    }
    
    #phoneNumber + .form-group label::before {
        content: "📱";
    }
    
    .form-control {
        width: 100%;
        padding: 16px;
        border: 2px solid var(--border);
        border-radius: 10px;
        font-size: 16px;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--mpesa-green);
        box-shadow: 0 0 0 3px rgba(0,168,89,0.1);
    }
    
    .form-control::placeholder {
        color: var(--mpesa-gray);
        opacity: 0.6;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, var(--mpesa-green), var(--mpesa-green-dark));
        color: white;
        border: none;
        padding: 18px;
        border-radius: 10px;
        font-size: 17px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 10px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }
    
    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,168,89,0.25);
        background: linear-gradient(135deg, var(--mpesa-green-dark), #006B38);
    }
    
    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .submit-btn::after {
        content: "📱";
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover:not(:disabled)::after {
        opacity: 1;
        right: 15px;
    }
    
    .status-message {
        padding: 16px;
        border-radius: 10px;
        margin-top: 20px;
        font-size: 15px;
        display: none;
        border: 2px solid transparent;
        font-weight: 500;
    }
    
    .status-success {
        background: #D1FAE5;
        color: #065F46;
        border-color: #A7F3D0;
    }
    
    .status-error {
        background: #FEE2E2;
        color: #991B1B;
        border-color: #FECACA;
    }
    
    .status-info {
        background: #DBEAFE;
        color: #1E40AF;
        border-color: #BFDBFE;
    }
    
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .mpesa-note {
        text-align: center;
        margin-top: 20px;
        padding: 16px;
        background: var(--mpesa-light);
        border-radius: 10px;
        font-size: 14px;
        color: var(--mpesa-green-dark);
        border: 1px solid var(--mpesa-green);
    }
    
    .mpesa-note strong {
        color: var(--mpesa-gold);
    }
    
    /* =========================
    FOOTER - M-PESA STYLE
    ========================= */
    .footer {
        text-align: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, var(--mpesa-dark), #1F2937);
        color: white;
        margin-top: 60px;
        border-top: 4px solid var(--mpesa-green);
    }
    
    .footer-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .footer-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .footer-logo .logo {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .footer-logo h3 {
        font-size: 18px;
        font-weight: 700;
        color: white;
    }
    
    .footer p {
        color: #D1D5DB;
        font-size: 14px;
        margin-bottom: 12px;
        line-height: 1.6;
    }
    
    .footer-partners {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .partner-badge {
        background: rgba(255,255,255,0.1);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    /* =========================
    RESPONSIVE DESIGN
    ========================= */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 28px;
        }
        
        .packages-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .package-card.popular {
            transform: none;
        }
        
        .modal-card {
            margin: 10px;
        }
        
        .trust-badges {
            flex-direction: column;
            align-items: center;
        }
        
        .trust-badge {
            width: 100%;
            justify-content: center;
        }
        
        .footer-partners {
            flex-direction: column;
            gap: 10px;
        }
    }
    
    @media (max-width: 480px) {
        .topbar {
            padding: 12px 16px;
        }
        
        .hero-card {
            padding: 30px 20px;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .section-title h2 {
            font-size: 26px;
        }
    }
    
    /* =========================
    SCROLL ANIMATION
    ========================= */
    .hidden-section {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .visible-section {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* =========================
    SCROLLBAR STYLING
    ========================= */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--mpesa-light);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--mpesa-green);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--mpesa-green-dark);
    }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <header class="topbar">
        <div class="brand">
            <div class="logo">D</div>
            <div class="brand-text">
                <h2>Datascope Fuliza</h2>
                <p>Increase Limit • <span class="mpesa-badge">M-PESA STK</span> • Instant</p>
            </div>
        </div>
        <button class="support-btn" onclick="scrollToPackages()">View Packages</button>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-card">
            <div class="mpesa-pill">
                <span class="mpesa-dot"></span>
                Secure • STK Push • Instant
            </div>
            
            <h1>
                <span class="hero-title">Increase Your Fuliza Limit</span><br>
                <span class="hero-subtitle">With M-Pesa Simplicity</span>
            </h1>
            
            <p>Select your desired Fuliza limit, pay instantly via M-Pesa STK Push, and watch your limit increase in real-time. Trusted by thousands of Kenyans.</p>
            
            <button class="cta-btn" onclick="scrollToPackages()">
                INCREASE YOUR LIMIT NOW
            </button>
            
            <div class="trust-badges">
                <div class="trust-badge">
                    <span>🔐</span> M-Pesa Secured
                </div>
                <div class="trust-badge mpesa-highlight">
                    <span>⚡</span> Instant Processing
                </div>
                <div class="trust-badge">
                    <span>✅</span> 100% Verified
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="packages-section hidden-section" id="packages">
        <div class="section-title">
            <h2>Choose Your Fuliza Package</h2>
            <p>Select a package that matches your needs. All payments are processed securely via M-Pesa STK Push.</p>
        </div>
        
        <div class="packages-grid">
            @if(isset($packages) && count($packages) > 0)
                @foreach($packages as $package)
                <div class="package-card {{ $package['id'] == 3 ? 'popular' : '' }}">
                    @if($package['id'] == 3)
                    <div class="popular-badge">MOST POPULAR</div>
                    @endif
                    
                    <div class="package-header">
                        <div class="package-limit">{{ $package['limit'] }}</div>
                        <div class="package-fee">{{ $package['fee'] }}</div>
                    </div>
                    
                    <ul class="package-features">
                        <li>Instant limit increase within minutes</li>
                        <li>One-time processing fee</li>
                        <li>M-Pesa STK Push payment</li>
                        <li>24/7 customer support</li>
                        <li>No hidden charges</li>
                    </ul>
                    
                    <button class="select-btn" onclick="selectPackage(
                        '{{ $package['limit'] }}',
                        '{{ $package['fee'] }}',
                        {{ $package['amount'] }},
                        '{{ $package['id'] }}'
                    )">
                        Select This Package
                    </button>
                </div>
                @endforeach
            @else
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 40px; background: white; border-radius: var(--radius); border: 2px solid var(--mpesa-green);">
                    <div style="font-size: 48px; margin-bottom: 20px;">📦</div>
                    <h3 style="color: var(--mpesa-green-dark); margin-bottom: 12px; font-size: 24px;">Packages Coming Soon</h3>
                    <p style="color: var(--mpesa-gray); max-width: 400px; margin: 0 auto;">We're updating our packages. Please check back in a few minutes.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Payment Modal -->
    <div class="modal-overlay" id="paymentModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Complete Your Payment</h3>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            
            <div class="modal-body">
                <div class="selected-package" id="selectedPackageInfo">
                    <h4 id="selectedLimit">—</h4>
                    <p id="selectedFee">—</p>
                </div>
                
                <form id="paymentForm">
                    @csrf
                    <input type="hidden" id="packageId">
                    <input type="hidden" id="packageAmount">
                    
                    <div class="form-group">
                        <label for="idNumber">National ID Number</label>
                        <input type="text" 
                               id="idNumber" 
                               class="form-control" 
                               placeholder="Enter your 8-digit ID number"
                               maxlength="9"
                               required>
                        <small style="color: var(--mpesa-gray); font-size: 13px; display: block; margin-top: 6px;">Must be 7-9 digits (without dashes)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="phoneNumber">M-Pesa Phone Number</label>
                        <input type="tel" 
                               id="phoneNumber" 
                               class="form-control" 
                               placeholder="07XXXXXXXX"
                               maxlength="10"
                               required>
                        <small style="color: var(--mpesa-gray); font-size: 13px; display: block; margin-top: 6px;">Must start with 07 and be 10 digits</small>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submitBtn">
                        PAY VIA M-PESA STK
                    </button>
                    
                    <div class="status-message" id="statusMessage"></div>
                </form>
                
                <div class="mpesa-note">
                    <p><strong>Note:</strong> You will receive an M-Pesa STK Push on your phone. Enter your <strong>M-Pesa PIN</strong> to complete the payment.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">
                <div class="logo">D</div>
                <h3>Datascope Fuliza Service</h3>
            </div>
            
            <p>© <span id="currentYear"></span> Datascope Fuliza Limit Increase Service</p>
           
            
            <div class="footer-partners">
                <div class="partner-badge">
                    <span>🔒</span> M-Pesa Secured
                </div>
                <div class="partner-badge">
                    <span>⚡</span> PayHero Powered
                </div>
                <div class="partner-badge">
                    <span>✅</span> SSL Encrypted
                </div>
            </div>
            
           
        </div>
    </footer>

    <script>
        // Global variables
        let selectedPackageData = null;
        let checkoutRequestId = null;
        let statusCheckInterval = null;
        
        // Scroll to packages
        function scrollToPackages() {
            const packagesSection = document.getElementById('packages');
            packagesSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        // Select package
        function selectPackage(limit, fee, amount, packageId) {
            selectedPackageData = {
                limit: limit,
                fee: fee,
                amount: amount,
                packageId: packageId
            };
            
            document.getElementById('selectedLimit').textContent = limit;
            document.getElementById('selectedFee').textContent = fee;
            document.getElementById('packageId').value = packageId;
            document.getElementById('packageAmount').value = amount;
            
            document.getElementById('paymentModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Focus on first input
            setTimeout(() => {
                document.getElementById('idNumber').focus();
            }, 300);
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('paymentModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
        }
        
        // Reset form
        function resetForm() {
            document.getElementById('paymentForm').reset();
            document.getElementById('statusMessage').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn').innerHTML = 'PAY VIA M-PESA STK';
            
            if (statusCheckInterval) {
                clearInterval(statusCheckInterval);
                statusCheckInterval = null;
            }
        }
        
        // Show status message
        function showStatus(message, type) {
            const statusDiv = document.getElementById('statusMessage');
            statusDiv.textContent = message;
            statusDiv.className = `status-message status-${type}`;
            statusDiv.style.display = 'block';
            
            // Auto-hide error messages after 10 seconds
            if (type === 'error') {
                setTimeout(() => {
                    statusDiv.style.display = 'none';
                }, 10000);
            }
        }
        
        // Validate inputs
        function validateInputs() {
            const idNumber = document.getElementById('idNumber').value.trim();
            const phone = document.getElementById('phoneNumber').value.trim();
            
            // Validate ID number
            if (!/^\d{7,9}$/.test(idNumber)) {
                showStatus('Please enter a valid 7-9 digit ID number (numbers only)', 'error');
                return false;
            }
            
            // Validate phone number
            if (!/^07\d{8}$/.test(phone)) {
                showStatus('Please enter a valid Safaricom number (07XXXXXXXX, 10 digits)', 'error');
                return false;
            }
            
            return true;
        }
        
        // Process payment
        async function processPayment(event) {
            event.preventDefault();
            
            if (!validateInputs()) {
                return;
            }
            
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading"></span> SENDING STK REQUEST...';
            
            const formData = {
                phone: document.getElementById('phoneNumber').value,
                amount: document.getElementById('packageAmount').value,
                id_number: document.getElementById('idNumber').value,
                limit_amount: selectedPackageData.limit,
                package_name: `Fuliza ${selectedPackageData.limit} Package`,
                _token: document.querySelector('input[name="_token"]').value
            };
            
            try {
                const response = await fetch('/process-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();

                console.log('Payment response:', result);
                
                if (result.success) {
                    showStatus('✅ ' + result.message + ' Check your phone for the M-Pesa STK Push.', 'success');
                    checkoutRequestId = result.checkout_request_id;
                    
                    // Start checking payment status
                    startStatusCheck();
                    
                    // Update button text
                    submitBtn.innerHTML = '⏳ WAITING FOR PAYMENT...';
                    
                } else {
                    showStatus('❌ ' + (result.message || 'Payment failed. Please try again.'), 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'PAY VIA M-PESA STK';
                }
                
            } catch (error) {
                showStatus('❌ Network error. Please check your internet connection.', 'error');
                console.log('Payment processing error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'PAY VIA M-PESA STK';
            }
        }
        
        // Start checking payment status
        function startStatusCheck() {
            if (statusCheckInterval) {
                clearInterval(statusCheckInterval);
            }
            
            let attempts = 0;
            const maxAttempts = 72; // 6 minutes (check every 5 seconds)
            
            statusCheckInterval = setInterval(async () => {
                attempts++;
                
                if (attempts > maxAttempts) {
                    clearInterval(statusCheckInterval);
                    showStatus('⏰ Payment timeout. Please check your M-Pesa messages or try again.', 'error');
                    document.getElementById('submitBtn').innerHTML = 'TRY AGAIN';
                    document.getElementById('submitBtn').disabled = false;
                    return;
                }
                
                try {
                    const response = await fetch('/check-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ 
                            checkout_request_id: checkoutRequestId,
                            _token: document.querySelector('input[name="_token"]').value
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        if (result.status === 'success' && result.is_successful) {
                            // Payment successful
                            clearInterval(statusCheckInterval);
                            showStatus(`✅ Payment successful! Your Fuliza limit has been increased to ${result.fuliza_limit}. M-Pesa Receipt: ${result.mpesa_receipt_number}`, 'success');
                            document.getElementById('submitBtn').innerHTML = '✅ PAYMENT COMPLETE';
                            document.getElementById('submitBtn').style.background = 'linear-gradient(135deg, #10B981, #059669)';
                            
                            // Auto-close modal after 8 seconds
                            setTimeout(() => {
                                closeModal();
                                alert(`🎉 Payment Successful!\n\nYour Fuliza limit is now ${result.fuliza_limit}.\nM-Pesa Receipt: ${result.mpesa_receipt_number}\n\nCheck your M-Pesa message for confirmation.`);
                            }, 8000);
                            
                        } else if (result.status === 'failed') {
                            // Payment failed
                            clearInterval(statusCheckInterval);
                            showStatus(`❌ Payment failed: ${result.result_desc}`, 'error');
                            document.getElementById('submitBtn').innerHTML = 'TRY AGAIN';
                            document.getElementById('submitBtn').disabled = false;
                        }
                    }
                    
                } catch (error) {
                    console.error('Status check error:', error);
                }
            }, 5000); // Check every 5 seconds
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set current year in footer
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            // Form submission
            document.getElementById('paymentForm').addEventListener('submit', processPayment);
            
            // Input validation and formatting
            document.getElementById('idNumber').addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 9) {
                    this.value = this.value.slice(0, 9);
                }
            });
            
            document.getElementById('phoneNumber').addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
                // Auto-add 07 if starts with 7
                if (this.value.length === 9 && this.value.startsWith('7')) {
                    this.value = '0' + this.value;
                }
            });
            
            // Scroll animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible-section');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.hidden-section').forEach(section => {
                observer.observe(section);
            });
            
            // Close modal on overlay click
            document.getElementById('paymentModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
            
            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
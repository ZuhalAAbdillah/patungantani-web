<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'PatunganTani.id') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', system-ui, -apple-system, sans-serif; -webkit-font-smoothing: antialiased; }

            /* ── Loading Overlay ── */
            .loading-overlay {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: #fff; z-index: 9999;
                display: flex; flex-direction: column;
                align-items: center; justify-content: center;
                transition: opacity 0.5s ease, visibility 0.5s ease;
            }
            .loading-overlay.hidden {
                opacity: 0; visibility: hidden; pointer-events: none;
            }
            .loading-logo {
                width: 64px; height: 64px;
                animation: logoBreath 1.8s ease-in-out infinite;
                filter: drop-shadow(0 4px 20px rgba(15, 43, 31, 0.15));
            }
            .loading-ring {
                width: 88px; height: 88px; position: absolute;
                border: 3px solid transparent;
                border-top-color: #16A34A;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            .loading-ring-outer {
                width: 104px; height: 104px; position: absolute;
                border: 2px solid transparent;
                border-bottom-color: #22C55E;
                border-radius: 50%;
                animation: spin 1.5s linear infinite reverse;
            }
            .loading-text {
                margin-top: 32px; font-size: 14px; font-weight: 600;
                color: #6B7280; letter-spacing: 0.5px;
            }
            .loading-dots::after {
                content: ''; animation: dots 1.5s steps(3, end) infinite;
            }
            @keyframes logoBreath {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.08); opacity: 0.8; }
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            @keyframes dots {
                0% { content: ''; }
                33% { content: '.'; }
                66% { content: '..'; }
                100% { content: '...'; }
            }

            /* ── Auth Page Layout ── */
            .auth-page {
                min-height: 100vh; display: flex;
            }

            /* ── Left Panel (Brand) ── */
            .auth-brand {
                flex: 65; background: linear-gradient(160deg, #0A1F14 0%, #0F2B1F 40%, #166534 100%);
                display: flex; flex-direction: column; justify-content: center; align-items: center;
                padding: 60px; position: relative; overflow: hidden;
            }
            .auth-brand::before {
                content: ''; position: absolute; top: -200px; right: -200px;
                width: 500px; height: 500px; border-radius: 50%;
                background: rgba(22, 163, 74, 0.08); pointer-events: none;
            }
            .auth-brand::after {
                content: ''; position: absolute; bottom: -250px; left: -150px;
                width: 600px; height: 600px; border-radius: 50%;
                background: rgba(34, 197, 94, 0.06); pointer-events: none;
            }
            .auth-brand-content {
                position: relative; z-index: 1; text-align: center;
                max-width: 480px; animation: fadeInUp 0.8s ease;
            }
            .auth-brand-logo {
                width: 72px; height: 72px; filter: brightness(0) invert(1);
                margin-bottom: 32px; filter: brightness(0) invert(1) drop-shadow(0 4px 16px rgba(255,255,255,0.15));
                animation: float 4s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .auth-brand h1 {
                font-size: 36px; font-weight: 900; color: #fff;
                letter-spacing: -1.5px; line-height: 1.15; margin-bottom: 16px;
            }
            .auth-brand h1 span {
                background: linear-gradient(135deg, #4ADE80, #22C55E);
                -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .auth-brand p {
                font-size: 15px; color: rgba(255,255,255,0.5);
                line-height: 1.7; margin-bottom: 40px;
            }

            /* ── Brand Stats ── */
            .auth-brand-stats {
                display: flex; gap: 32px; justify-content: center;
                width: 100%;
            }
            .auth-stat {
                text-align: center; padding: 16px 0;
            }
            .auth-stat-value {
                font-size: 28px; font-weight: 800; color: #fff;
            }
            .auth-stat-label {
                font-size: 12px; color: rgba(255,255,255,0.4);
                margin-top: 2px; letter-spacing: 0.3px;
            }
            .auth-stat-divider {
                width: 1px; background: rgba(255,255,255,0.1);
            }

            /* ── Floating Particles (Decorative) ── */
            .particle {
                position: absolute; border-radius: 50%;
                background: rgba(34, 197, 94, 0.15);
                animation: particleFloat 8s ease-in-out infinite;
                pointer-events: none;
            }
            .particle:nth-child(1) { width: 8px; height: 8px; top: 15%; left: 20%; animation-delay: 0s; }
            .particle:nth-child(2) { width: 6px; height: 6px; top: 75%; left: 15%; animation-delay: 2s; }
            .particle:nth-child(3) { width: 10px; height: 10px; top: 30%; right: 25%; animation-delay: 4s; }
            .particle:nth-child(4) { width: 5px; height: 5px; top: 60%; right: 10%; animation-delay: 1s; }
            .particle:nth-child(5) { width: 7px; height: 7px; top: 85%; left: 60%; animation-delay: 3s; }
            @keyframes particleFloat {
                0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
                50% { transform: translateY(-20px) scale(1.3); opacity: 1; }
            }

            /* ── Right Panel (Form) ── */
            .auth-form-panel {
                flex: 35; min-height: 100vh;
                display: flex; flex-direction: column; justify-content: center;
                align-items: center;
                padding: 48px 40px; background: #fff;
                position: relative;
            }
            .auth-form-inner {
                width: 100%; max-width: 380px;
            }
            .auth-form-panel::before {
                content: ''; position: absolute; top: 0; left: 0; bottom: 0;
                width: 1px; background: linear-gradient(to bottom, transparent 10%, #E5E7EB 50%, transparent 90%);
            }

            .auth-back-link {
                position: absolute; top: 28px; right: 32px;
                display: inline-flex; align-items: center; gap: 6px;
                font-size: 13px; font-weight: 500; color: #9CA3AF;
                text-decoration: none; transition: color 0.2s;
            }
            .auth-back-link:hover { color: #374151; }
            .auth-back-link svg { width: 16px; height: 16px; }

            .auth-form-header {
                margin-bottom: 36px;
            }
            .auth-form-header .mobile-logo {
                display: none; width: 40px; height: 40px; margin-bottom: 20px;
            }
            .auth-form-header h2 {
                font-size: 28px; font-weight: 800; color: #0F2B1F;
                letter-spacing: -0.5px; margin-bottom: 8px;
            }
            .auth-form-header p {
                font-size: 14px; color: #9CA3AF; line-height: 1.6;
            }

            /* ── Form Fields ── */
            .auth-field { margin-bottom: 20px; }
            .auth-field label {
                display: block; font-size: 13px; font-weight: 600;
                color: #374151; margin-bottom: 6px;
            }
            .auth-field input,
            .auth-field select {
                width: 100%; padding: 12px 16px; font-size: 14px;
                font-family: 'Inter', sans-serif;
                border: 1.5px solid #E5E7EB; border-radius: 12px;
                background: #F9FAFB; color: #111827;
                transition: all 0.2s ease; outline: none;
            }
            .auth-field input::placeholder { color: #D1D5DB; }
            .auth-field input:focus,
            .auth-field select:focus {
                border-color: #16A34A; background: #fff;
                box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
            }
            .auth-field .field-error {
                font-size: 12px; color: #EF4444; margin-top: 6px;
                display: flex; align-items: center; gap: 4px;
            }
            .auth-field .field-hint {
                font-size: 12px; color: #9CA3AF; margin-top: 4px;
            }

            /* Input with icon */
            .input-icon-wrap {
                position: relative;
            }
            .input-icon-wrap input {
                padding-left: 44px;
            }
            .input-icon {
                position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
                width: 18px; height: 18px; color: #D1D5DB;
                transition: color 0.2s;
                pointer-events: none;
            }
            .input-icon-wrap input:focus + .input-icon,
            .input-icon-wrap input:focus ~ .input-icon { color: #16A34A; }
            /* Password toggle */
            .password-toggle {
                position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
                background: none; border: none; cursor: pointer; padding: 4px;
                color: #9CA3AF; transition: color 0.2s;
            }
            .password-toggle:hover { color: #374151; }
            .password-toggle svg { width: 18px; height: 18px; }

            /* ── Checkbox ── */
            .auth-checkbox-row {
                display: flex; justify-content: space-between; align-items: center;
                margin-bottom: 28px;
            }
            .auth-checkbox {
                display: flex; align-items: center; gap: 8px;
                cursor: pointer; font-size: 13px; color: #6B7280;
            }
            .auth-checkbox input[type="checkbox"] {
                width: 16px; height: 16px; border-radius: 5px;
                border: 1.5px solid #D1D5DB; accent-color: #16A34A;
                cursor: pointer;
            }
            .auth-forgot {
                font-size: 13px; font-weight: 600; color: #16A34A;
                text-decoration: none; transition: color 0.2s;
            }
            .auth-forgot:hover { color: #15803D; text-decoration: underline; }

            /* ── Submit Button ── */
            .auth-submit {
                width: 100%; padding: 14px 24px;
                font-size: 15px; font-weight: 700;
                font-family: 'Inter', sans-serif;
                color: #fff; background: linear-gradient(135deg, #0F2B1F 0%, #166534 100%);
                border: none; border-radius: 12px; cursor: pointer;
                transition: all 0.3s ease; position: relative; overflow: hidden;
                display: flex; align-items: center; justify-content: center; gap: 8px;
            }
            .auth-submit::before {
                content: ''; position: absolute; top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
                transition: left 0.6s ease;
            }
            .auth-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(15, 43, 31, 0.25); }
            .auth-submit:hover::before { left: 100%; }
            .auth-submit:active { transform: translateY(0); }
            .auth-submit.loading {
                pointer-events: none; opacity: 0.85;
            }
            .auth-submit .btn-spinner {
                display: none; width: 18px; height: 18px;
                border: 2px solid rgba(255,255,255,0.3);
                border-top-color: #fff; border-radius: 50%;
                animation: spin 0.6s linear infinite;
            }
            .auth-submit.loading .btn-spinner { display: block; }
            .auth-submit.loading .btn-text { display: none; }

            /* ── Divider ── */
            .auth-divider {
                display: flex; align-items: center; gap: 16px;
                margin: 24px 0;
            }
            .auth-divider::before, .auth-divider::after {
                content: ''; flex: 1; height: 1px; background: #E5E7EB;
            }
            .auth-divider span {
                font-size: 12px; color: #9CA3AF; font-weight: 500;
                text-transform: uppercase; letter-spacing: 0.5px;
            }

            /* ── Footer Link ── */
            .auth-footer {
                text-align: center; margin-top: 28px;
                font-size: 14px; color: #9CA3AF;
            }
            .auth-footer a {
                color: #16A34A; font-weight: 600; text-decoration: none;
                transition: color 0.2s;
            }
            .auth-footer a:hover { color: #15803D; text-decoration: underline; }

            /* ── Session Status ── */
            .auth-alert {
                padding: 12px 16px; border-radius: 10px; font-size: 13px;
                margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
            }
            .auth-alert-success {
                background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0;
            }
            .auth-alert-error {
                background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA;
            }

            /* ── Animations ── */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in { animation: fadeInUp 0.5s ease forwards; }
            .fade-in-1 { animation-delay: 0.05s; opacity: 0; }
            .fade-in-2 { animation-delay: 0.1s; opacity: 0; }
            .fade-in-3 { animation-delay: 0.15s; opacity: 0; }
            .fade-in-4 { animation-delay: 0.2s; opacity: 0; }
            .fade-in-5 { animation-delay: 0.25s; opacity: 0; }

            /* ── Responsive ── */
            @media (max-width: 1024px) {
                .auth-brand { display: none; }
                .auth-form-panel {
                    width: 100%; max-width: 100%;
                    padding: 40px 32px;
                }
                .auth-form-header .mobile-logo { display: block; }
                .auth-back-link { right: 32px; top: 24px; }
            }
            @media (max-width: 480px) {
                .auth-form-panel { padding: 32px 24px; }
                .auth-back-link { right: 24px; top: 20px; }
                .auth-form-header h2 { font-size: 24px; }
            }
        </style>
    </head>
    <body>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                <div class="loading-ring-outer"></div>
                <div class="loading-ring"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="loading-logo">
            </div>
            <div class="loading-text">Memuat<span class="loading-dots"></span></div>
        </div>

        <div class="auth-page">
            <!-- Left Brand Panel -->
            <div class="auth-brand">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>

                <div class="auth-brand-content">
                    <img src="{{ asset('images/logo.png') }}" alt="PatunganTani" class="auth-brand-logo">
                    <h1>Patungan Hemat,<br><span>Panen Berlipat</span></h1>
                    <p>Bergabunglah dengan ratusan petani yang sudah menghemat hingga 15% melalui sistem pre-order kolektif saprotan langsung dari distributor.</p>

                    @php
                        $totalFarmers = \App\Models\User::where('role', 'petani')->count();
                        $totalCampaigns = \App\Models\Campaign::where('status', 'active')->count();
                        $totalVolume = \App\Models\Order::where('status', 'paid')->sum('quantity');
                    @endphp
                    <div class="auth-brand-stats">
                        <div class="auth-stat">
                            <div class="auth-stat-value">{{ $totalFarmers }}+</div>
                            <div class="auth-stat-label">Petani</div>
                        </div>
                        <div class="auth-stat-divider"></div>
                        <div class="auth-stat">
                            <div class="auth-stat-value">{{ $totalCampaigns }}</div>
                            <div class="auth-stat-label">Kampanye</div>
                        </div>
                        <div class="auth-stat-divider"></div>
                        <div class="auth-stat">
                            <div class="auth-stat-value">{{ number_format($totalVolume) }}</div>
                            <div class="auth-stat-label">Karung</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="auth-form-panel">
                <a href="/" class="auth-back-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>

                <div class="auth-form-inner">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            // Hide loading overlay when page is ready
            window.addEventListener('load', function() {
                setTimeout(function() {
                    document.getElementById('loadingOverlay').classList.add('hidden');
                }, 600);
            });

            // Show loading on form submit
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const btn = form.querySelector('.auth-submit');
                    if (btn) {
                        btn.classList.add('loading');
                    }
                    document.getElementById('loadingOverlay').classList.remove('hidden');
                });
            });

            // Password toggle
            document.querySelectorAll('.password-toggle').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const eyeOpen = this.querySelector('.eye-open');
                    const eyeClosed = this.querySelector('.eye-closed');
                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeOpen.style.display = 'none';
                        eyeClosed.style.display = 'block';
                    } else {
                        input.type = 'password';
                        eyeOpen.style.display = 'block';
                        eyeClosed.style.display = 'none';
                    }
                });
            });
        </script>
    </body>
</html>

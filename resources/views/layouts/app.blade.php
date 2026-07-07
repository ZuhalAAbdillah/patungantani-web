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

        @php
            $role = Auth::check() ? Auth::user()->role : 'petani';
            $isAdmin = $role === 'admin';
        @endphp

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1a1a1a; -webkit-font-smoothing: antialiased; }
            a { text-decoration: none; }

            :root {
                --dark: #0A1F14;
                --green-900: #0F2B1F;
                --green-700: #166534;
                --green-600: #16A34A;
                --green-500: #22C55E;
                --green-400: #4ADE80;
                --green-300: #86EFAC;
                --green-200: #BBF7D0;
                --green-100: #DCFCE7;
                --green-50: #F0FDF4;
                --gray-50: #F9FAFB;
                --gray-100: #F3F4F6;
                --gray-200: #E5E7EB;
                --gray-400: #9CA3AF;
                --gray-500: #6B7280;
                --gray-700: #374151;
                --gray-900: #111827;
                --amber-500: #F59E0B;
                --amber-600: #D97706;
            }

            /* ══════════════════════════════════════
               SHARED: Top Navbar (Petani & Ketua)
               ══════════════════════════════════════ */
            .site-nav {
                position: sticky; top: 0; z-index: 50;
                background: rgba(255,255,255,0.88);
                backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(0,0,0,0.06);
            }
            .site-nav-inner {
                max-width: 1100px; margin: 0 auto; padding: 0 24px;
                height: 64px; display: flex; align-items: center; justify-content: space-between;
            }
            .site-nav-logo {
                display: flex; align-items: center; gap: 10px;
                color: #0F2B1F; font-weight: 800; font-size: 17px; text-decoration: none; letter-spacing: -0.3px;
            }
            .site-nav-logo img { height: 26px; width: auto; }

            .site-nav-links {
                position: absolute; left: 50%; transform: translateX(-50%);
                display: flex; align-items: center; gap: 4px;
                background: #F3F4F6; border-radius: 12px; padding: 4px;
            }
            .site-nav-links a {
                padding: 7px 18px; border-radius: 9px; font-size: 13px; font-weight: 500;
                color: #6B7280; text-decoration: none; transition: all 0.2s ease;
                white-space: nowrap;
            }
            .site-nav-links a:hover { color: #111827; }
            .site-nav-links a.active {
                background: #fff; color: #0F2B1F; font-weight: 600;
                box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            }

            .site-nav-right { display: flex; align-items: center; gap: 8px; }
            .site-nav-user {
                display: flex; align-items: center; gap: 10px; position: relative;
            }
            .site-nav-avatar {
                width: 34px; height: 34px; border-radius: 10px;
                font-weight: 700; font-size: 13px;
                display: flex; align-items: center; justify-content: center;
            }
            .site-nav-name { font-size: 14px; font-weight: 600; color: #374151; }

            .nav-dropdown { position: relative; }
            .nav-dropdown-btn {
                display: flex; align-items: center; gap: 8px;
                background: none; border: 1px solid #E5E7EB; border-radius: 10px;
                padding: 5px 12px 5px 5px; cursor: pointer; font-family: inherit;
                transition: all 0.15s;
            }
            .nav-dropdown-btn:hover { border-color: #D1D5DB; background: #F9FAFB; }
            .nav-dropdown-menu {
                display: none; position: absolute; right: 0; top: calc(100% + 8px);
                width: 200px; background: #fff; border: 1px solid #E5E7EB;
                border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1);
                overflow: hidden; z-index: 100;
            }
            .nav-dropdown-menu.open { display: block; }
            .nav-dropdown-menu a,
            .nav-dropdown-menu button {
                display: block; width: 100%; padding: 10px 16px; font-size: 14px;
                color: #374151; text-decoration: none; text-align: left;
                background: none; border: none; cursor: pointer; font-family: inherit;
                transition: background 0.1s;
            }
            .nav-dropdown-menu a:hover,
            .nav-dropdown-menu button:hover { background: #F3F4F6; }
            .nav-dropdown-divider { border-top: 1px solid #F3F4F6; }

            /* ── Website body for Petani/Ketua ── */
            .site-body { background: #F8FAF9; min-height: calc(100vh - 64px); }
            .site-container { max-width: 1100px; margin: 0 auto; padding: 28px 24px; }
            .site-page-header { margin-bottom: 24px; }
            .site-page-header h1 { font-size: 24px; font-weight: 800; color: #0F2B1F; margin-bottom: 2px; }
            .site-page-header p { font-size: 14px; color: #6B7280; }
            .site-page-header-row { display: flex; justify-content: space-between; align-items: flex-start; }

            /* ══════════════════════════════════════
               ADMIN: Sidebar Panel
               ══════════════════════════════════════ */
            .admin-sidebar {
                position: fixed; top: 0; left: 0; bottom: 0; width: 260px;
                background: linear-gradient(180deg, #0F2B1F 0%, #0A1F14 100%);
                color: #fff; z-index: 40; display: flex; flex-direction: column;
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            }
            .admin-sidebar-header {
                padding: 24px 20px 20px; display: flex; align-items: center; gap: 12px;
                border-bottom: 1px solid rgba(255,255,255,0.06);
            }
            .admin-sidebar-header img { height: 26px; filter: brightness(0) invert(1); }
            .admin-sidebar-header .brand { font-weight: 800; font-size: 16px; letter-spacing: -0.3px; }
            .admin-sidebar-header .admin-pill {
                margin-left: auto; font-size: 9px; font-weight: 800; text-transform: uppercase;
                letter-spacing: 1px; padding: 3px 10px; border-radius: 6px;
                background: rgba(16,185,129,0.15); color: #6EE7B7;
            }
            .admin-sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
            .admin-section-title {
                font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
                color: rgba(255,255,255,0.25); padding: 16px 12px 8px;
            }
            .admin-section-title:first-child { padding-top: 4px; }
            .admin-nav-item {
                display: flex; align-items: center; gap: 12px;
                padding: 10px 14px; border-radius: 10px; text-decoration: none;
                color: rgba(255,255,255,0.5); font-size: 14px; font-weight: 500;
                transition: all 0.15s ease; margin-bottom: 2px; position: relative;
            }
            .admin-nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.85); }
            .admin-nav-item.active {
                background: rgba(16,185,129,0.12); color: #fff; font-weight: 600;
            }
            .admin-nav-item.active::before {
                content: ''; position: absolute; left: 0; top: 8px; bottom: 8px;
                width: 3px; border-radius: 0 3px 3px 0; background: #10B981;
            }
            .admin-nav-icon { width: 20px; height: 20px; flex-shrink: 0; opacity: 0.5; transition: opacity 0.15s; }
            .admin-nav-item:hover .admin-nav-icon { opacity: 0.85; }
            .admin-nav-item.active .admin-nav-icon { opacity: 1; color: #6EE7B7; }

            .admin-sidebar-footer {
                padding: 14px 16px; background: rgba(0,0,0,0.2);
                border-top: 1px solid rgba(255,255,255,0.06);
            }
            .admin-user-card { display: flex; align-items: center; gap: 12px; }
            .admin-avatar {
                width: 36px; height: 36px; border-radius: 10px;
                font-weight: 700; font-size: 13px;
                display: flex; align-items: center; justify-content: center;
                background: #D1FAE5; color: #065F46; flex-shrink: 0;
            }
            .admin-user-name { font-size: 14px; font-weight: 600; color: #fff; }
            .admin-user-role { font-size: 11px; color: rgba(255,255,255,0.35); }
            .admin-logout {
                background: none; border: none; cursor: pointer; margin-left: auto;
                color: rgba(255,255,255,0.3); padding: 6px; border-radius: 6px; transition: all 0.15s;
            }
            .admin-logout:hover { color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.06); }

            .admin-main { margin-left: 260px; min-height: 100vh; background: #F8FAFC; }
            .admin-topbar {
                background: #fff; border-bottom: 1px solid #E5E7EB;
                padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;
                position: sticky; top: 0; z-index: 30;
            }
            .admin-topbar h1 { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 2px 0; }
            .admin-topbar p { font-size: 13px; color: #6B7280; margin: 0; }
            .admin-page-content { padding: 28px 32px; }

            /* ══════════════════════════════════════
               DESIGN SYSTEM (shared)
               ══════════════════════════════════════ */
            .topbar-btn {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
                text-decoration: none; cursor: pointer; transition: all 0.15s ease; border: none; font-family: inherit;
            }
            .topbar-btn-outline { background: #fff; color: #374151; border: 1px solid #D1D5DB; }
            .topbar-btn-outline:hover { background: #F9FAFB; border-color: #9CA3AF; }
            .topbar-btn-primary { background: #0F2B1F; color: #fff; }
            .topbar-btn-primary:hover { background: #1B3C2D; }
            .topbar-btn-green { background: #16A34A; color: #fff; }
            .topbar-btn-green:hover { background: #15803D; }
            .topbar-btn-indigo { background: #6366F1; color: #fff; }
            .topbar-btn-indigo:hover { background: #4F46E5; }
            .topbar-btn-red { background: #EF4444; color: #fff; }
            .topbar-btn-red:hover { background: #DC2626; }

            .btn {
                display: inline-flex; align-items: center; justify-content: center; gap: 8px;
                padding: 10px 20px; border-radius: 12px; font-size: 14px; font-weight: 600;
                text-decoration: none; cursor: pointer; transition: all 0.2s ease;
                border: 1px solid transparent; font-family: inherit; line-height: 1.5;
            }
            .btn:active { transform: translateY(1px); }
            .btn-lg { padding: 14px 28px; font-size: 16px; border-radius: 14px; }
            .btn-sm { padding: 8px 16px; font-size: 13px; border-radius: 10px; }
            .btn-green { background: #16A34A; color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,0.25); }
            .btn-green:hover { background: #15803D; box-shadow: 0 6px 16px rgba(22,163,74,0.3); transform: translateY(-2px); color: #fff; }
            .btn-dark { background: #0F2B1F; color: #fff; box-shadow: 0 4px 12px rgba(15,43,31,0.25); }
            .btn-dark:hover { background: #1B3C2D; box-shadow: 0 6px 16px rgba(15,43,31,0.3); transform: translateY(-2px); color: #fff; }
            .btn-outline { background: #fff; color: #374151; border-color: #D1D5DB; }
            .btn-outline:hover { background: #F9FAFB; border-color: #9CA3AF; color: #111827; transform: translateY(-2px); }

            .stat-grid { display: grid; gap: 16px; margin-bottom: 28px; }
            .stat-grid-3 { grid-template-columns: repeat(3, 1fr); }
            .stat-grid-4 { grid-template-columns: repeat(4, 1fr); }
            .stat-card {
                background: #fff; border-radius: 14px; padding: 22px 24px;
                border: 1px solid #E8ECE9; position: relative; overflow: hidden;
                transition: box-shadow 0.2s ease, transform 0.2s ease;
            }
            .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.05); transform: translateY(-1px); }
            .stat-card-label { font-size: 13px; color: #6B7280; font-weight: 500; margin-bottom: 8px; }
            .stat-card-value { font-size: 28px; font-weight: 800; color: #111827; line-height: 1.1; }
            .stat-card-value.green { color: #16A34A; }
            .stat-card-sub { font-size: 12px; color: #9CA3AF; margin-top: 4px; }
            .stat-card-icon {
                position: absolute; top: 22px; right: 22px;
                width: 42px; height: 42px; border-radius: 12px;
                display: flex; align-items: center; justify-content: center;
            }
            .stat-card-icon svg { width: 22px; height: 22px; }

            .panel { background: #fff; border-radius: 14px; border: 1px solid #E8ECE9; overflow: hidden; margin-bottom: 24px; }
            .panel-header { padding: 18px 24px; border-bottom: 1px solid #E8ECE9; display: flex; justify-content: space-between; align-items: center; }
            .panel-title { font-size: 16px; font-weight: 700; color: #111827; }
            .panel-link { font-size: 13px; color: #16A34A; text-decoration: none; font-weight: 600; }
            .panel-link:hover { text-decoration: underline; }
            .panel-body { padding: 20px 24px; }
            .panel-body-flush { padding: 0; }

            .data-table { width: 100%; border-collapse: collapse; }
            .data-table th {
                padding: 12px 24px; text-align: left; font-size: 11px; color: #6B7280;
                font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
                background: #F8FAF9; border-bottom: 1px solid #E8ECE9;
            }
            .data-table th.right { text-align: right; }
            .data-table th.center { text-align: center; }
            .data-table td { padding: 14px 24px; border-bottom: 1px solid #F3F4F6; font-size: 14px; color: #374151; }
            .data-table td.right { text-align: right; }
            .data-table td.center { text-align: center; }
            .data-table tr:last-child td { border-bottom: none; }
            .data-table tr:hover { background: #FAFCFA; }
            .data-table tfoot td { background: #F8FAF9; font-weight: 700; color: #111827; border-top: 1px solid #E8ECE9; }

            .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 6px; }
            .badge-green { background: #DCFCE7; color: #166534; }
            .badge-amber { background: #FEF3C7; color: #92400E; }
            .badge-red { background: #FEE2E2; color: #991B1B; }
            .badge-gray { background: #F3F4F6; color: #6B7280; }
            .badge-blue { background: #DBEAFE; color: #1E40AF; }

            /* Forms */
            .form-group { margin-bottom: 20px; }
            .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
            .form-control {
                width: 100%; padding: 10px 14px; font-size: 14px; font-family: inherit;
                border: 1.5px solid #E5E7EB; border-radius: 10px; background: #F9FAFB;
                transition: all 0.2s; outline: none; box-sizing: border-box;
            }
            .form-control:focus { border-color: #16A34A; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,0.1); }
            .text-danger { color: #EF4444; font-size: 12px; margin-top: 4px; display: block; }

            .avatar-sm { width: 30px; height: 30px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
            .avatar-colors-1 { background: #FDBA74; color: #9A3412; }
            .avatar-colors-2 { background: #A5B4FC; color: #3730A3; }
            .avatar-colors-3 { background: #86EFAC; color: #166534; }
            .avatar-colors-4 { background: #FCA5A5; color: #991B1B; }
            .avatar-colors-5 { background: #67E8F9; color: #155E75; }

            .progress-track { width: 100%; height: 10px; background: #E8ECE9; border-radius: 99px; overflow: hidden; }
            .progress-fill { height: 100%; border-radius: 99px; transition: width 0.6s ease; }
            .progress-fill-green { background: linear-gradient(90deg, #16A34A, #22C55E); }
            .progress-fill-amber { background: linear-gradient(90deg, #D97706, #F59E0B); }

            .empty-state { text-align: center; padding: 48px 24px; color: #6B7280; }
            .empty-state svg { width: 48px; height: 48px; color: #D1D5DB; margin: 0 auto 12px; }
            .empty-state h4 { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 4px; }
            .empty-state p { font-size: 13px; margin-bottom: 16px; }

            .cols-2-1 { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
            .cols-1-1 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

            /* ══════════════════════════════════════
               RESPONSIVE
               ══════════════════════════════════════ */
            @media (max-width: 1024px) {
                .admin-sidebar { transform: translateX(-100%); }
                .admin-sidebar.open { transform: translateX(0); }
                .admin-main { margin-left: 0; }
                .admin-mobile-toggle { display: flex !important; }
            }
            @media (max-width: 768px) {
                .site-nav-links { display: none; }
                .stat-grid-3, .stat-grid-4 { grid-template-columns: 1fr 1fr; }
                .cols-2-1, .cols-1-1 { grid-template-columns: 1fr; }
                .site-container { padding: 20px 16px; }
            }
            @media (max-width: 480px) {
                .stat-grid-3, .stat-grid-4 { grid-template-columns: 1fr; }
            }

            /* Animations */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(12px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-in { animation: fadeInUp 0.4s ease forwards; }
            .animate-delay-1 { animation-delay: 0.05s; opacity: 0; }
            .animate-delay-2 { animation-delay: 0.1s; opacity: 0; }
            .animate-delay-3 { animation-delay: 0.15s; opacity: 0; }
            .animate-delay-4 { animation-delay: 0.2s; opacity: 0; }

            /* ══════════════════════════════════════
               KETUA DASHBOARD SHARED STYLES
               ══════════════════════════════════════ */
            .ketua-welcome {
                background: linear-gradient(135deg, #0F2B1F 0%, #166534 50%, #16A34A 100%);
                border-radius: 18px; padding: 28px 32px; color: #fff;
                margin-bottom: 24px; position: relative; overflow: hidden;
            }
            .ketua-welcome::before {
                content: ''; position: absolute; top: -40%; right: -10%;
                width: 300px; height: 300px;
                background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
                border-radius: 50%;
            }
            .ketua-welcome-inner {
                position: relative; z-index: 1;
                display: flex; justify-content: space-between; align-items: center; gap: 24px; flex-wrap: wrap;
            }
            .ketua-welcome h2 { font-size: 22px; font-weight: 800; margin-bottom: 6px; line-height: 1.3; }
            .welcome-subtitle { font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.5; }
            .countdown-box { display: flex; gap: 10px; align-items: center; flex-shrink: 0; }
            .countdown-unit {
                text-align: center; background: rgba(255,255,255,0.12);
                backdrop-filter: blur(8px); border-radius: 12px;
                padding: 10px 14px; min-width: 62px; border: 1px solid rgba(255,255,255,0.1);
            }
            .countdown-number { font-size: 26px; font-weight: 800; line-height: 1; display: block; }
            .countdown-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.6); margin-top: 4px; display: block; }
            .countdown-urgent .countdown-unit {
                background: rgba(239,68,68,0.25); border-color: rgba(239,68,68,0.3);
                animation: urgentPulse 2s infinite;
            }
            .countdown-warning .countdown-unit {
                background: rgba(245,158,11,0.2); border-color: rgba(245,158,11,0.3);
            }
            @keyframes urgentPulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0.3); }
                50% { box-shadow: 0 0 0 6px rgba(239,68,68,0); }
            }
            .deadline-alert {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; margin-top: 10px;
            }
            .deadline-alert-danger { background: rgba(239,68,68,0.2); color: #FCA5A5; }
            .deadline-alert-warning { background: rgba(245,158,11,0.2); color: #FCD34D; }
            .deadline-alert-success { background: rgba(34,197,94,0.2); color: #86EFAC; }
            .stat-grid-6 { grid-template-columns: repeat(3, 1fr); }
            .progress-milestones { position: relative; margin-bottom: 16px; }
            .progress-track-enhanced { width: 100%; height: 18px; background: #E8ECE9; border-radius: 99px; overflow: hidden; position: relative; }
            .progress-fill-animated {
                height: 100%; border-radius: 99px;
                transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex; align-items: center; justify-content: flex-end; padding-right: 10px;
            }
            .progress-fill-animated.near-target { animation: progressPulse 2s infinite; }
            @keyframes progressPulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.4); }
                50% { box-shadow: 0 0 0 6px rgba(22,163,74,0); }
            }
            .milestone-markers { display: flex; justify-content: space-between; padding: 0 1%; margin-top: 6px; }
            .milestone-mark { font-size: 10px; color: #9CA3AF; font-weight: 600; position: relative; }
            .milestone-mark::before {
                content: ''; position: absolute; top: -10px; left: 50%; transform: translateX(-50%);
                width: 2px; height: 6px; background: #D1D5DB; border-radius: 1px;
            }
            .milestone-mark.reached { color: #16A34A; }
            .milestone-mark.reached::before { background: #16A34A; }


            @media (max-width: 768px) {
                .stat-grid-6 { grid-template-columns: repeat(2, 1fr); }
                .ketua-welcome-inner { flex-direction: column; align-items: flex-start; }
                .countdown-box { align-self: stretch; justify-content: center; }
            }
            @media (max-width: 480px) {
                .stat-grid-6 { grid-template-columns: 1fr; }
                .ketua-welcome { padding: 20px; }
                .ketua-welcome h2 { font-size: 18px; }
            }
        </style>
    </head>
    <body>

        @auth
            @if($isAdmin)
                {{-- ════════════════════════════════════
                     ADMIN LAYOUT: Sidebar Panel
                     ════════════════════════════════════ --}}
                <aside class="admin-sidebar" id="adminSidebar">
                    <div class="admin-sidebar-header">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                        <span class="brand">PatunganTani</span>
                        <span class="admin-pill">Admin</span>
                    </div>
                    <nav class="admin-sidebar-nav">
                        <div class="admin-section-title">Overview</div>
                        <a href="{{ route('dashboard') }}" class="admin-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Panel Admin
                        </a>
                        <div class="admin-section-title">Kelola</div>
                        <a href="{{ route('campaign.create') }}" class="admin-nav-item {{ request()->routeIs('campaign.create') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Buat Kampanye
                        </a>
                        <a href="{{ route('scan') }}" class="admin-nav-item {{ request()->routeIs('scan') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            Scan QR
                        </a>
                        <a href="{{ route('orders.index') }}" class="admin-nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Semua Pesanan
                        </a>
                        <div class="admin-section-title">Laporan</div>
                        <a href="{{ route('admin.finance') }}" class="admin-nav-item {{ request()->routeIs('admin.finance') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Keuangan
                        </a>
                        <div class="admin-section-title">Sistem</div>
                        <a href="/" class="admin-nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            Landing Page
                        </a>
                        <a href="{{ route('profile.edit') }}" class="admin-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan
                        </a>
                    </nav>
                    <div class="admin-sidebar-footer">
                        <div class="admin-user-card">
                            <div class="admin-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="admin-user-name">{{ Auth::user()->name }}</div>
                                <div class="admin-user-role">Administrator</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit" class="admin-logout" title="Keluar">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                <div class="admin-main">
                    @isset($header)
                    <div class="admin-topbar">
                        <div>{{ $header }}</div>
                        @isset($actions)<div style="display:flex;align-items:center;gap:10px;">{{ $actions }}</div>@endisset
                    </div>
                    @endisset
                    <main class="admin-page-content">{{ $slot }}</main>
                </div>
            @endif
        @endauth

        @if(!$isAdmin)
            {{-- ════════════════════════════════════
                 PETANI / KETUA / GUEST LAYOUT: Top Navbar
                 ════════════════════════════════════ --}}
            <nav class="site-nav">
                <div class="site-nav-inner">
                    <a href="/" class="site-nav-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                        <span>PatunganTani.id</span>
                    </a>

                    <div class="site-nav-links">
                        @auth
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                            <a href="{{ route('page.pre-order') }}" class="{{ request()->routeIs('page.pre-order') ? 'active' : '' }}">Pre-Order</a>
                            <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Pesanan Saya</a>
                            @if(Auth::user()->isKetua())
                                <a href="{{ route('campaign.create') }}" class="{{ request()->routeIs('campaign.create') ? 'active' : '' }}">Buat Kampanye</a>
                                <a href="{{ route('scan') }}" class="{{ request()->routeIs('scan') ? 'active' : '' }}">Scan QR</a>
                            @endif
                        @else
                            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                            <a href="{{ route('page.cara-kerja') }}" class="{{ request()->routeIs('page.cara-kerja') ? 'active' : '' }}">Cara Kerja</a>
                            <a href="{{ route('page.keunggulan') }}" class="{{ request()->routeIs('page.keunggulan') ? 'active' : '' }}">Keunggulan</a>
                            <a href="{{ route('page.pre-order') }}" class="{{ request()->routeIs('page.pre-order') ? 'active' : '' }}">Pre-Order</a>
                        @endauth
                    </div>

                    <div class="site-nav-right">
                        @auth
                            @if(Auth::user()->isKetua())
                                <span class="badge badge-blue" style="margin-right: 4px;">Ketua</span>
                            @endif
                            <div class="nav-dropdown" id="userDropdown">
                                <button class="nav-dropdown-btn" onclick="document.getElementById('userDropdown').querySelector('.nav-dropdown-menu').classList.toggle('open')">
                                    <div class="site-nav-avatar" style="background: {{ Auth::user()->isKetua() ? '#C7D2FE' : '#DCFCE7' }}; color: {{ Auth::user()->isKetua() ? '#3730A3' : '#166534' }};">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <span class="site-nav-name">{{ Auth::user()->name }}</span>
                                    <svg style="width:14px;height:14px;color:#9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="nav-dropdown-menu">
                                    <a href="{{ route('profile.edit') }}">
                                        <span style="display:flex;align-items:center;gap:8px;">
                                            <svg style="width:16px;height:16px;color:#9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Profil Saya
                                        </span>
                                    </a>
                                    <div class="nav-dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" style="color:#EF4444;">
                                            <span style="display:flex;align-items:center;gap:8px;">
                                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                Keluar
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="topbar-btn topbar-btn-outline" style="padding: 6px 14px; font-size: 13px;">Masuk</a>
                            <a href="{{ route('register') }}" class="topbar-btn topbar-btn-green" style="padding: 6px 14px; font-size: 13px;">Daftar</a>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="site-body">
                @if(request()->is('/') || request()->routeIs('page.*'))
                    {{-- Full-width rendering for landing page and standalone public pages --}}
                    {{ $slot }}
                @else
                    <div class="site-container">
                        @isset($header)
                        <div class="site-page-header animate-in">
                            <div class="site-page-header-row">
                                <div>{{ $header }}</div>
                                @isset($actions)<div style="display:flex;align-items:center;gap:10px;">{{ $actions }}</div>@endisset
                            </div>
                        </div>
                        @endisset
                        {{ $slot }}
                    </div>
                @endif
            </div>
        @endif

        <script>
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-dropdown-menu.open').forEach(menu => {
                    if (!menu.closest('.nav-dropdown').contains(e.target)) {
                        menu.classList.remove('open');
                    }
                });
            });
            // Admin sidebar mobile toggle
            const adminSidebar = document.getElementById('adminSidebar');
            const adminToggle = document.getElementById('adminSidebarToggle');
            if (adminToggle && adminSidebar) {
                adminToggle.addEventListener('click', () => adminSidebar.classList.toggle('open'));
            }
        </script>
    </body>
</html>

<x-app-layout>
    <x-slot name="header">
        <h1>Kelola Kampanye</h1>
        <p>
            @if($campaign)
                Agregasi pesanan — {{ $campaign->title }}
            @else
                Belum ada kampanye aktif
            @endif
        </p>
    </x-slot>

    <x-slot name="actions">
        @if($campaign)
        <a href="{{ route('dashboard.export-csv') }}" class="topbar-btn topbar-btn-outline">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Unduh CSV
        </a>
        @endif
        <a href="{{ route('campaign.create') }}" class="topbar-btn topbar-btn-primary">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Kampanye
        </a>
    </x-slot>

    {{-- ══════════════════════════════════════
         CUSTOM STYLES FOR KETUA DASHBOARD
         ══════════════════════════════════════ --}}
    <style>
        /* ── Welcome Banner ── */
        .ketua-welcome {
            background: linear-gradient(135deg, #0F2B1F 0%, #166534 50%, #16A34A 100%);
            border-radius: 18px;
            padding: 28px 32px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .ketua-welcome::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .ketua-welcome::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: 20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .ketua-welcome-inner {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }
        .ketua-welcome h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
            line-height: 1.3;
        }
        .ketua-welcome .welcome-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.7);
            line-height: 1.5;
        }

        /* ── Countdown Timer ── */
        .countdown-box {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-shrink: 0;
        }
        .countdown-unit {
            text-align: center;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 10px 14px;
            min-width: 62px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .countdown-number {
            font-size: 26px;
            font-weight: 800;
            line-height: 1;
            display: block;
        }
        .countdown-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.6);
            margin-top: 4px;
            display: block;
        }
        .countdown-urgent .countdown-unit {
            background: rgba(239,68,68,0.25);
            border-color: rgba(239,68,68,0.3);
            animation: urgentPulse 2s infinite;
        }
        .countdown-warning .countdown-unit {
            background: rgba(245,158,11,0.2);
            border-color: rgba(245,158,11,0.3);
        }

        @keyframes urgentPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0.3); }
            50% { box-shadow: 0 0 0 6px rgba(239,68,68,0); }
        }

        /* ── Alert Badge ── */
        .deadline-alert {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 10px;
        }
        .deadline-alert-danger {
            background: rgba(239,68,68,0.2);
            color: #FCA5A5;
        }
        .deadline-alert-warning {
            background: rgba(245,158,11,0.2);
            color: #FCD34D;
        }
        .deadline-alert-success {
            background: rgba(34,197,94,0.2);
            color: #86EFAC;
        }

        /* ── Quick Actions ── */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }
        .qa-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff;
            border: 1px solid #E8ECE9;
            border-radius: 14px;
            padding: 18px 20px;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .qa-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .qa-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .qa-card:hover .qa-icon {
            transform: scale(1.05);
        }
        .qa-title {
            font-size: 14px;
            font-weight: 700;
            color: #0F2B1F;
        }
        .qa-desc {
            font-size: 12px;
            color: #6B7280;
        }

        /* ── Stat Cards 6-grid ── */
        .stat-grid-8 {
            grid-template-columns: repeat(4, 1fr);
        }

        /* ── Share Campaign Box ── */
        .share-box {
            background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
            border: 1px solid #BFDBFE;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }
        .share-box-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .share-box-title {
            font-size: 15px;
            font-weight: 700;
            color: #1E40AF;
        }
        .share-box-desc {
            font-size: 12px;
            color: #3B82F6;
        }
        .share-input-row {
            display: flex;
            gap: 8px;
            align-items: stretch;
        }
        .share-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #93C5FD;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1E40AF;
            box-sizing: border-box;
        }
        .share-input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .share-btn-copy {
            background: #1E40AF;
            color: #fff;
        }
        .share-btn-copy:hover {
            background: #1E3A8A;
        }
        .share-btn-copy.copied {
            background: #16A34A;
        }
        .share-btn-wa {
            background: #22C55E;
            color: #fff;
        }
        .share-btn-wa:hover {
            background: #16A34A;
        }

        /* ── Progress Milestones ── */
        .progress-milestones {
            position: relative;
            margin-bottom: 16px;
        }
        .progress-track-enhanced {
            width: 100%;
            height: 18px;
            background: #E8ECE9;
            border-radius: 99px;
            overflow: hidden;
            position: relative;
        }
        .progress-fill-animated {
            height: 100%;
            border-radius: 99px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            position: relative;
        }
        .progress-fill-animated.near-target {
            animation: progressPulse 2s infinite;
        }
        @keyframes progressPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.4); }
            50% { box-shadow: 0 0 0 6px rgba(22,163,74,0); }
        }
        .milestone-markers {
            display: flex;
            justify-content: space-between;
            padding: 0 1%;
            margin-top: 6px;
        }
        .milestone-mark {
            font-size: 10px;
            color: #9CA3AF;
            font-weight: 600;
            position: relative;
        }
        .milestone-mark::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 6px;
            background: #D1D5DB;
            border-radius: 1px;
        }
        .milestone-mark.reached {
            color: #16A34A;
        }
        .milestone-mark.reached::before {
            background: #16A34A;
        }

        /* ── Search & Filter Bar ── */
        .table-toolbar {
            display: flex;
            gap: 10px;
            padding: 16px 24px;
            border-bottom: 1px solid #E8ECE9;
            align-items: center;
            flex-wrap: wrap;
        }
        .table-search {
            flex: 1;
            min-width: 180px;
            padding: 9px 14px 9px 36px;
            border: 1px solid #D1D5DB;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: #F9FAFB;
            box-sizing: border-box;
            transition: all 0.15s;
        }
        .table-search:focus {
            outline: none;
            border-color: #16A34A;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(22,163,74,0.08);
        }
        .table-search-wrapper {
            position: relative;
            flex: 1;
            min-width: 180px;
        }
        .table-search-wrapper svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #9CA3AF;
        }
        .filter-btn {
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #D1D5DB;
            background: #fff;
            color: #6B7280;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .filter-btn:hover {
            border-color: #9CA3AF;
            background: #F3F4F6;
        }
        .filter-btn.active {
            background: #0F2B1F;
            color: #fff;
            border-color: #0F2B1F;
        }

        /* ── Activity Timeline ── */
        .timeline {
            padding: 0;
            list-style: none;
        }
        .timeline-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            position: relative;
        }
        .timeline-item:not(:last-child) {
            border-bottom: 1px solid #F3F4F6;
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 17px;
            top: 46px;
            bottom: 0;
            width: 2px;
            background: #E8ECE9;
        }
        .timeline-dot {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .timeline-dot svg {
            width: 16px;
            height: 16px;
        }
        .timeline-text {
            font-size: 13px;
            color: #374151;
            font-weight: 500;
            line-height: 1.4;
        }
        .timeline-time {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        /* ── Campaign History ── */
        .history-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #F3F4F6;
        }
        .history-card:last-child {
            border-bottom: none;
        }
        .history-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #0F2B1F;
            margin-bottom: 2px;
        }
        .history-info p {
            font-size: 12px;
            color: #9CA3AF;
        }
        .history-stats {
            display: flex;
            gap: 16px;
            align-items: center;
        }
        .history-stat {
            text-align: right;
        }
        .history-stat-value {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .history-stat-label {
            font-size: 10px;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Payment Donut (CSS) ── */
        .donut-chart {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            position: relative;
            margin: 0 auto 12px;
        }
        .donut-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .donut-center-value {
            font-size: 18px;
            font-weight: 800;
            color: #0F2B1F;
            line-height: 1;
        }
        .donut-center-label {
            font-size: 9px;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-grid-6 { grid-template-columns: repeat(2, 1fr); }
            .ketua-welcome-inner { flex-direction: column; align-items: flex-start; }
            .countdown-box { align-self: stretch; justify-content: center; }
            .share-input-row { flex-direction: column; }
            .ketua-main-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .quick-actions-grid { grid-template-columns: 1fr; }
            .stat-grid-6 { grid-template-columns: 1fr; }
            .ketua-welcome { padding: 20px; }
            .ketua-welcome h2 { font-size: 18px; }
        }
    </style>

    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; border: 1px solid #BBF7D0;" class="animate-in">
        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    @if($campaign)
    @php
        $progress = $campaign->progressPercent();
        $savings = $totalPrice * 0.15;
        $paidOrders = collect($orders)->where('status', 'paid');
        $pendingOrdersList = collect($orders)->where('status', 'pending');
        $paidPercent = $totalPrice > 0 ? round(($paidTotal / $totalPrice) * 100) : 0;

        // Greeting
        $hour = now()->format('H');
        if ($hour < 11) $greeting = 'Selamat Pagi';
        elseif ($hour < 15) $greeting = 'Selamat Siang';
        elseif ($hour < 18) $greeting = 'Selamat Sore';
        else $greeting = 'Selamat Malam';

        $firstName = explode(' ', Auth::user()->name)[0];

        // Countdown urgency
        $urgencyClass = '';
        if ($daysLeft <= 3) $urgencyClass = 'countdown-urgent';
        elseif ($daysLeft <= 7) $urgencyClass = 'countdown-warning';
    @endphp

    {{-- ══════════════════════════════════════
         WELCOME BANNER + COUNTDOWN
         ══════════════════════════════════════ --}}
    <div class="ketua-welcome animate-in">
        <img src="{{ asset('images/farmer_working.png') }}" alt="Farmers" class="ketua-welcome-img" style="position: absolute; right: 280px; top: -50px; height: 150%; opacity: 0.6; mix-blend-mode: luminosity; pointer-events: none; mask-image: radial-gradient(circle, black 30%, transparent 70%); -webkit-mask-image: radial-gradient(circle, black 30%, transparent 70%); z-index: 0;">
        <div class="ketua-welcome-inner">
            <div>
                <h2 style="position: relative; z-index: 2;">{{ $greeting }}, {{ $firstName }}! 👋</h2>
                <div class="welcome-subtitle" style="position: relative; z-index: 2;">
                    Kampanye <strong style="color: #86EFAC;">{{ $campaign->title }}</strong> sedang berjalan.
                    {{ $totalVolume }} dari {{ $campaign->target_amount }} karung sudah terpesan.
                </div>
                @if($daysLeft <= 3 && $daysLeft > 0)
                    <div class="deadline-alert deadline-alert-danger" style="position: relative; z-index: 2;">⚡ Deadline tinggal {{ $daysLeft }} hari!</div>
                @elseif($daysLeft <= 7)
                    <div class="deadline-alert deadline-alert-warning" style="position: relative; z-index: 2;">⏳ {{ $daysLeft }} hari menuju deadline</div>
                @elseif($progress >= 100)
                    <div class="deadline-alert deadline-alert-success" style="position: relative; z-index: 2;">🎉 Kuota tercapai! Siap untuk lock.</div>
                @else
                    <div class="deadline-alert deadline-alert-success" style="position: relative; z-index: 2;">✅ {{ $daysLeft }} hari tersisa</div>
                @endif
            </div>
            <div class="countdown-box {{ $urgencyClass }}" id="countdownBox" style="position: relative; z-index: 2;">
                <div class="countdown-unit">
                    <span class="countdown-number" id="cdDays">{{ $daysLeft }}</span>
                    <span class="countdown-label">Hari</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number" id="cdHours">00</span>
                    <span class="countdown-label">Jam</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number" id="cdMins">00</span>
                    <span class="countdown-label">Menit</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number" id="cdSecs">00</span>
                    <span class="countdown-label">Detik</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         QUICK ACTIONS
         ══════════════════════════════════════ --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        Aksi Cepat
    </h3>
    <div class="quick-actions-grid animate-in">
        <a href="{{ route('campaign.create') }}" class="qa-card" style="--hover-color: #16A34A;" onmouseover="this.style.borderColor='#16A34A'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #DCFCE7;">
                <svg style="width: 20px; height: 20px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="qa-title">Buat Kampanye</div>
                <div class="qa-desc">Kampanye pre-order baru</div>
            </div>
        </a>
        <a href="{{ route('scan') }}" class="qa-card" onmouseover="this.style.borderColor='#7C3AED'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #EDE9FE;">
                <svg style="width: 20px; height: 20px; color: #7C3AED;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <div>
                <div class="qa-title">Scan QR</div>
                <div class="qa-desc">Distribusi kupon</div>
            </div>
        </a>
        <a href="{{ route('dashboard.export-csv') }}" class="qa-card" onmouseover="this.style.borderColor='#D97706'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #FEF3C7;">
                <svg style="width: 20px; height: 20px; color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <div class="qa-title">Unduh CSV</div>
                <div class="qa-desc">Rekap pesanan</div>
            </div>
        </a>
        <a href="{{ route('page.pre-order') }}" class="qa-card" onmouseover="this.style.borderColor='#0EA5E9'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #E0F2FE;">
                <svg style="width: 20px; height: 20px; color: #0EA5E9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <div>
                <div class="qa-title">Lihat Pre-Order</div>
                <div class="qa-desc">Halaman publik</div>
            </div>
        </a>
    </div>

    {{-- ══════════════════════════════════════
         STAT CARDS (8 cards)
         ══════════════════════════════════════ --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; margin-top: 32px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        Ringkasan Statistik
    </h3>
    <div class="stat-grid stat-grid-8">
        <div class="stat-card animate-in animate-delay-1">
            <div class="stat-card-label">Total Volume</div>
            <div class="stat-card-value">{{ $totalVolume }}</div>
            <div class="stat-card-sub">Karung terpesan</div>
            <div class="stat-card-icon" style="background: #E0E7FF;"><svg style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-2">
            <div class="stat-card-label">Total Tagihan</div>
            <div class="stat-card-value" style="font-size: 20px;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
            <div class="stat-card-sub">{{ collect($orders)->count() }} pesanan</div>
            <div class="stat-card-icon" style="background: #FEF3C7;"><svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-3">
            <div class="stat-card-label">Sudah Lunas</div>
            <div class="stat-card-value green" style="font-size: 20px;">Rp {{ number_format($paidTotal, 0, ',', '.') }}</div>
            <div class="stat-card-sub">{{ $paidOrders->count() }} petani ({{ $paidPercent }}%)</div>
            <div class="stat-card-icon" style="background: #DCFCE7;"><svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-4">
            <div class="stat-card-label">Belum Lunas</div>
            <div class="stat-card-value" style="font-size: 20px; color: #D97706;">Rp {{ number_format($unpaidTotal, 0, ',', '.') }}</div>
            <div class="stat-card-sub">{{ $pendingOrdersList->count() }} petani menunggu</div>
            <div class="stat-card-icon" style="background: #FEF3C7;"><svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-1">
            <div class="stat-card-label">Anggota Pesan</div>
            <div class="stat-card-value">{{ $memberCount }}</div>
            <div class="stat-card-sub">Petani unik</div>
            <div class="stat-card-icon" style="background: #FCE7F3;"><svg style="color: #DB2777;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-2">
            <div class="stat-card-label">Distribusi</div>
            <div class="stat-card-value">{{ $distributedCount }}<span style="font-size: 16px; color: #6B7280; font-weight: 500;">/{{ $distributedCount + $pendingDistribution }}</span></div>
            <div class="stat-card-sub">Sudah diambil</div>
            <div class="stat-card-icon" style="background: #EDE9FE;"><svg style="color: #7C3AED;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-3">
            <div class="stat-card-label">Komisi Cair</div>
            <div class="stat-card-value" style="font-size: 20px; color: #059669;">Rp {{ number_format($komisiKetua, 0, ',', '.') }}</div>
            <div class="stat-card-sub">Bagi hasil 40%</div>
            <div class="stat-card-icon" style="background: #D1FAE5;"><svg style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
        </div>
        <div class="stat-card animate-in animate-delay-4">
            <div class="stat-card-label">Potensi Komisi</div>
            <div class="stat-card-value" style="font-size: 20px; color: #0891B2;">Rp {{ number_format($potensiKomisi, 0, ',', '.') }}</div>
            <div class="stat-card-sub">Dari pending order</div>
            <div class="stat-card-icon" style="background: #CFFAFE;"><svg style="color: #0891B2;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         PROGRESS BAR + MILESTONES
         ══════════════════════════════════════ --}}
    <div class="panel animate-in" style="margin-bottom: 24px;">
        <div class="panel-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <div>
                    <span style="font-size: 15px; font-weight: 700; color: #0F2B1F;">Status Kuota</span>
                    <span class="badge {{ $progress >= 100 ? 'badge-green' : ($progress >= 75 ? 'badge-amber' : 'badge-gray') }}" style="margin-left: 8px;">
                        {{ $progress >= 100 ? '🔒 Terkunci!' : ($progress >= 75 ? '🔥 Hampir Penuh' : '🔓 Menuju Lock') }}
                    </span>
                </div>
                <span style="font-size: 13px; color: #6B7280;">
                    <strong style="color: #0F2B1F;">{{ $totalVolume }}</strong> / {{ $campaign->target_amount }} Karung
                </span>
            </div>
            <div class="progress-milestones">
                <div class="progress-track-enhanced">
                    <div class="progress-fill-animated {{ $progress >= 100 ? 'progress-fill-green' : 'progress-fill-amber' }} {{ $progress >= 80 && $progress < 100 ? 'near-target' : '' }}"
                         style="width: {{ min($progress, 100) }}%;">
                        @if($progress > 15)
                        <span style="font-size: 11px; font-weight: 700; color: #fff;">{{ $progress }}%</span>
                        @endif
                    </div>
                </div>
                <div class="milestone-markers">
                    <span class="milestone-mark {{ $progress >= 0 ? 'reached' : '' }}">0%</span>
                    <span class="milestone-mark {{ $progress >= 25 ? 'reached' : '' }}">25%</span>
                    <span class="milestone-mark {{ $progress >= 50 ? 'reached' : '' }}">50%</span>
                    <span class="milestone-mark {{ $progress >= 75 ? 'reached' : '' }}">75%</span>
                    <span class="milestone-mark {{ $progress >= 100 ? 'reached' : '' }}">100%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SHARE CAMPAIGN LINK
         ══════════════════════════════════════ --}}
    <div class="share-box animate-in">
        <div class="share-box-header">
            <div style="width: 36px; height: 36px; background: #BFDBFE; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <svg style="width: 18px; height: 18px; color: #1E40AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
            </div>
            <div>
                <div class="share-box-title">Bagikan Link Kampanye</div>
                <div class="share-box-desc">Kirim ke anggota Gapoktan agar mereka bisa pesan online</div>
            </div>
        </div>
        <div class="share-input-row">
            <input type="text" class="share-input" id="shareLink" value="{{ url('/pre-order') }}" readonly>
            <button class="share-btn share-btn-copy" id="copyLinkBtn" onclick="copyShareLink()">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                <span id="copyBtnText">Salin Link</span>
            </button>
            <button class="share-btn share-btn-wa" onclick="shareWhatsApp()">
                <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path></svg>
                WhatsApp
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         MAIN CONTENT: Table + Sidebar
         ══════════════════════════════════════ --}}
    <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px;" class="ketua-main-grid animate-in">
        {{-- Left: Orders Table --}}
        <div>
            <div class="panel" style="margin-bottom: 24px;">
                <div class="panel-header">
                    <div class="panel-title">Daftar Pesanan Anggota</div>
                    <span class="badge badge-gray">{{ collect($orders)->count() }} pesanan</span>
                </div>

                {{-- Search & Filter Toolbar --}}
                <div class="table-toolbar">
                    <div class="table-search-wrapper">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" class="table-search" id="searchInput" placeholder="Cari nama petani..." oninput="filterTable()">
                    </div>
                    <button class="filter-btn active" data-filter="all" onclick="setFilter('all', this)">Semua</button>
                    <button class="filter-btn" data-filter="paid" onclick="setFilter('paid', this)">✅ Lunas</button>
                    <button class="filter-btn" data-filter="pending" onclick="setFilter('pending', this)">⏳ Pending</button>
                </div>

                <div class="panel-body-flush">
                    <table class="data-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Nama Petani</th>
                                <th class="right">Qty</th>
                                <th class="right">Subtotal</th>
                                <th class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $i => $order)
                            <tr data-name="{{ strtolower($order->user->name ?? '') }}" data-status="{{ $order->status }}">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="avatar-sm avatar-colors-{{ ($i % 5) + 1 }}">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight: 600; color: #0F2B1F;">{{ $order->user->name ?? 'Anggota' }}</div>
                                            <div style="font-size: 12px; color: #9CA3AF;">{{ $order->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="right" style="font-weight: 600;">{{ $order->quantity }} <span style="font-size:11px;color:#9CA3AF;">krg</span></td>
                                <td class="right" style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="center">
                                    @if($order->status === 'paid')
                                        <span class="badge badge-green">✅ Lunas</span>
                                    @else
                                        <span class="badge badge-amber">⏳ Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="4">
                                    <div class="empty-state">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        <h4>Belum ada pesanan</h4>
                                        <p>Bagikan link kampanye ke anggota Gapoktan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if(collect($orders)->count() > 0)
                        <tfoot>
                            <tr>
                                <td style="text-align: right; padding: 14px 24px; font-weight: 700;">TOTAL</td>
                                <td class="right" style="padding: 14px 24px; font-weight: 700;">{{ collect($orders)->sum('quantity') }} krg</td>
                                <td class="right" style="padding: 14px 24px; font-weight: 700;">Rp {{ number_format(collect($orders)->sum('total_price'), 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                    <div class="empty-state" id="noResultsMsg" style="display:none;">
                        <h4>Tidak ditemukan</h4>
                        <p>Tidak ada pesanan yang sesuai dengan filter.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div>
            {{-- Campaign Summary --}}
            <div class="panel" style="position: sticky; top: 80px;">
                <div class="panel-header">
                    <div class="panel-title">Ringkasan Kampanye</div>
                </div>
                <div class="panel-body">
                    <div style="padding-bottom: 16px; border-bottom: 1px solid #F3F4F6; margin-bottom: 16px;">
                        <div style="font-size: 12px; color: #6B7280; margin-bottom: 4px;">Komoditas</div>
                        <div style="font-size: 15px; font-weight: 700; color: #0F2B1F;">{{ $campaign->title }}</div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding-bottom: 16px; border-bottom: 1px solid #F3F4F6; margin-bottom: 16px;">
                        <div>
                            <div style="font-size: 12px; color: #6B7280; margin-bottom: 2px;">Harga/Unit</div>
                            <div style="font-size: 16px; font-weight: 700; color: #0F2B1F;">Rp {{ number_format($campaign->price_per_unit, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #6B7280; margin-bottom: 2px;">Deadline</div>
                            <div style="font-size: 14px; font-weight: 600; color: {{ $daysLeft <= 3 ? '#EF4444' : ($daysLeft <= 7 ? '#D97706' : '#0F2B1F') }};">{{ $campaign->closes_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    {{-- Payment Donut --}}
                    <div style="padding-bottom: 16px; border-bottom: 1px solid #F3F4F6; margin-bottom: 16px;">
                        <div style="font-size: 12px; font-weight: 600; color: #6B7280; margin-bottom: 12px;">Rasio Pembayaran</div>
                        <div class="donut-chart" style="background: conic-gradient(#16A34A 0deg {{ $paidPercent * 3.6 }}deg, #FDE68A {{ $paidPercent * 3.6 }}deg 360deg);">
                            <div class="donut-center" style="width: 68px; height: 68px; background: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div class="donut-center-value">{{ $paidPercent }}%</div>
                                <div class="donut-center-label">Lunas</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; gap: 16px; font-size: 12px;">
                            <span style="display: flex; align-items: center; gap: 4px;"><span style="width:8px;height:8px;background:#16A34A;border-radius:2px;display:inline-block;"></span> Lunas</span>
                            <span style="display: flex; align-items: center; gap: 4px;"><span style="width:8px;height:8px;background:#FDE68A;border-radius:2px;display:inline-block;"></span> Pending</span>
                        </div>
                    </div>

                    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 10px; padding: 14px; text-align: center; margin-bottom: 16px;">
                        <div style="font-size: 11px; color: #166534; font-weight: 600; margin-bottom: 4px;">EST. PENGHEMATAN</div>
                        <div style="font-size: 22px; font-weight: 800; color: #166534;">Rp {{ number_format($savings, 0, ',', '.') }}</div>
                        <div style="font-size: 11px; color: #16A34A;">-15% vs harga pasar</div>
                    </div>

                    <div style="background: #ECFEFF; border: 1px solid #A5F3FC; border-radius: 10px; padding: 14px; text-align: center; margin-bottom: 16px;">
                        <div style="font-size: 11px; color: #164E63; font-weight: 600; margin-bottom: 4px;">KOMISI BAGI HASIL</div>
                        <div style="font-size: 22px; font-weight: 800; color: #164E63;">Rp {{ number_format($komisiKetua, 0, ',', '.') }}</div>
                        @if($potensiKomisi > 0)
                            <div style="font-size: 11px; color: #0891B2;">+ Rp {{ number_format($potensiKomisi, 0, ',', '.') }} (pending)</div>
                        @endif
                        <div style="font-size: 11px; color: #0891B2; margin-top: 4px;">Porsi 40% dari Biaya Layanan</div>
                    </div>

                    <a href="{{ route('scan') }}" class="topbar-btn topbar-btn-green" style="width: 100%; justify-content: center; padding: 12px; border-radius: 10px; font-size: 14px;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        Scan QR Distribusi
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BOTTOM ROW: Activity Timeline + Campaign History
         ══════════════════════════════════════ --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 0;" class="ketua-main-grid animate-in">
        {{-- Activity Timeline --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Aktivitas Terkini</div>
                <span class="badge badge-blue">Live</span>
            </div>
            <div class="panel-body" style="max-height: 380px; overflow-y: auto;">
                @if($recentActivity->count() > 0)
                <ul class="timeline">
                    @foreach($recentActivity as $activity)
                    <li class="timeline-item">
                        <div class="timeline-dot" style="background: {{ $activity['bg'] }};">
                            @if($activity['icon'] === 'cart')
                            <svg style="color: {{ $activity['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            @elseif($activity['icon'] === 'cash')
                            <svg style="color: {{ $activity['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @else
                            <svg style="color: {{ $activity['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @endif
                        </div>
                        <div>
                            <div class="timeline-text">{{ $activity['text'] }}</div>
                            <div class="timeline-time">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h4>Belum ada aktivitas</h4>
                    <p>Aktivitas pesanan akan muncul di sini.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Campaign History --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Riwayat Kampanye</div>
                <span class="badge badge-gray">{{ $allCampaigns->count() }} total</span>
            </div>
            <div class="panel-body" style="max-height: 380px; overflow-y: auto;">
                @if($allCampaigns->count() > 0)
                    @foreach($allCampaigns as $camp)
                    <div class="history-card">
                        <div class="history-info">
                            <h4>
                                {{ $camp->title }}
                                @if($camp->id === $campaign->id)
                                    <span class="badge badge-green" style="font-size: 9px; vertical-align: middle;">AKTIF</span>
                                @elseif($camp->status === 'completed')
                                    <span class="badge badge-gray" style="font-size: 9px; vertical-align: middle;">SELESAI</span>
                                @elseif($camp->status === 'locked')
                                    <span class="badge badge-blue" style="font-size: 9px; vertical-align: middle;">LOCKED</span>
                                @else
                                    <span class="badge badge-amber" style="font-size: 9px; vertical-align: middle;">{{ strtoupper($camp->status) }}</span>
                                @endif
                            </h4>
                            <p>{{ $camp->created_at->format('d M Y') }} · Target: {{ $camp->target_amount }} karung</p>
                        </div>
                        <div class="history-stats">
                            <div class="history-stat">
                                <div class="history-stat-value">{{ $camp->orderedQuantity() }}</div>
                                <div class="history-stat-label">Pesan</div>
                            </div>
                            <div class="history-stat">
                                <div class="history-stat-value">{{ $camp->progressPercent() }}%</div>
                                <div class="history-stat-label">Progress</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="empty-state">
                    <h4>Belum ada riwayat</h4>
                    <p>Kampanye yang telah dibuat akan tampil di sini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         JAVASCRIPT
         ══════════════════════════════════════ --}}
    <script>
        // ── Countdown Timer ──
        (function() {
            const deadline = new Date('{{ $campaign->closes_at->toIso8601String() }}');

            function updateCountdown() {
                const now = new Date();
                let diff = deadline - now;

                if (diff <= 0) {
                    document.getElementById('cdDays').textContent = '0';
                    document.getElementById('cdHours').textContent = '00';
                    document.getElementById('cdMins').textContent = '00';
                    document.getElementById('cdSecs').textContent = '00';
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('cdDays').textContent = days;
                document.getElementById('cdHours').textContent = String(hours).padStart(2, '0');
                document.getElementById('cdMins').textContent = String(mins).padStart(2, '0');
                document.getElementById('cdSecs').textContent = String(secs).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        })();

        // ── Copy Link ──
        function copyShareLink() {
            const input = document.getElementById('shareLink');
            navigator.clipboard.writeText(input.value).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                const btnText = document.getElementById('copyBtnText');
                btn.classList.add('copied');
                btnText.textContent = '✓ Tersalin!';
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btnText.textContent = 'Salin Link';
                }, 2000);
            });
        }

        // ── Share WhatsApp ──
        function shareWhatsApp() {
            const url = document.getElementById('shareLink').value;
            const text = `Yuk patungan *{{ $campaign->title }}* di PatunganTani.id! 🌾\n\nHarga group-buy hanya *Rp {{ number_format($campaign->price_per_unit, 0, ',', '.') }}/karung* (hemat 15% dari harga pasar).\n\nSisa kuota: *{{ $campaign->remainingQuantity() }} karung*\nDeadline: *{{ $campaign->closes_at->format('d M Y') }}*\n\nPesan sekarang: ${url}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        }

        // ── Table Search & Filter ──
        let currentFilter = 'all';

        function setFilter(filter, btn) {
            currentFilter = filter;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterTable();
        }

        function filterTable() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#ordersTable tbody tr[data-name]');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const status = row.getAttribute('data-status');
                const matchesSearch = name.includes(query);
                const matchesFilter = currentFilter === 'all' || status === currentFilter;

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResultsMsg');
            const emptyRow = document.getElementById('emptyRow');
            if (noResults) noResults.style.display = visibleCount === 0 && rows.length > 0 ? 'block' : 'none';
            if (emptyRow && rows.length > 0) emptyRow.style.display = 'none';
        }
    </script>

    @else
    {{-- ══════════════════════════════════════
         NO CAMPAIGN - EMPTY STATE
         ══════════════════════════════════════ --}}
    <div class="panel animate-in">
        <div class="panel-body" style="text-align: center; padding: 64px 24px;">
            <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #F0FDF4, #DCFCE7); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg style="width: 36px; height: 36px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 style="font-size: 22px; font-weight: 800; color: #0F2B1F; margin-bottom: 8px;">Buat Kampanye Pertama Anda</h3>
            <p style="font-size: 14px; color: #6B7280; max-width: 400px; margin: 0 auto 24px; line-height: 1.6;">Mulai kumpulkan pesanan saprotan dari anggota Gapoktan Anda. Fitur share link memudahkan distribusi informasi.</p>
            <a href="{{ route('campaign.create') }}" class="topbar-btn topbar-btn-primary" style="padding: 14px 36px; font-size: 14px;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kampanye Baru
            </a>

            @if($allCampaigns->count() > 0)
            <div style="margin-top: 40px; padding-top: 32px; border-top: 1px solid #E8ECE9;">
                <h4 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 16px;">Riwayat Kampanye Anda</h4>
                @foreach($allCampaigns as $camp)
                <div class="history-card" style="text-align: left; max-width: 500px; margin: 0 auto;">
                    <div class="history-info">
                        <h4>
                            {{ $camp->title }}
                            <span class="badge badge-gray" style="font-size: 9px; vertical-align: middle;">{{ strtoupper($camp->status) }}</span>
                        </h4>
                        <p>{{ $camp->created_at->format('d M Y') }} · Target: {{ $camp->target_amount }} karung</p>
                    </div>
                    <div class="history-stats">
                        <div class="history-stat">
                            <div class="history-stat-value">{{ $camp->progressPercent() }}%</div>
                            <div class="history-stat-label">Progress</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endif
</x-app-layout>

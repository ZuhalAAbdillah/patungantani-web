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

        $hour = now()->format('H');
        if ($hour < 11) $greeting = 'Selamat Pagi';
        elseif ($hour < 15) $greeting = 'Selamat Siang';
        elseif ($hour < 18) $greeting = 'Selamat Sore';
        else $greeting = 'Selamat Malam';

        $firstName = explode(' ', Auth::user()->name)[0];

        $urgencyClass = '';
        if ($daysLeft <= 3) $urgencyClass = 'countdown-urgent';
        elseif ($daysLeft <= 7) $urgencyClass = 'countdown-warning';
    @endphp

    {{-- Welcome Banner --}}
    <div class="ketua-welcome animate-in">
        <div class="ketua-welcome-inner">
            <div>
                <h2>{{ $greeting }}, {{ $firstName }}! 👋</h2>
                <div class="welcome-subtitle">
                    Kampanye <strong style="color: #86EFAC;">{{ $campaign->title }}</strong> sedang berjalan.
                    {{ $totalVolume }} dari {{ $campaign->target_amount }} karung sudah terpesan.
                </div>
                @if($daysLeft <= 3 && $daysLeft > 0)
                    <div class="deadline-alert deadline-alert-danger">⚡ Deadline tinggal {{ $daysLeft }} hari!</div>
                @elseif($daysLeft <= 7)
                    <div class="deadline-alert deadline-alert-warning">⏳ {{ $daysLeft }} hari menuju deadline</div>
                @elseif($progress >= 100)
                    <div class="deadline-alert deadline-alert-success">🎉 Kuota tercapai! Siap untuk lock.</div>
                @else
                    <div class="deadline-alert deadline-alert-success">✅ {{ $daysLeft }} hari tersisa</div>
                @endif
            </div>
            <div class="countdown-box {{ $urgencyClass }}" id="countdownBoxPartial">
                <div class="countdown-unit">
                    <span class="countdown-number cd-days">{{ $daysLeft }}</span>
                    <span class="countdown-label">Hari</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number cd-hours">00</span>
                    <span class="countdown-label">Jam</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number cd-mins">00</span>
                    <span class="countdown-label">Menit</span>
                </div>
                <div class="countdown-unit">
                    <span class="countdown-number cd-secs">00</span>
                    <span class="countdown-label">Detik</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-grid stat-grid-6">
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
    </div>

    {{-- Progress Bar --}}
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

    {{-- Orders Table --}}
    <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px;" class="ketua-main-grid animate-in">
        <div>
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Daftar Pesanan Anggota</div>
                    <span class="badge badge-gray">{{ collect($orders)->count() }} pesanan</span>
                </div>
                <div class="panel-body-flush">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Petani</th>
                                <th class="right">Qty (Karung)</th>
                                <th class="right">Subtotal</th>
                                <th class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $i => $order)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="avatar-sm avatar-colors-{{ ($i % 5) + 1 }}">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight: 600; color: #0F2B1F;">{{ $order->user->name ?? 'Anggota' }}</div>
                                            <div style="font-size: 12px; color: #9CA3AF;">{{ $order->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="right" style="font-weight: 600;">{{ $order->quantity }}</td>
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
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state"><h4>Belum ada pesanan</h4><p>Bagikan link kampanye ke anggota Gapoktan.</p></div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if(collect($orders)->count() > 0)
                        <tfoot>
                            <tr>
                                <td style="text-align: right; padding: 14px 24px;">TOTAL</td>
                                <td class="right" style="padding: 14px 24px;">{{ collect($orders)->sum('quantity') }}</td>
                                <td class="right" style="padding: 14px 24px;">Rp {{ number_format(collect($orders)->sum('total_price'), 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Campaign Summary --}}
        <div>
            <div class="panel" style="position: sticky; top: 80px;">
                <div class="panel-header">
                    <div class="panel-title">Ringkasan</div>
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
                            <div style="font-size: 14px; font-weight: 600; color: #0F2B1F;">{{ $campaign->closes_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 10px; padding: 14px; text-align: center; margin-bottom: 16px;">
                        <div style="font-size: 11px; color: #166534; font-weight: 600; margin-bottom: 4px;">TOTAL TAGIHAN</div>
                        <div style="font-size: 24px; font-weight: 800; color: #166534;">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('scan') }}" class="topbar-btn topbar-btn-green" style="width: 100%; justify-content: center; padding: 12px; border-radius: 10px; font-size: 14px;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        Scan QR Distribusi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .ketua-main-grid { display: grid !important; grid-template-columns: 1fr !important; }
        }
    </style>

    @else
    {{-- No campaign --}}
    <div class="panel animate-in">
        <div class="panel-body" style="text-align: center; padding: 64px 24px;">
            <div style="width: 64px; height: 64px; background: #F0FDF4; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg style="width: 32px; height: 32px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 style="font-size: 20px; font-weight: 700; color: #0F2B1F; margin-bottom: 8px;">Buat Kampanye Pertama Anda</h3>
            <p style="font-size: 14px; color: #6B7280; max-width: 400px; margin: 0 auto 24px; line-height: 1.6;">Mulai kumpulkan pesanan saprotan dari anggota Gapoktan Anda.</p>
            <a href="{{ route('campaign.create') }}" class="topbar-btn topbar-btn-primary" style="padding: 12px 32px; font-size: 14px;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kampanye Baru
            </a>
        </div>
    </div>
    @endif

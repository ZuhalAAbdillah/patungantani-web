<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->format('H');
            $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
        @endphp
        <h1>{{ $greeting }}, {{ Auth::user()->name }}! 👋</h1>
        <p>Pantau pesanan, kupon, dan kampanye pre-order Anda di sini.</p>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; border: 1px solid #BBF7D0;" class="animate-in">
        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background: #FEE2E2; color: #991B1B; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border: 1px solid #FECACA;">{{ session('error') }}</div>
    @endif

    {{-- Pending Payment Alert --}}
    @if($pendingPayments > 0)
    <div style="background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 14px;" class="animate-in">
        <div style="width: 40px; height: 40px; border-radius: 10px; background: #FEF3C7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg style="width: 20px; height: 20px; color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 14px; font-weight: 700; color: #92400E;">{{ $pendingPayments }} Pesanan Menunggu Pembayaran</div>
            <div style="font-size: 13px; color: #B45309;">Segera selesaikan pembayaran agar pesanan Anda tidak dibatalkan.</div>
        </div>
        <a href="{{ route('orders.index') }}" style="font-size: 13px; font-weight: 700; color: #D97706; text-decoration: none; white-space: nowrap;">Bayar Sekarang →</a>
    </div>
    @endif

    <style>
        .qa-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .qa-card {
            display: flex; align-items: center; gap: 14px;
            background: #fff; border: 1px solid #E8ECE9; border-radius: 14px;
            padding: 18px 20px; text-decoration: none; transition: all 0.2s;
        }
        .qa-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.05); }
        .qa-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .qa-icon svg { width: 20px; height: 20px; }
        .qa-label { font-size: 14px; font-weight: 700; color: #0F2B1F; }
        .qa-sub { font-size: 12px; color: #6B7280; }

        .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .scard {
            background: #fff; border: 1px solid #E8ECE9; border-radius: 16px;
            padding: 22px 20px; position: relative; overflow: hidden;
        }
        .scard-accent { position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .scard-label { font-size: 12px; font-weight: 600; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 6px; }
        .scard-value { font-size: 28px; font-weight: 800; color: #0F2B1F; line-height: 1.1; }
        .scard-value.small { font-size: 22px; }
        .scard-sub { font-size: 12px; color: #6B7280; margin-top: 4px; }
        .scard-icon {
            position: absolute; top: 18px; right: 18px;
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .scard-icon svg { width: 20px; height: 20px; }

        .savings-banner {
            background: linear-gradient(135deg, #0F2B1F 0%, #166534 100%);
            border-radius: 16px; padding: 24px 28px; margin-bottom: 24px;
            display: flex; align-items: center; justify-content: space-between;
            color: #fff; position: relative; overflow: hidden;
        }
        .savings-banner::before {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(34,197,94,0.1); pointer-events: none;
        }
        .savings-banner::after {
            content: ''; position: absolute; bottom: -80px; left: -40px;
            width: 160px; height: 160px; border-radius: 50%;
            background: rgba(34,197,94,0.06); pointer-events: none;
        }
        .savings-left { position: relative; z-index: 1; }
        .savings-label { font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 4px; }
        .savings-value { font-size: 32px; font-weight: 800; letter-spacing: -1px; }
        .savings-desc { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .savings-right { position: relative; z-index: 1; display: flex; gap: 24px; }
        .savings-stat { text-align: center; }
        .savings-stat-val { font-size: 22px; font-weight: 800; }
        .savings-stat-label { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 2px; }
        .savings-stat-divider { width: 1px; background: rgba(255,255,255,0.1); }

        @media (max-width: 1024px) {
            .qa-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-row { grid-template-columns: repeat(2, 1fr); }
            .savings-banner { flex-direction: column; gap: 20px; text-align: center; }
            .savings-right { justify-content: center; }
        }
        @media (max-width: 768px) {
            .qa-grid { grid-template-columns: 1fr; }
            .stat-row { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .stat-row { grid-template-columns: 1fr; }
        }
    </style>

    {{-- Quick Actions --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        Aksi Cepat
    </h3>
    <div class="qa-grid animate-in">
        <a href="{{ route('page.pre-order') }}" class="qa-card" style="border-left: 3px solid #16A34A;">
            <div class="qa-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Ikut Pre-Order</div>
                <div class="qa-sub">{{ $activeCampaigns->count() }} kampanye aktif</div>
            </div>
        </a>
        <a href="{{ route('orders.index') }}" class="qa-card" style="border-left: 3px solid #6366F1;">
            <div class="qa-icon" style="background: #E0E7FF;">
                <svg style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <div class="qa-label">Pesanan Saya</div>
                <div class="qa-sub">{{ $totalOrders }} pesanan total</div>
            </div>
        </a>
        <a href="#kupon-section" class="qa-card" style="border-left: 3px solid #D97706;">
            <div class="qa-icon" style="background: #FEF3C7;">
                <svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Kupon Saya</div>
                <div class="qa-sub">{{ $activeKupons }} siap ambil</div>
            </div>
        </a>
        <a href="{{ route('profile.edit') }}" class="qa-card" style="border-left: 3px solid #8B5CF6;">
            <div class="qa-icon" style="background: #EDE9FE;">
                <svg style="color: #8B5CF6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Profil Saya</div>
                <div class="qa-sub">Edit data akun</div>
            </div>
        </a>
    </div>

    {{-- Savings Banner --}}
    @if($totalSpent > 0)
    <div class="savings-banner animate-in">
        <img src="{{ asset('images/fertilizer_bags.png') }}" alt="Fertilizer" style="position: absolute; left: 50%; top: -30px; transform: translateX(-50%); height: 160%; opacity: 0.6; mix-blend-mode: luminosity; pointer-events: none; mask-image: radial-gradient(circle, black 40%, transparent 70%); -webkit-mask-image: radial-gradient(circle, black 40%, transparent 70%); z-index: 0;">
        <div class="savings-left" style="position: relative; z-index: 2;">
            <div class="savings-label">💰 Estimasi Penghematan Anda</div>
            <div class="savings-value">Rp {{ number_format($estimatedSavings, 0, ',', '.') }}</div>
            <div class="savings-desc">Dibandingkan harga eceran, Anda hemat ~15% lewat patungan.</div>
        </div>
        <div class="savings-right" style="position: relative; z-index: 2;">
            <div class="savings-stat">
                <div class="savings-stat-val">{{ $totalQuantity }}</div>
                <div class="savings-stat-label">Karung</div>
            </div>
            <div class="savings-stat-divider"></div>
            <div class="savings-stat">
                <div class="savings-stat-val">{{ $totalOrders }}</div>
                <div class="savings-stat-label">Pesanan</div>
            </div>
            <div class="savings-stat-divider"></div>
            <div class="savings-stat">
                <div class="savings-stat-val">{{ $redeemedKupons }}</div>
                <div class="savings-stat-label">Diambil</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Stat Cards --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; margin-top: 32px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        Ringkasan Statistik
    </h3>
    <div class="stat-row animate-in">
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #16A34A, #22C55E);"></div>
            <div class="scard-label">Total Pesanan</div>
            <div class="scard-value">{{ $totalOrders }}</div>
            <div class="scard-sub">Sepanjang waktu</div>
            <div class="scard-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #D97706, #F59E0B);"></div>
            <div class="scard-label">Total Pengeluaran</div>
            <div class="scard-value small">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            <div class="scard-sub">Untuk saprotan</div>
            <div class="scard-icon" style="background: #FEF3C7;">
                <svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #16A34A, #4ADE80);"></div>
            <div class="scard-label">Kupon Siap Ambil</div>
            <div class="scard-value" style="color: #16A34A;">{{ $activeKupons }}</div>
            <div class="scard-sub">Menunggu pengambilan</div>
            <div class="scard-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #6366F1, #A78BFA);"></div>
            <div class="scard-label">Total Volume</div>
            <div class="scard-value">{{ $totalQuantity }}</div>
            <div class="scard-sub">Karung terpesan</div>
            <div class="scard-icon" style="background: #E0E7FF;">
                <svg style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>

    {{-- Two Column Layout --}}
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;" class="animate-in">
        {{-- Left: Recent Orders --}}
        <div>
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Pesanan Terakhir</div>
                    <a href="{{ route('orders.index') }}" class="panel-link">Lihat Semua →</a>
                </div>
                <div class="panel-body-flush">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kampanye</th>
                                <th class="right">Qty</th>
                                <th class="right">Total</th>
                                <th class="center">Status</th>
                                <th class="center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders->take(5) as $order)
                            <tr>
                                <td style="font-weight: 600; color: #0F2B1F;">{{ $order->campaign->title ?? '-' }}</td>
                                <td class="right">{{ $order->quantity }} <span style="color: #9CA3AF; font-size: 12px;">Karung</span></td>
                                <td class="right" style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="center">
                                    <span class="badge {{ $order->status === 'paid' ? 'badge-green' : 'badge-amber' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="center">
                                    @if($order->status === 'pending')
                                        <a href="{{ route('order.payment', $order->id) }}" style="color: #D97706; font-size: 13px; font-weight: 600; text-decoration: none;">Bayar →</a>
                                    @elseif($order->allocation)
                                        <a href="{{ route('kupon.show', $order->allocation->id) }}" style="color: #16A34A; font-size: 13px; font-weight: 600; text-decoration: none;">Kupon →</a>
                                    @else
                                        <span style="color: #D1D5DB;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <h4>Belum ada pesanan</h4>
                                        <p>Gabung kampanye pre-order untuk mulai hemat.</p>
                                        <a href="{{ route('page.pre-order') }}" class="topbar-btn topbar-btn-primary">Lihat Kampanye</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div style="display: flex; flex-direction: column; gap: 20px;">
            {{-- Active Campaigns --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Kampanye Aktif</div>
                    <a href="{{ route('page.pre-order') }}" class="panel-link">Semua →</a>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse($activeCampaigns->take(3) as $campaign)
                    @php $daysLeft = now()->diffInDays($campaign->closes_at, false); @endphp
                    <div style="border: 1px solid #E8ECE9; border-radius: 12px; padding: 16px; transition: border-color 0.15s ease;" onmouseover="this.style.borderColor='#86EFAC'" onmouseout="this.style.borderColor='#E8ECE9'">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <h4 style="font-size: 14px; font-weight: 700; color: #0F2B1F; margin: 0;">{{ $campaign->title }}</h4>
                            <span style="font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px; white-space: nowrap; {{ $daysLeft <= 3 ? 'background: #FEE2E2; color: #991B1B;' : 'background: #DCFCE7; color: #166534;' }}">
                                {{ $daysLeft > 0 ? $daysLeft . ' hari' : 'Ditutup' }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6B7280; margin-bottom: 6px;">
                            <span>{{ $campaign->orderedQuantity() }} / {{ $campaign->target_amount }}</span>
                            <span style="font-weight: 700; color: {{ $campaign->progressPercent() >= 100 ? '#16A34A' : '#D97706' }};">{{ $campaign->progressPercent() }}%</span>
                        </div>
                        <div class="progress-track" style="height: 6px; margin-bottom: 14px;">
                            <div class="progress-fill {{ $campaign->progressPercent() >= 100 ? 'progress-fill-green' : 'progress-fill-amber' }}" style="width: {{ $campaign->progressPercent() }}%;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 16px; font-weight: 700; color: #0F2B1F;">Rp {{ number_format($campaign->price_per_unit, 0, ',', '.') }}</span>
                            <form action="{{ route('order.store', $campaign->id) }}" method="POST" style="display: flex; gap: 6px; align-items: center;">
                                @csrf
                                <input type="number" name="quantity" value="10" min="1" style="width: 50px; border: 1px solid #D1D5DB; border-radius: 8px; padding: 5px 4px; font-size: 12px; text-align: center; font-family: inherit;">
                                <button type="submit" class="topbar-btn topbar-btn-green" style="padding: 5px 12px; font-size: 12px;">Pesan</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="padding: 20px 0;"><p>Belum ada kampanye aktif.</p></div>
                    @endforelse
                </div>
            </div>

            {{-- Quick Kupon --}}
            @php
                $readyKupons = $orders->filter(fn($o) => 
                    $o->allocation && 
                    $o->allocation->status === 'allocated' && 
                    $o->allocation->qrCode &&
                    $o->campaign && 
                    $o->campaign->isTargetReached()
                )->take(3);
            @endphp
            <div class="panel" id="kupon-section">
                <div class="panel-header">
                    <div class="panel-title">🎫 Kupon Saya</div>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse($readyKupons as $ko)
                    <a href="{{ route('kupon.show', $ko->allocation->id) }}" style="display: flex; align-items: center; gap: 14px; border: 1px solid #DCFCE7; background: #F0FDF4; border-radius: 10px; padding: 14px; text-decoration: none; transition: all 0.15s;" onmouseover="this.style.borderColor='#16A34A'" onmouseout="this.style.borderColor='#DCFCE7'">
                        <div style="width: 40px; height: 40px; background: #16A34A; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 20px; height: 20px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 14px; font-weight: 600; color: #0F2B1F;">{{ $ko->campaign->title ?? 'Saprotan' }}</div>
                            <div style="font-size: 12px; color: #6B7280;">{{ $ko->quantity }} Karung — <span style="color: #16A34A; font-weight: 600;">Siap Ambil</span></div>
                        </div>
                        <svg style="width: 16px; height: 16px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @empty
                    <div style="text-align: center; padding: 20px 0;">
                        <div style="width: 48px; height: 48px; background: #F3F4F6; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <svg style="width: 22px; height: 22px; color: #9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <p style="font-size: 13px; color: #9CA3AF;">Belum ada kupon yang siap diambil.</p>
                        <p style="font-size: 12px; color: #D1D5DB; margin-top: 4px;">Ikut pre-order dan bayar untuk mendapatkan kupon.</p>
                    </div>
                    @endforelse

                    @if($redeemedKupons > 0)
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: #F9FAFB; border-radius: 8px; margin-top: 4px;">
                        <svg style="width: 16px; height: 16px; color: #9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span style="font-size: 12px; color: #6B7280;">{{ $redeemedKupons }} kupon sudah ditebus sebelumnya</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info Card --}}
            <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 14px; padding: 20px;">
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #DCFCE7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 18px; height: 18px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 700; color: #166534; margin: 0 0 4px 0;">Cara Mengambil Saprotan</h4>
                        <ol style="font-size: 12px; color: #15803D; line-height: 1.7; padding-left: 16px; margin: 0;">
                            <li>Buka kupon QR dari halaman pesanan</li>
                            <li>Tunjukkan QR ke Ketua di titik kumpul</li>
                            <li>Ketua scan QR untuk verifikasi</li>
                            <li>Terima saprotan sesuai pesanan ✅</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .animate-in > div:first-child { order: 1; }
            div[style*="grid-template-columns: 1.5fr 1fr"] { grid-template-columns: 1fr !important; }
        }
    </style>
</x-app-layout>

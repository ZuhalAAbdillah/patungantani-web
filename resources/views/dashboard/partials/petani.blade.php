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

    {{-- Stat Cards --}}
    <div class="stat-grid stat-grid-3">
        <div class="stat-card animate-in animate-delay-1">
            <div class="stat-card-label">Total Pesanan</div>
            <div class="stat-card-value">{{ $totalOrders }}</div>
            <div class="stat-card-sub">Sepanjang waktu</div>
            <div class="stat-card-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="stat-card animate-in animate-delay-2">
            <div class="stat-card-label">Total Pengeluaran</div>
            <div class="stat-card-value" style="font-size: 24px;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            <div class="stat-card-sub">Untuk saprotan</div>
            <div class="stat-card-icon" style="background: #FEF3C7;">
                <svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="stat-card animate-in animate-delay-3">
            <div class="stat-card-label">Kupon Siap Ambil</div>
            <div class="stat-card-value green">{{ $activeKupons }}</div>
            <div class="stat-card-sub">Menunggu pengambilan</div>
            <div class="stat-card-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Two Columns --}}
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;" class="animate-in animate-delay-4">
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
                                        <a href="{{ route('order.payment', $order->id) }}" style="color: #16A34A; font-size: 13px; font-weight: 600; text-decoration: none;">Bayar →</a>
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
                                        <p>Gabung kampanye pre-order di halaman utama.</p>
                                        <a href="/#pre-order" class="topbar-btn topbar-btn-primary">Lihat Kampanye</a>
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
            {{-- Quick Kupon --}}
            @php
                $readyKupons = $orders->filter(fn($o) => $o->allocation && $o->allocation->status === 'allocated' && $o->allocation->qrCode)->take(2);
            @endphp
            @if($readyKupons->count() > 0)
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">🎫 Kupon Siap Ambil</div>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($readyKupons as $ko)
                    <a href="{{ route('kupon.show', $ko->allocation->id) }}" style="display: flex; align-items: center; gap: 14px; border: 1px solid #DCFCE7; background: #F0FDF4; border-radius: 10px; padding: 14px; text-decoration: none; transition: all 0.15s;" onmouseover="this.style.borderColor='#16A34A'" onmouseout="this.style.borderColor='#DCFCE7'">
                        <div style="width: 40px; height: 40px; background: #16A34A; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 20px; height: 20px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 14px; font-weight: 600; color: #0F2B1F;">{{ $ko->campaign->title ?? 'Saprotan' }}</div>
                            <div style="font-size: 12px; color: #6B7280;">{{ $ko->quantity }} Karung</div>
                        </div>
                        <svg style="width: 16px; height: 16px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .animate-delay-4 > div:first-child { order: 1; }
            .animate-delay-4 { grid-template-columns: 1fr !important; }
        }
    </style>

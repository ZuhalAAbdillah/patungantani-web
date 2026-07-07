<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->format('H');
            $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $firstName = explode(' ', Auth::user()->name)[0];
        @endphp
        <h1>{{ $greeting }}, {{ $firstName }}! 👋</h1>
        <p>Panel Admin — Ringkasan aktivitas platform PatunganTani.id</p>
    </x-slot>

    <style>
        /* Welcome Banner */
        .admin-welcome {
            background: linear-gradient(135deg, #0F2B1F 0%, #166534 50%, #16A34A 100%);
            border-radius: 18px; padding: 28px 32px; color: #fff; margin-bottom: 24px; position: relative; overflow: hidden;
        }
        .admin-welcome::before {
            content: ''; position: absolute; top: -40%; right: -10%; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%); border-radius: 50%;
        }
        .admin-welcome::after {
            content: ''; position: absolute; bottom: -30%; left: 20%; width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%;
        }
        .admin-welcome-inner { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; gap: 24px; flex-wrap: wrap; }
        .admin-welcome h2 { font-size: 22px; font-weight: 800; margin-bottom: 6px; line-height: 1.3; }
        .admin-welcome .welcome-subtitle { font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.5; }

        /* Quick Actions Grid */
        .qa-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .qa-card {
            display: flex; align-items: center; gap: 14px;
            background: #fff; border: 1px solid #E8ECE9; border-radius: 14px;
            padding: 18px 20px; text-decoration: none; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;
        }
        .qa-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
        .qa-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.2s;
        }
        .qa-card:hover .qa-icon { transform: scale(1.05); }
        .qa-icon svg { width: 20px; height: 20px; }
        .qa-label { font-size: 14px; font-weight: 700; color: #0F2B1F; }
        .qa-sub { font-size: 12px; color: #6B7280; }

        /* Stat Cards */
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

        @media (max-width: 1024px) {
            .qa-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .qa-grid { grid-template-columns: 1fr; }
            .stat-row { grid-template-columns: 1fr 1fr; }
            .admin-main-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .stat-row { grid-template-columns: 1fr; }
        }
    </style>

    {{-- Welcome Banner --}}
    <div class="admin-welcome animate-in">
        <img src="{{ asset('images/farmer_working.png') }}" alt="Admin" style="position: absolute; right: 280px; top: -50px; height: 150%; opacity: 0.6; mix-blend-mode: luminosity; pointer-events: none; mask-image: radial-gradient(circle, black 30%, transparent 70%); -webkit-mask-image: radial-gradient(circle, black 30%, transparent 70%); z-index: 0;">
        <div class="admin-welcome-inner">
            <div>
                <h2 style="position: relative; z-index: 2;">{{ $greeting }}, {{ $firstName }}! 🛡️</h2>
                <div class="welcome-subtitle" style="position: relative; z-index: 2;">
                    Memantau <strong style="color: #86EFAC;">{{ $activeCampaigns }} kampanye aktif</strong> dan <strong style="color: #86EFAC;">{{ $totalUsers }} pengguna</strong> terdaftar di platform.
                </div>
            </div>
            <div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); border-radius: 12px; padding: 12px 20px; border: 1px solid rgba(255,255,255,0.1); position: relative; z-index: 2; text-align: center;">
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.7); margin-bottom: 4px;">Status Sistem</div>
                <div style="font-size: 16px; font-weight: 700; color: #86EFAC; display: flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; background: #86EFAC; border-radius: 50%; box-shadow: 0 0 8px #86EFAC;"></span>
                    Online
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        Aksi Cepat
    </h3>
    <div class="qa-grid animate-in animate-delay-1">
        <a href="{{ route('campaign.create') }}" class="qa-card" style="border-left: 3px solid #16A34A;" onmouseover="this.style.borderColor='#16A34A'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Buat Kampanye</div>
                <div class="qa-sub">Kampanye pre-order baru</div>
            </div>
        </a>
        <a href="{{ route('scan') }}" class="qa-card" style="border-left: 3px solid #7C3AED;" onmouseover="this.style.borderColor='#7C3AED'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #EDE9FE;">
                <svg style="color: #7C3AED;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Scan QR</div>
                <div class="qa-sub">Distribusi kupon saprotan</div>
            </div>
        </a>
        <a href="{{ route('dashboard.export-csv') }}" class="qa-card" style="border-left: 3px solid #D97706;" onmouseover="this.style.borderColor='#D97706'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #FEF3C7;">
                <svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Unduh Laporan</div>
                <div class="qa-sub">CSV Rekap Pesanan</div>
            </div>
        </a>
        <a href="{{ route('admin.finance') }}" class="qa-card" style="border-left: 3px solid #0EA5E9;" onmouseover="this.style.borderColor='#0EA5E9'" onmouseout="this.style.borderColor='#E8ECE9'">
            <div class="qa-icon" style="background: #E0F2FE;">
                <svg style="color: #0EA5E9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <div class="qa-label">Laporan Keuangan</div>
                <div class="qa-sub">Cek laba rugi & omset</div>
            </div>
        </a>
    </div>

    {{-- Stat Cards --}}
    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin-bottom: 12px; margin-top: 32px; display: flex; align-items: center; gap: 8px;">
        <svg style="width:18px;height:18px;color:#16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        Ringkasan Statistik
    </h3>
    <div class="stat-row animate-in animate-delay-2">
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #3B82F6, #60A5FA);"></div>
            <div class="scard-label">Total Pengguna</div>
            <div class="scard-value">{{ $totalUsers }}</div>
            <div class="scard-sub">{{ $totalPetani }} Petani · {{ $totalKetua }} Ketua</div>
            <div class="scard-icon" style="background: #DBEAFE;">
                <svg style="color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #16A34A, #22C55E);"></div>
            <div class="scard-label">Total Kampanye</div>
            <div class="scard-value">{{ $totalCampaigns }}</div>
            <div class="scard-sub"><span style="color: #16A34A; font-weight: 600;">{{ $activeCampaigns }} aktif</span></div>
            <div class="scard-icon" style="background: #DCFCE7;">
                <svg style="color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #6366F1, #A78BFA);"></div>
            <div class="scard-label">Total Pesanan</div>
            <div class="scard-value">{{ $totalOrders }}</div>
            <div class="scard-sub">Transaksi terdaftar</div>
            <div class="scard-icon" style="background: #E0E7FF;">
                <svg style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="scard">
            <div class="scard-accent" style="background: linear-gradient(90deg, #D97706, #F59E0B);"></div>
            <div class="scard-label">Total Pendapatan</div>
            <div class="scard-value small" style="color: #D97706;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="scard-sub">Dari pembayaran lunas</div>
            <div class="scard-icon" style="background: #FEF3C7;">
                <svg style="color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Main Tables Layout --}}
    <div class="admin-main-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        {{-- Left: Recent Orders --}}
        <div class="animate-in animate-delay-3">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Pesanan Terbaru</div>
                    <span class="badge badge-gray">{{ $recentOrders->count() }} terbaru</span>
                </div>
                <div class="panel-body-flush">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Petani</th>
                                <th>Kampanye</th>
                                <th class="right">Qty</th>
                                <th class="right">Total</th>
                                <th class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $i => $order)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="avatar-sm avatar-colors-{{ ($i % 5) + 1 }}">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</div>
                                        <div>
                                            <div style="font-weight: 600; color: #0F2B1F; font-size: 13px;">{{ $order->user->name ?? 'N/A' }}</div>
                                            <div style="font-size: 11px; color: #9CA3AF;">{{ $order->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 13px; color: #6B7280; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $order->campaign->title ?? '-' }}
                                </td>
                                <td class="right" style="font-weight: 600;">{{ $order->quantity }} <span style="font-size:11px;color:#9CA3AF;">krg</span></td>
                                <td class="right" style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="center">
                                    <span class="badge {{ $order->status === 'paid' ? 'badge-green' : ($order->status === 'pending' ? 'badge-amber' : 'badge-gray') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"><div class="empty-state"><h4>Belum ada pesanan</h4></div></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div style="display: flex; flex-direction: column; gap: 24px;" class="animate-in animate-delay-4">
            {{-- Campaigns --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Kampanye Terbaru</div>
                    <a href="{{ route('page.pre-order') }}" class="panel-link">Semua →</a>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse($recentCampaigns as $campaign)
                    <div style="border: 1px solid #E8ECE9; border-radius: 12px; padding: 16px; transition: border-color 0.15s ease;" onmouseover="this.style.borderColor='#86EFAC'" onmouseout="this.style.borderColor='#E8ECE9'">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <h4 style="font-size: 14px; font-weight: 700; color: #0F2B1F; margin: 0; flex: 1; padding-right: 10px;">{{ $campaign->title }}</h4>
                            <span class="badge {{ $campaign->status === 'active' ? 'badge-green' : 'badge-gray' }}" style="flex-shrink: 0;">{{ ucfirst($campaign->status) }}</span>
                        </div>
                        <div style="font-size: 12px; color: #6B7280; margin-bottom: 10px;">
                            Oleh: <strong style="color:#374151;">{{ $campaign->creator->name ?? 'N/A' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6B7280; margin-bottom: 6px;">
                            <span>{{ $campaign->orderedQuantity() }} / {{ $campaign->target_amount }}</span>
                            <span style="font-weight: 700; color: {{ $campaign->progressPercent() >= 100 ? '#16A34A' : '#D97706' }};">{{ $campaign->progressPercent() }}%</span>
                        </div>
                        <div class="progress-track" style="height: 6px;">
                            <div class="progress-fill {{ $campaign->progressPercent() >= 100 ? 'progress-fill-green' : 'progress-fill-amber' }}" style="width: {{ $campaign->progressPercent() }}%;"></div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="padding: 20px 0;"><p>Belum ada kampanye.</p></div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Users --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Pengguna Baru</div>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 2px;">
                    @forelse($recentUsers as $i => $user)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; {{ !$loop->last ? 'border-bottom: 1px solid #F3F4F6;' : '' }}">
                        <div class="avatar-sm avatar-colors-{{ ($i % 5) + 1 }}">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 14px; font-weight: 600; color: #0F2B1F; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $user->name }}</div>
                            <div style="font-size: 12px; color: #9CA3AF; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $user->email }}</div>
                        </div>
                        @php
                            $roleBadge = match($user->role) {
                                'admin' => 'badge-red',
                                'ketua' => 'badge-amber',
                                default => 'badge-green',
                            };
                        @endphp
                        <span class="badge {{ $roleBadge }}" style="text-transform: uppercase;">{{ $user->role }}</span>
                    </div>
                    @empty
                    <div class="empty-state" style="padding: 20px 0;"><p>Tidak ada data.</p></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h1>Laporan Keuangan</h1>
        <p>Pantau omset, potensi pendapatan, dan estimasi laba rugi platform.</p>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('dashboard') }}" class="topbar-btn topbar-btn-outline">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </x-slot>

    <style>
        .finance-banner {
            background: linear-gradient(135deg, #0F2B1F 0%, #064E3B 100%);
            border-radius: 18px; padding: 32px; color: #fff; margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;
        }
        .finance-banner-left h2 { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
        .finance-banner-left p { color: #A7F3D0; font-size: 14px; }
        
        .stat-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .fcard { background: #fff; border: 1px solid #E8ECE9; border-radius: 16px; padding: 18px; position: relative; overflow: hidden; }
        .fcard-accent { position: absolute; top: 0; left: 0; right: 0; height: 4px; }
        .fcard-label { font-size: 11px; font-weight: 700; color: #6B7280; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: calc(100% - 40px); }
        .fcard-value { font-size: 24px; font-weight: 800; color: #0F2B1F; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .fcard-icon { position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .fcard-icon svg { width: 18px; height: 18px; }

        @media (max-width: 768px) {
            .stat-grid-4 { grid-template-columns: 1fr; }
        }
    </style>

    <div class="finance-banner animate-in">
        <div class="finance-banner-left">
            <h2>Ringkasan Laba Rugi</h2>
            <p>Estimasi laba dihitung berdasarkan porsi bagi hasil Admin (60% dari Biaya Layanan 5% platform) dari total omset pesanan lunas.</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 16px 24px; border-radius: 12px; text-align: center;">
            <div style="font-size: 12px; color: #A7F3D0; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Total Omset Platform</div>
            <div style="font-size: 28px; font-weight: 800; color: #fff;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="stat-grid-4 animate-in animate-delay-1">
        <div class="fcard">
            <div class="fcard-accent" style="background: linear-gradient(90deg, #10B981, #34D399);"></div>
            <div class="fcard-label">Keuntungan Admin</div>
            <div class="fcard-value" style="color: #10B981;">Rp {{ number_format($estimatedProfit, 0, ',', '.') }}</div>
            <div class="fcard-icon" style="background: #D1FAE5;">
                <svg style="color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="fcard">
            <div class="fcard-accent" style="background: linear-gradient(90deg, #F59E0B, #FBBF24);"></div>
            <div class="fcard-label">Potensi Omset (Pending)</div>
            <div class="fcard-value" style="color: #F59E0B;">Rp {{ number_format($potentialRevenue, 0, ',', '.') }}</div>
            <div class="fcard-icon" style="background: #FEF3C7;">
                <svg style="color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="fcard">
            <div class="fcard-accent" style="background: linear-gradient(90deg, #0EA5E9, #38BDF8);"></div>
            <div class="fcard-label">Komisi Ketua (40%)</div>
            <div class="fcard-value" style="color: #0EA5E9;">Rp {{ number_format($totalKetuaProfit, 0, ',', '.') }}</div>
            <div class="fcard-icon" style="background: #E0F2FE;">
                <svg style="color: #0EA5E9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="fcard">
            <div class="fcard-accent" style="background: linear-gradient(90deg, #6366F1, #818CF8);"></div>
            <div class="fcard-label">Total Kampanye</div>
            <div class="fcard-value">{{ $campaigns->count() }}</div>
            <div class="fcard-icon" style="background: #E0E7FF;">
                <svg style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="panel animate-in animate-delay-2">
        <div class="panel-header">
            <div class="panel-title">Rincian Pendapatan per Kampanye</div>
        </div>
        <div class="panel-body-flush">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kampanye</th>
                        <th>Kreator (Ketua)</th>
                        <th class="right">Volume Terjual (Lunas)</th>
                        <th class="right">Omset (Lunas)</th>
                        <th class="right">Potensi (Pending)</th>
                        <th class="right">Keuntungan Admin</th>
                        <th class="right">Komisi Ketua</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        <td style="font-weight: 600; color: #0F2B1F;">{{ $campaign->title }}</td>
                        <td>{{ $campaign->creator->name ?? 'N/A' }}</td>
                        <td class="right">{{ $campaign->paid_volume }} <span style="font-size: 11px; color: #9CA3AF;">krg</span></td>
                        <td class="right" style="color: #10B981; font-weight: 600;">Rp {{ number_format($campaign->omset, 0, ',', '.') }}</td>
                        <td class="right" style="color: #F59E0B;">Rp {{ number_format($campaign->potensi, 0, ',', '.') }}</td>
                        <td class="right" style="color: #0F2B1F; font-weight: 700;">Rp {{ number_format($campaign->laba, 0, ',', '.') }}</td>
                        <td class="right" style="color: #0EA5E9; font-weight: 700;">Rp {{ number_format($campaign->komisi_ketua, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7"><div class="empty-state"><h4>Belum ada data keuangan.</h4></div></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

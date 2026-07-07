<x-app-layout>
    <style>
        .page-hero {
            padding: 120px 32px 60px; text-align: center;
            background: linear-gradient(180deg, var(--green-50) 0%, #fff 100%);
            position: relative; overflow: hidden; margin-top: -72px;
        }
        .page-hero::before {
            content: ''; position: absolute; top: -150px; left: 50%; transform: translateX(-50%);
            width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(22,163,74,0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        .page-hero .section-badge { animation: fadeInUp 0.5s ease; }
        .page-hero h1 {
            font-size: 44px; font-weight: 900; color: var(--green-900);
            letter-spacing: -1.5px; line-height: 1.1; max-width: 700px; margin: 0 auto 16px;
            animation: fadeInUp 0.5s ease 0.1s both;
        }
        .page-hero p {
            font-size: 17px; color: var(--gray-500); line-height: 1.7;
            max-width: 540px; margin: 0 auto;
            animation: fadeInUp 0.5s ease 0.2s both;
        }

        .section { max-width: 1100px; margin: 0 auto; padding: 60px 32px 80px; }
        .section-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-100); color: var(--green-700);
            padding: 5px 14px; border-radius: 99px; font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px;
        }

        /* ── Filter bar ── */
        .filter-bar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 32px; gap: 16px; flex-wrap: wrap;
        }
        .filter-info { font-size: 15px; color: var(--gray-500); }
        .filter-info strong { color: var(--green-900); font-weight: 800; }

        /* ── Campaign Cards ── */
        .po-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .po-card {
            background: #fff; border: 1px solid var(--gray-200); border-radius: 20px;
            overflow: hidden; transition: all 0.3s ease;
        }
        .po-card:hover { border-color: var(--green-400); transform: translateY(-6px); box-shadow: 0 16px 40px rgba(22,163,74,0.08); }
        .po-card-image {
            height: 200px; background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
            display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;
        }
        .po-card-image img { height: 130px; object-fit: contain; filter: drop-shadow(0 6px 16px rgba(0,0,0,0.08)); transition: transform 0.3s ease; }
        .po-card:hover .po-card-image img { transform: scale(1.08); }
        .po-badge-row { position: absolute; top: 12px; left: 12px; right: 12px; display: flex; justify-content: space-between; }
        .po-badge {
            padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;
            background: rgba(255,255,255,0.95); color: var(--gray-700);
            backdrop-filter: blur(8px); box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }
        .po-badge-status {
            padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;
            backdrop-filter: blur(8px);
        }
        .po-badge-active { background: #DCFCE7; color: #166534; }
        .po-badge-full { background: #DBEAFE; color: #1E40AF; }
        .po-card-body { padding: 24px; }
        .po-card-body h3 { font-size: 18px; font-weight: 800; color: var(--green-900); margin-bottom: 6px; }
        .po-card-body .subtitle { font-size: 13px; color: var(--gray-500); margin-bottom: 18px; line-height: 1.5; }
        .po-meta { display: flex; gap: 16px; margin-bottom: 18px; }
        .po-meta-item { font-size: 12px; color: var(--gray-500); display: flex; align-items: center; gap: 4px; }
        .po-meta-item svg { width: 14px; height: 14px; }
        .progress-row { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; }
        .progress-row .label { color: var(--gray-500); }
        .progress-row .pct { font-weight: 700; }
        .progress-row .pct.green { color: var(--green-600); }
        .progress-row .pct.orange { color: var(--amber-600); }
        .progress-bar { width: 100%; height: 8px; background: var(--gray-200); border-radius: 99px; margin-bottom: 20px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 99px; transition: width 0.8s ease; }
        .progress-bar-fill.green, .progress-bar-fill.full { background: linear-gradient(90deg, var(--green-600), var(--green-500)); }
        .progress-bar-fill.orange { background: linear-gradient(90deg, var(--amber-600), var(--amber-500)); }
        .po-card-footer { display: flex; justify-content: space-between; align-items: center; }
        .price-tag { font-size: 22px; font-weight: 800; color: var(--green-900); }
        .price-tag small { font-size: 12px; font-weight: 500; color: var(--gray-400); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-on-scroll { opacity: 0; transform: translateY(20px); transition: all 0.6s ease; }
        .animate-on-scroll.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 1024px) { .po-grid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 768px) {
            .page-hero h1 { font-size: 32px; }
            .po-grid { grid-template-columns: 1fr; }
        }
    </style>

    <!-- Hero -->
    <section class="page-hero">
        <div class="section-badge">🛒 Pesanan Bersama</div>
        <h1>Kampanye Pesanan (PO) Aktif</h1>
        <p>Mari bergabung dalam pesanan bersama sebelum kuota terpenuhi. Makin banyak rekan petani yang ikut berpartisipasi, harga yang didapat akan semakin murah.</p>
    </section>

    <!-- Campaign List -->
    <section class="section">
        <div class="filter-bar">
            <div class="filter-info">
                Menampilkan <strong>{{ $campaigns->count() }}</strong> kampanye aktif
            </div>
        </div>

        <div class="po-grid">
            @forelse($campaigns as $campaign)
            @php
                $progress = $campaign->progressPercent();
                $ordersQty = $campaign->orderedQuantity();
                $remaining = $campaign->remainingQuantity();
                $daysLeft = now()->diffInDays($campaign->closes_at, false);
            @endphp
            <div class="po-card animate-on-scroll">
                <div class="po-card-image">
                    <div class="po-badge-row">
                        <span class="po-badge">📅 s/d {{ $campaign->closes_at->format('d M Y') }}</span>
                        <span class="po-badge-status {{ $progress >= 100 ? 'po-badge-full' : 'po-badge-active' }}">
                            {{ $progress >= 100 ? '🔒 Kuota Penuh' : '🟢 Dibuka' }}
                        </span>
                    </div>
                    <img src="{{ asset('images/fertilizer_bag.png') }}" alt="{{ $campaign->title }}">
                </div>
                <div class="po-card-body">
                    <h3>{{ $campaign->title }}</h3>
                    <p class="subtitle">{{ Str::limit($campaign->description ?? 'Pre-Order Saprotan Gapoktan', 80) }}</p>

                    <div class="po-meta">
                        <div class="po-meta-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $daysLeft > 0 ? $daysLeft . ' hari lagi' : 'Sudah ditutup' }}
                        </div>
                        <div class="po-meta-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Sisa {{ $remaining }} karung
                        </div>
                    </div>

                    <div class="progress-row">
                        <span class="label">{{ $ordersQty }} / {{ $campaign->target_amount }} Karung</span>
                        <span class="pct {{ $progress >= 100 ? 'green' : 'orange' }}">{{ $progress }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-bar-fill {{ $progress >= 100 ? 'full' : 'orange' }}" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="po-card-footer">
                        <div class="price-tag">Rp {{ number_format($campaign->price_per_unit, 0, ',', '.') }} <small>/Karung</small></div>
                        @auth
                        <form action="{{ route('order.store', $campaign->id) }}" method="POST" style="display: flex; gap: 6px; align-items: center;">
                            @csrf
                            <input type="number" name="quantity" value="10" min="1" max="{{ $remaining > 0 ? $remaining : 1 }}" style="width: 56px; border: 1px solid var(--gray-200); border-radius: 10px; padding: 8px 4px; font-size: 13px; text-align: center; font-family: inherit;">
                            <button type="submit" class="btn btn-green btn-sm">Pesan</button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Masuk & Pesan</a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 0;">
                <div style="width: 72px; height: 72px; background: var(--gray-100); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <svg style="width: 32px; height: 32px; color: var(--gray-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: var(--gray-700); margin-bottom: 8px;">Belum Ada Kampanye Aktif</h3>
                <p style="font-size: 15px; color: var(--gray-500); max-width: 400px; margin: 0 auto 24px; line-height: 1.6;">Kampanye pre-order baru akan segera dibuka oleh Ketua Gapoktan Anda. Daftar sekarang agar tidak ketinggalan!</p>
                @guest
                <a href="{{ route('register') }}" class="btn btn-dark btn-lg">Daftar Sekarang</a>
                @endguest
            </div>
            @endforelse
        </div>
    </section>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>
</x-app-layout>

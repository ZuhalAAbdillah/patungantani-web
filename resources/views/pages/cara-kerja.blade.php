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

        .section { max-width: 1100px; margin: 0 auto; padding: 80px 32px; }
        .section-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-100); color: var(--green-700);
            padding: 5px 14px; border-radius: 99px; font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px;
        }

        /* ── Timeline Steps ── */
        .timeline { position: relative; padding: 0; }
        .timeline::before {
            content: ''; position: absolute; left: 50%; top: 0; bottom: 0;
            width: 3px; background: linear-gradient(to bottom, var(--green-500), var(--green-200));
            transform: translateX(-50%); border-radius: 99px;
        }
        .timeline-item {
            display: flex; align-items: flex-start; gap: 48px; margin-bottom: 64px;
            position: relative;
        }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-item:nth-child(even) { flex-direction: row-reverse; }
        .timeline-item:nth-child(even) .tl-content { text-align: right; }
        .timeline-dot {
            position: absolute; left: 50%; top: 24px; transform: translateX(-50%);
            width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 22px; z-index: 2;
            background: var(--green-600); color: #fff;
            box-shadow: 0 6px 20px rgba(22,163,74,0.25);
            transition: transform 0.3s ease;
        }
        .timeline-item:hover .timeline-dot { transform: translateX(-50%) scale(1.1); }
        .tl-content {
            flex: 1; padding: 20px 0;
        }
        .tl-content h3 {
            font-size: 22px; font-weight: 800; color: var(--green-900);
            margin-bottom: 10px;
        }
        .tl-content p {
            font-size: 15px; color: var(--gray-500); line-height: 1.7;
            max-width: 400px;
        }
        .timeline-item:nth-child(even) .tl-content p { margin-left: auto; }
        .tl-visual {
            flex: 1; display: flex; align-items: center; justify-content: center;
        }
        .tl-visual-card {
            background: #fff; border: 1px solid var(--gray-200); border-radius: 16px;
            padding: 28px; width: 100%; max-width: 360px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .timeline-item:hover .tl-visual-card {
            border-color: var(--green-300); box-shadow: 0 8px 28px rgba(22,163,74,0.08);
        }
        .tl-visual-card .icon-row {
            display: flex; align-items: center; gap: 12px; margin-bottom: 16px;
        }
        .tl-visual-card .icon-box {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .tl-visual-card .icon-box svg { width: 22px; height: 22px; }
        .tl-visual-card .icon-label { font-size: 14px; font-weight: 700; color: var(--green-900); }
        .tl-visual-card .detail { font-size: 13px; color: var(--gray-500); line-height: 1.6; }
        .tl-visual-card .detail li { margin-bottom: 6px; list-style: none; padding-left: 20px; position: relative; }
        .tl-visual-card .detail li::before {
            content: '✓'; position: absolute; left: 0; color: var(--green-600); font-weight: 700;
        }

        /* ── CTA ── */
        .page-cta {
            background: var(--green-900); padding: 64px 32px; text-align: center;
            position: relative; overflow: hidden;
        }
        .page-cta::before {
            content: ''; position: absolute; top: -180px; right: -180px;
            width: 400px; height: 400px; border-radius: 50%;
            background: rgba(22,163,74,0.15); pointer-events: none;
        }
        .page-cta h2 { font-size: 32px; font-weight: 800; color: #fff; margin-bottom: 12px; letter-spacing: -0.5px; position: relative; z-index: 1; }
        .page-cta p { font-size: 15px; color: rgba(255,255,255,0.6); margin-bottom: 28px; position: relative; z-index: 1; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-on-scroll { opacity: 0; transform: translateY(20px); transition: all 0.6s ease; }
        .animate-on-scroll.visible { opacity: 1; transform: translateY(0); }

        @media (max-width: 768px) {
            .page-hero h1 { font-size: 32px; }
            .timeline::before { left: 28px; }
            .timeline-item, .timeline-item:nth-child(even) { flex-direction: column; gap: 20px; padding-left: 72px; }
            .timeline-dot { left: 28px; transform: translateX(-50%); }
            .timeline-item:hover .timeline-dot { transform: translateX(-50%) scale(1.1); }
            .timeline-item:nth-child(even) .tl-content { text-align: left; }
            .timeline-item:nth-child(even) .tl-content p { margin-left: 0; }
        }
    </style>

    <!-- Hero -->
    <section class="page-hero">
        <div class="section-badge">🔄 Proses Sederhana</div>
        <h1>4 Langkah Mudah Memulai Patungan</h1>
        <p>Sistem yang dirancang agar mudah dipahami oleh siapa saja, memastikan proses pengadaan pupuk berjalan efisien, rapi, dan transparan.</p>
    </section>

    <!-- Timeline -->
    <section class="section">
        <div class="timeline">
            <!-- Step 1 -->
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot">1</div>
                <div class="tl-content">
                    <h3>1. Ketua Kelompok Membuka Pesanan (PO)</h3>
                    <p>Melalui sistem, perwakilan rekan petani memilih jenis pupuk, menetapkan jumlah minimal pesanan, menentukan harga patokan, dan mengatur batas waktu pembayaran. Tautan pesanan ini kemudian dibagikan ke grup komunikasi anggota.</p>
                </div>
                <div class="tl-visual">
                    <div class="tl-visual-card">
                        <div class="icon-row">
                            <div class="icon-box" style="background: var(--green-100); color: var(--green-700);">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="icon-label">Buka Pesanan Baru</span>
                        </div>
                        <ul class="detail">
                            <li>Pilih jenis pupuk/obat-obatan</li>
                            <li>Tentukan minimal kuota borongan</li>
                            <li>Atur patokan harga & batas waktu</li>
                            <li>Umumin ke semua anggota</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot">2</div>
                <div class="tl-content">
                    <h3>2. Anggota Memasukkan Pesanan</h3>
                    <p>Anggota cukup membuka tautan tersebut dari ponsel, memasukkan jumlah karung yang dibutuhkan, lalu mentransfer dana sesuai tagihan. Bukti pembayaran akan terverifikasi dan masuk ke sistem secara otomatis.</p>
                </div>
                <div class="tl-visual">
                    <div class="tl-visual-card">
                        <div class="icon-row">
                            <div class="icon-box" style="background: #EDE9FE; color: #7C3AED;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <span class="icon-label">Titip & Bayar Lewat HP</span>
                        </div>
                        <ul class="detail">
                            <li>Pilih PO yang lagi buka</li>
                            <li>Ketik mau nitip berapa karung</li>
                            <li>Transfer uangnya</li>
                            <li>Buktinya langsung masuk ke sistem</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot">3</div>
                <div class="tl-content">
                    <h3>3. Kuota Terpenuhi, Sistem Memproses</h3>
                    <p>Ketua dan anggota dapat memantau progres kuota secara langsung (real-time). Saat target tercapai, pesanan otomatis diteruskan ke distributor untuk mendapatkan harga grosir, tanpa biaya tambahan apa pun.</p>
                </div>
                <div class="tl-visual">
                    <div class="tl-visual-card">
                        <div class="icon-row">
                            <div class="icon-box" style="background: #FEF3C7; color: #D97706;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="icon-label">Target Kuota Tembus</span>
                        </div>
                        <ul class="detail">
                            <li>Bisa pantau kuota langsung dari HP</li>
                            <li>Harga grosir otomatis didapat</li>
                            <li>Pesan ke pabrik/distributor</li>
                            <li>Uang sisa kembalian kalau ada</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot">4</div>
                <div class="tl-content">
                    <h3>4. Pengambilan Barang dengan Kupon Digital</h3>
                    <p>Setelah pupuk tiba di titik distribusi yang disepakati, anggota hanya perlu menunjukkan Kupon QR di ponsel mereka. Panitia akan memindai kupon tersebut, memastikan pembagian berjalan cepat, akurat, dan tertib.</p>
                </div>
                <div class="tl-visual">
                    <div class="tl-visual-card">
                        <div class="icon-row">
                            <div class="icon-box" style="background: #DCFCE7; color: #16A34A;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            </div>
                            <span class="icon-label">Distribusi Aman</span>
                        </div>
                        <ul class="detail">
                            <li>QR code unik per transaksi</li>
                            <li>Sekali pakai — anti manipulasi</li>
                            <li>Scan oleh Ketua di titik kumpul</li>
                            <li>Riwayat tercatat digital</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="page-cta">
        <h2>Siap Untuk Mulai Berhemat?</h2>
        <p>Daftarkan akun Anda secara gratis. Nikmati kemudahan mengelola pesanan pupuk bersama seluruh rekan petani Anda hari ini.</p>
        <div style="display: flex; gap: 14px; justify-content: center; position: relative; z-index: 1;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-green btn-lg">Buka Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-green btn-lg">Coba Buka Pesanan Sekarang</a>
                <a href="{{ route('login') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; backdrop-filter: blur(4px);">Masuk</a>
            @endauth
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

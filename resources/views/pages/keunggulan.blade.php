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

        /* ── Feature Cards ── */
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 64px; }
        .feat-card {
            background: #fff; border: 1px solid var(--gray-200); border-radius: 20px;
            padding: 36px 28px; position: relative; overflow: hidden;
            transition: all 0.3s ease;
        }
        .feat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 4px; transform: scaleX(0); transform-origin: left;
            transition: transform 0.3s ease;
        }
        .feat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.06); }
        .feat-card:hover::before { transform: scaleX(1); }
        .feat-card.green::before { background: linear-gradient(90deg, var(--green-600), var(--green-400)); }
        .feat-card.purple::before { background: linear-gradient(90deg, #7C3AED, #A78BFA); }
        .feat-card.amber::before { background: linear-gradient(90deg, #D97706, #FBBF24); }
        .feat-card.blue::before { background: linear-gradient(90deg, #2563EB, #60A5FA); }
        .feat-card.rose::before { background: linear-gradient(90deg, #E11D48, #FB7185); }
        .feat-card.teal::before { background: linear-gradient(90deg, #0D9488, #5EEAD4); }

        .feat-icon {
            width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
        }
        .feat-icon svg { width: 28px; height: 28px; }
        .feat-card h3 { font-size: 18px; font-weight: 800; color: var(--green-900); margin-bottom: 10px; }
        .feat-card p { font-size: 14px; color: var(--gray-500); line-height: 1.7; }

        /* ── Comparison Table ── */
        .compare-section { background: var(--gray-50); border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); }
        .compare-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.04); }
        .compare-table th {
            padding: 18px 24px; text-align: left; font-size: 14px; font-weight: 700;
            border-bottom: 2px solid var(--gray-200);
        }
        .compare-table th:first-child { color: var(--gray-500); }
        .compare-table th.old { background: #FEF2F2; color: #991B1B; }
        .compare-table th.new { background: #F0FDF4; color: #166534; }
        .compare-table td {
            padding: 16px 24px; font-size: 14px; color: var(--gray-700);
            border-bottom: 1px solid var(--gray-100);
        }
        .compare-table tr:last-child td { border-bottom: none; }
        .compare-table td.old { color: #991B1B; background: #FFFBFB; }
        .compare-table td.new { color: #166534; background: #FAFFF7; font-weight: 600; }

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

        @media (max-width: 1024px) {
            .feature-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .page-hero h1 { font-size: 32px; }
            .feature-grid { grid-template-columns: 1fr; }
            .compare-table { font-size: 13px; }
            .compare-table th, .compare-table td { padding: 12px 16px; }
        }
    </style>

    <!-- Hero -->
    <section class="page-hero">
        <img src="{{ asset('images/keunggulan_ill.png') }}" alt="Ilustrasi" style="position: absolute; left: 0; bottom: -20%; height: 140%; opacity: 0.3; pointer-events: none; mix-blend-mode: multiply; mask-image: radial-gradient(circle at left, black 30%, transparent 70%); -webkit-mask-image: radial-gradient(circle at left, black 30%, transparent 70%); z-index: 0;">
        <div style="position: relative; z-index: 1;">
            <div class="section-badge">⭐ Solusi Tepat untuk Petani</div>
            <h1>Dirancang Khusus untuk Membantu Petani Berhemat.</h1>
            <p>Kami memahami bahwa modal tanam adalah prioritas utama. PatunganTani memotong jalur perantara, menekan harga beli, dan membuat pengelolaan pesanan oleh rekan-rekan petani menjadi jauh lebih transparan.</p>
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="section">
        <div class="feature-grid">
            <div class="feat-card green animate-on-scroll">
                <div class="feat-icon" style="background: var(--green-100); color: var(--green-700);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3>Jelas Lebih Hemat (Hingga 15%)</h3>
                <p>Pembelian eceran cenderung lebih mahal. Dengan menggabungkan pesanan, kelompok rekan petani Anda secara otomatis akan mendapatkan harga tingkat distributor.</p>
            </div>
            <div class="feat-card purple animate-on-scroll">
                <div class="feat-icon" style="background: #EDE9FE; color: #7C3AED;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h3>Bebas Repot dengan Kupon Digital</h3>
                <p>Distribusi barang sering kali membingungkan panitia. Kini, setiap anggota yang telah membayar akan menerima kode QR. Panitia cukup memindai kode tersebut, dan pupuk dibagikan sesuai porsi tanpa perdebatan.</p>
            </div>
            <div class="feat-card amber animate-on-scroll">
                <div class="feat-icon" style="background: #FEF3C7; color: #D97706;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3>Pencatatan Otomatis & Transparan</h3>
                <p>Semua bukti transfer dan pesanan terekam rapi di dalam sistem. Koordinator petani bahkan dapat langsung mengunduh laporan keuangan dalam format Excel hanya dengan satu ketukan.</p>
            </div>
            <div class="feat-card blue animate-on-scroll">
                <div class="feat-icon" style="background: #DBEAFE; color: #2563EB;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3>Kemudahan Mengelola Anggota</h3>
                <p>Ketua dapat langsung memantau siapa anggota yang sudah melunasi pembayaran dan siapa yang belum dari layar ponsel, tanpa perlu menagih secara manual ke rumah-rumah.</p>
            </div>
            <div class="feat-card rose animate-on-scroll">
                <div class="feat-icon" style="background: #FFE4E6; color: #E11D48;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <h3>Akses Ringan Tanpa Install Aplikasi</h3>
                <p>Tidak perlu khawatir memori ponsel penuh. PatunganTani dapat diakses langsung dengan mengklik tautan di browser ponsel cerdas Anda.</p>
            </div>
            <div class="feat-card teal animate-on-scroll">
                <div class="feat-icon" style="background: #CCFBF1; color: #0D9488;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3>Keaslian Produk Terjamin</h3>
                <p>Sistem kami memotong rantai pasok yang panjang. Semua pesanan dikirim langsung dari distributor resmi, sehingga 100% aman dari risiko pupuk palsu atau oplosan.</p>
            </div>
        </div>
    </section>

    <!-- Comparison -->
    <section class="compare-section">
        <div class="section">
            <div style="text-align: center; margin-bottom: 48px;">
                <div class="section-badge">📊 Perbandingan Sistem</div>
                <h2 style="font-size: 32px; font-weight: 800; color: var(--green-900); margin-bottom: 10px;">Cara Konvensional vs PatunganTani</h2>
                <p style="font-size: 15px; color: var(--gray-500); max-width: 480px; margin: 0 auto;">Pelajari perbedaan efisiensi antara metode konvensional dengan sistem kami.</p>
            </div>

            <table class="compare-table animate-on-scroll">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th class="old-header">Cara Konvensional</th>
                        <th class="new-header">Melalui PatunganTani</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 600;">Harga Pembelian</td>
                        <td class="old">Harga eceran (Lebih Tinggi)</td>
                        <td class="new">Harga grosir agen (Lebih Hemat)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Kualitas Produk</td>
                        <td class="old">Rentan pupuk oplosan</td>
                        <td class="new">100% Asli dari distributor resmi</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Sistem Pencatatan</td>
                        <td class="old">Manual menggunakan buku</td>
                        <td class="new">Otomatis terekam di sistem digital</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Proses Pembagian</td>
                        <td class="old">Rawan antrean tidak teratur</td>
                        <td class="new">Rapi menggunakan Kupon QR</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- CTA -->
    <section class="page-cta">
        <img src="{{ asset('images/farmer_working.png') }}" alt="Background" style="position: absolute; right: -5%; bottom: -20%; height: 140%; opacity: 0.15; pointer-events: none; mix-blend-mode: luminosity; mask-image: radial-gradient(circle at right bottom, black 30%, transparent 70%); -webkit-mask-image: radial-gradient(circle at right bottom, black 30%, transparent 70%); z-index: 0;">
        <h2 style="position: relative; z-index: 1;">Waktunya Beralih ke Cara yang Lebih Cerdas!</h2>
        <p style="position: relative; z-index: 1;">Ribuan karung pupuk telah berhasil didistribusikan dengan harga terbaik. Kini giliran kelompok rekan petani Anda untuk membuktikannya.</p>
        <div style="display: flex; gap: 14px; justify-content: center; position: relative; z-index: 1;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-green btn-lg">Buka Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-green btn-lg">Buat Grup Patungan Pertama Saya</a>
                <a href="{{ route('page.pre-order') }}" class="btn" style="background: rgba(255,255,255,0.1); color: #fff; backdrop-filter: blur(4px);">Lihat Pre-Order Aktif</a>
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

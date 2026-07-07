<x-app-layout>
    <x-slot name="header">
        <h1>E-Kupon Pengambilan</h1>
        <p>Tunjukkan kupon ini kepada petugas di titik kumpul desa</p>
    </x-slot>

    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border: 1px solid #BBF7D0;">{{ session('success') }}</div>
    @endif

    <div class="cols-1-1 animate-in">
        {{-- Left: Kupon Card --}}
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div class="panel">
                <div class="panel-body" style="text-align: center; padding: 36px 32px;">
                    <span class="badge badge-green" style="margin-bottom: 16px;">✅ Siap Diambil</span>

                    <h2 style="font-size: 18px; font-weight: 700; color: #0F2B1F; margin: 0 0 24px 0;">{{ $qrRecord->code }}</h2>

                    <div style="border: 2px dashed #E8ECE9; padding: 24px; border-radius: 16px; margin-bottom: 20px; background: #F8FAF9;">
                        <div style="background: #0F2B1F; padding: 32px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <div style="background: #fff; padding: 16px; border-radius: 8px;">
                                {!! $qrImage !!}
                            </div>
                        </div>
                    </div>

                    <p style="font-size: 13px; color: #6B7280; line-height: 1.6;">
                        Harap siapkan KTP atau identitas yang sesuai<br>dengan nama akun untuk verifikasi.
                    </p>
                </div>
            </div>

            {{-- Order Details --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">📋 Rincian Pesanan</div>
                </div>
                <div class="panel-body-flush">
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td style="color: #6B7280;">Saprotan</td>
                                <td class="right" style="font-weight: 700; color: #0F2B1F;">{{ $allocation->order->campaign->title ?? 'Saprotan' }}</td>
                            </tr>
                            <tr>
                                <td style="color: #6B7280;">Kuantitas</td>
                                <td class="right" style="font-weight: 700; color: #0F2B1F; font-size: 16px;">{{ $allocation->order->quantity ?? 0 }} Karung</td>
                            </tr>
                            <tr>
                                <td style="color: #6B7280;">Harga Total</td>
                                <td class="right" style="font-weight: 700; color: #0F2B1F;">Rp {{ number_format($allocation->order->total_price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td style="color: #6B7280;">Status Pembayaran</td>
                                <td class="right"><span class="badge badge-green">✅ Lunas</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Location & Schedule --}}
        <div style="display: flex; flex-direction: column; gap: 20px;">
            {{-- Lokasi --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">📍 Titik Kumpul</div>
                </div>
                <div class="panel-body">
                    <div style="border: 1px solid #E8ECE9; border-radius: 10px; padding: 14px; margin-bottom: 14px;">
                        <div style="font-weight: 700; color: #0F2B1F; margin-bottom: 4px;">Balai Desa Sukamaju, Kec. Belitang</div>
                        <div style="font-size: 13px; color: #6B7280;">Jl. Raya Pertanian No. 12, OKU Timur, Sumatera Selatan</div>
                    </div>

                    <div style="background: #E8ECE9; border-radius: 12px; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; position: relative; overflow: hidden;">
                        <div style="position: absolute; inset: 0; background: #7B927B; opacity: 0.5;"></div>
                        <svg style="width: 32px; height: 32px; color: #fff; position: relative; z-index: 1; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>

                    <button class="topbar-btn topbar-btn-outline" style="width: 100%; justify-content: center;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        Buka di Maps
                    </button>
                </div>
            </div>

            {{-- Jadwal --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">📅 Jadwal Distribusi</div>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #DCFCE7; color: #16A34A; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0F2B1F; font-size: 14px;">Hari & Tanggal</div>
                            <div style="font-size: 13px; color: #6B7280;">Sabtu, 28 Oktober 2026</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #FEF3C7; color: #D97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0F2B1F; font-size: 14px;">Waktu Pengambilan</div>
                            <div style="font-size: 13px; color: #6B7280;">08:00 - 14:00 WIB</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #F3F4F6; color: #6B7280; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #0F2B1F; font-size: 14px;">Koordinator Lapangan</div>
                            <div style="font-size: 13px; color: #6B7280;">Bpk. Supriadi (0812-xxxx-xxxx)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

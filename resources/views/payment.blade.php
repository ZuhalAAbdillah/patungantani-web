<x-app-layout>
    <x-slot name="header">
        <h1>Pembayaran</h1>
        <p>Selesaikan pembayaran untuk pesanan Anda</p>
    </x-slot>

    <div style="max-width: 680px;">
        <div class="panel animate-in">
            <div class="panel-body" style="padding: 36px 32px;">

                <div style="position: relative;">
                    <span class="badge badge-amber" style="position: absolute; top: 0; right: 0;">Mode Sandbox</span>
                </div>

                <div style="text-align: center; margin-bottom: 28px;">
                    <div style="width: 56px; height: 56px; background: #FEF3C7; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <svg style="width: 28px; height: 28px; color: #D97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 800; color: #0F2B1F; margin: 0 0 6px 0;">Menunggu Pembayaran</h2>
                    <p style="font-size: 14px; color: #6B7280; margin: 0;">Konfirmasi pembayaran untuk mengamankan harga pesanan.</p>
                </div>

                {{-- Amount --}}
                <div style="border: 1px solid #E8ECE9; border-radius: 12px; padding: 20px 24px; margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 12px; color: #6B7280; font-weight: 600; margin-bottom: 4px;">Total Nominal</div>
                        <div style="font-size: 28px; font-weight: 800; color: #0F2B1F;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>
                    <span class="badge {{ $order->status == 'pending' ? 'badge-amber' : 'badge-green' }}" style="font-size: 13px; padding: 5px 14px;">{{ ucfirst($order->status) }}</span>
                </div>

                {{-- VA Instructions --}}
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0F2B1F; margin: 0 0 14px 0;">Virtual Account (Sandbox)</h3>
                    <div style="border: 1px solid #E8ECE9; border-radius: 12px; overflow: hidden;">
                        <div style="background: #F8FAF9; padding: 14px 20px; border-bottom: 1px solid #E8ECE9; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: #0F2B1F; font-size: 14px;">Bank Demo</span>
                            <svg style="width: 20px; height: 20px; color: #9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        </div>
                        <div style="padding: 20px;">
                            <div style="font-size: 12px; color: #6B7280; margin-bottom: 8px;">Nomor Virtual Account</div>
                            <div style="border: 1px solid #D1D5DB; border-radius: 8px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 20px; font-weight: 700; letter-spacing: 3px; color: #0F2B1F;">8899 1234 5678 9012</span>
                            </div>
                            <p style="text-align: center; font-size: 12px; color: #9CA3AF; margin: 10px 0 0 0;">Simulasi pembayaran untuk demo.</p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div style="margin-bottom: 28px;">
                    <h4 style="font-size: 14px; font-weight: 700; color: #0F2B1F; margin: 0 0 10px 0;">Ringkasan Pesanan</h4>
                    <table class="data-table" style="border: 1px solid #E8ECE9; border-radius: 8px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th>Saprotan</th>
                                <th class="center">Kuantitas</th>
                                <th class="right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight: 600;">{{ $order->campaign->title ?? 'Kampanye' }}</td>
                                <td class="center">{{ $order->quantity }} Karung</td>
                                <td class="right" style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Action --}}
                @if($order->status === 'pending')
                <form action="{{ route('order.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="topbar-btn topbar-btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 14px; border-radius: 10px;">
                        <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Simulasi Konfirmasi Pembayaran
                    </button>
                </form>
                <p style="text-align: center; font-size: 12px; color: #9CA3AF; margin: 10px 0 0 0;">Tombol ini hanya untuk demo. Akan mengubah status menjadi 'Dibayar' dan menerbitkan e-Kupon.</p>
                @else
                <div style="background: #DCFCE7; border: 1px solid #BBF7D0; padding: 16px; border-radius: 12px; text-align: center; font-weight: 700; color: #166534; margin-bottom: 12px;">
                    ✅ Pembayaran Berhasil!
                </div>
                <a href="{{ route('dashboard') }}" style="display: block; text-align: center; color: #16A34A; font-weight: 600; text-decoration: none; font-size: 14px;">← Kembali ke Dashboard</a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

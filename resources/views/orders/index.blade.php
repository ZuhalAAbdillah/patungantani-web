<x-app-layout>
    <x-slot name="header">
        <h1>Pesanan Saya</h1>
        <p>Riwayat seluruh pesanan Anda</p>
    </x-slot>

    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border: 1px solid #BBF7D0;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div style="background: #FEE2E2; color: #991B1B; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; border: 1px solid #FECACA;">{{ session('error') }}</div>
    @endif

    <div class="panel animate-in">
        <div class="panel-body-flush">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kampanye</th>
                        <th class="center">Qty</th>
                        <th class="right">Total Harga</th>
                        <th class="center">Status Bayar</th>
                        <th class="center">Kupon</th>
                        <th class="center">Tanggal</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #0F2B1F;">{{ $order->campaign->title ?? 'Kampanye' }}</div>
                            @if($order->campaign->description)
                            <div style="font-size: 12px; color: #9CA3AF; margin-top: 2px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $order->campaign->description }}</div>
                            @endif
                        </td>
                        <td class="center" style="font-weight: 600;">{{ $order->quantity }} <span style="color: #9CA3AF; font-weight: 400;">Karung</span></td>
                        <td class="right" style="font-weight: 600;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="center">
                            @php
                                $bc = match($order->status) {
                                    'paid' => 'badge-green',
                                    'pending' => 'badge-amber',
                                    'cancelled' => 'badge-red',
                                    default => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $bc }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="center">
                            @if($order->allocation && $order->allocation->qrCode)
                                @if($order->allocation->status === 'picked_up')
                                    <span class="badge badge-gray">Sudah Diambil</span>
                                @else
                                    <span class="badge badge-green">Siap Ambil</span>
                                @endif
                            @else
                                <span style="color: #D1D5DB;">—</span>
                            @endif
                        </td>
                        <td class="center" style="font-size: 13px; color: #6B7280;">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="center">
                            @if($order->status === 'pending')
                                <a href="{{ route('order.payment', $order->id) }}" class="topbar-btn topbar-btn-primary" style="padding: 5px 12px; font-size: 12px;">Bayar</a>
                            @elseif($order->allocation)
                                <a href="{{ route('kupon.show', $order->allocation->id) }}" class="topbar-btn topbar-btn-green" style="padding: 5px 12px; font-size: 12px;">Kupon</a>
                            @else
                                <span style="color: #D1D5DB;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <h4>Belum ada pesanan</h4>
                                <p>Gabung kampanye pre-order di halaman utama untuk mulai memesan saprotan.</p>
                                <a href="/" class="topbar-btn topbar-btn-primary">Lihat Kampanye</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

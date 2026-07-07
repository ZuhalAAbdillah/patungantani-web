<x-app-layout>
    <x-slot name="header">
        <h1>Scan QR Kupon</h1>
        <p>Verifikasi kupon petani untuk distribusi saprotan</p>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="background: #DCFCE7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; border: 1px solid #BBF7D0;" class="animate-in">
        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background: #FEE2E2; color: #991B1B; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; border: 1px solid #FECACA;" class="animate-in">
        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="cols-2-1 animate-in">
        {{-- Left: Input & Log --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Scanner Card --}}
            <div class="panel">
                <div class="panel-body" style="padding: 32px;">
                    <div style="text-align: center; margin-bottom: 24px;">
                        <div style="width: 56px; height: 56px; background: #DCFCE7; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <svg style="width: 28px; height: 28px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: #0F2B1F; margin: 0 0 4px 0;">Verifikasi Kupon</h3>
                        <p style="font-size: 13px; color: #6B7280;">Masukkan atau scan kode QR kupon petani</p>
                    </div>

                    <form action="{{ route('scan.verify') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Kode QR</label>
                            <input type="text" name="qr_code" required placeholder="Contoh: QR-668B3FA5D7E12" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; transition: border-color 0.15s;" onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'" onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">
                        </div>
                        <button type="submit" class="topbar-btn topbar-btn-green" style="width: 100%; justify-content: center; padding: 12px; font-size: 14px; border-radius: 10px;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Verifikasi & Distribusi
                        </button>
                    </form>
                </div>
            </div>

            {{-- Scan Log --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Log Verifikasi</div>
                    <span class="badge badge-gray">{{ collect($logs)->count() }} scan</span>
                </div>
                <div class="panel-body-flush">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Petani</th>
                                <th>Kode QR</th>
                                <th>Kampanye</th>
                                <th class="center">Qty</th>
                                <th class="center">Waktu Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $i => $log)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="avatar-sm avatar-colors-{{ ($i % 5) + 1 }}">{{ strtoupper(substr($log->allocation->order->user->name ?? '?', 0, 1)) }}</div>
                                        <span style="font-weight: 600; color: #0F2B1F;">{{ $log->allocation->order->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td><code style="background: #F3F4F6; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $log->code }}</code></td>
                                <td style="font-size: 13px; color: #6B7280;">{{ $log->allocation->order->campaign->title ?? '-' }}</td>
                                <td class="center" style="font-weight: 600;">{{ $log->allocation->order->quantity ?? 0 }}</td>
                                <td class="center" style="font-size: 12px; color: #6B7280;">{{ $log->updated_at->format('d/m H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"><div class="empty-state"><h4>Belum ada scan</h4><p>Verifikasi kupon petani untuk mulai mencatat distribusi.</p></div></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: Panduan --}}
        <div>
            <div class="panel" style="position: sticky; top: 80px;">
                <div class="panel-header">
                    <div class="panel-title">Panduan Scan</div>
                </div>
                <div class="panel-body" style="display: flex; flex-direction: column; gap: 18px;">
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #0F2B1F; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">1</div>
                        <div>
                            <div style="font-weight: 600; color: #0F2B1F; font-size: 14px; margin-bottom: 2px;">Minta Petani Tunjukkan Kupon</div>
                            <div style="font-size: 13px; color: #6B7280; line-height: 1.5;">Kupon berisi kode QR unik dan detail pesanan.</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #0F2B1F; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">2</div>
                        <div>
                            <div style="font-weight: 600; color: #0F2B1F; font-size: 14px; margin-bottom: 2px;">Masukkan Kode QR</div>
                            <div style="font-size: 13px; color: #6B7280; line-height: 1.5;">Ketik atau scan kode QR di kolom di samping.</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #0F2B1F; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0;">3</div>
                        <div>
                            <div style="font-weight: 600; color: #0F2B1F; font-size: 14px; margin-bottom: 2px;">Serahkan Saprotan</div>
                            <div style="font-size: 13px; color: #6B7280; line-height: 1.5;">Setelah terverifikasi, serahkan sesuai kuantitas di kupon. Kupon otomatis bertanda "Diambil".</div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #E8ECE9; padding-top: 16px; margin-top: 8px;">
                        <div style="display: flex; align-items: flex-start; gap: 10px; background: #FEF3C7; padding: 12px; border-radius: 8px;">
                            <svg style="width: 18px; height: 18px; color: #D97706; flex-shrink: 0; margin-top: 1px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <div style="font-size: 12px; color: #92400E; line-height: 1.5;">
                                <strong>Penting:</strong> Kupon hanya bisa di-scan sekali. Pastikan saprotan sudah siap sebelum verifikasi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

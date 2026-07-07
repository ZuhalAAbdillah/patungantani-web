<x-app-layout>
    <x-slot name="header">
        <h1>Buat Kampanye Baru</h1>
        <p>Kumpulkan pesanan anggota untuk mencapai kuota harga grosir</p>
    </x-slot>

    <div style="max-width: 680px;">
        @if($errors->any())
        <div style="background: #FEE2E2; color: #991B1B; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; border: 1px solid #FECACA;">
            <strong>Oops!</strong>
            <ul style="margin: 6px 0 0 16px; padding: 0;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="panel animate-in">
            <div class="panel-body" style="padding: 32px;">
                <form action="{{ route('campaign.store') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label for="title" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Nama Kampanye / Komoditas *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            placeholder="Contoh: Pupuk NPK Phonska Non-Sub - MT Gadu 2026"
                            style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; transition: border-color 0.15s;"
                            onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'"
                            onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label for="target_amount" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Target Kuota (Karung/Unit) *</label>
                            <input type="number" id="target_amount" name="target_amount" value="{{ old('target_amount') }}" required min="1"
                                placeholder="200"
                                style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; transition: border-color 0.15s;"
                                onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'"
                                onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label for="price_per_unit" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Harga Modal/Pabrik (Rp/unit) *</label>
                            <input type="number" id="price_per_unit" name="price_per_unit" value="{{ old('price_per_unit') }}" required min="0"
                                placeholder="285000"
                                style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; transition: border-color 0.15s;"
                                onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'"
                                onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">
                            <span style="display:block; font-size:11px; color:#16A34A; margin-top:4px;">*Biaya platform 5% akan otomatis ditambahkan saat petani checkout</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="closes_at" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Batas Waktu (Deadline) *</label>
                        <input type="date" id="closes_at" name="closes_at" value="{{ old('closes_at') }}" required
                            style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; transition: border-color 0.15s;"
                            onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'"
                            onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">
                    </div>

                    <div style="margin-bottom: 28px;">
                        <label for="description" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px;">Keterangan (Opsional)</label>
                        <textarea id="description" name="description" rows="3"
                            placeholder="Info distributor, syarat tambahan, dll..."
                            style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; box-sizing: border-box; resize: vertical; transition: border-color 0.15s;"
                            onfocus="this.style.borderColor='#16A34A';this.style.boxShadow='0 0 0 3px rgba(22,163,74,0.1)'"
                            onblur="this.style.borderColor='#D1D5DB';this.style.boxShadow='none'">{{ old('description') }}</textarea>
                    </div>

                    <div style="border-top: 1px solid #E8ECE9; padding-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ route('dashboard') }}" style="color: #6B7280; font-size: 14px; text-decoration: none; font-weight: 500;">← Kembali</a>
                        <button type="submit" class="topbar-btn topbar-btn-primary" style="padding: 12px 28px; font-size: 14px;">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Kampanye Pre-Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

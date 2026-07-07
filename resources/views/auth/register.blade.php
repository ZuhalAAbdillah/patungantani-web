<x-guest-layout>
    <div class="auth-form-header fade-in">
        <img src="{{ asset('images/logo.png') }}" alt="PatunganTani" class="mobile-logo">
        <h2>Buat Akun Baru</h2>
        <p>Bergabung dengan Gapoktan dan mulai hemat beli saprotan.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="auth-field fade-in fade-in-1">
            <label for="name">Nama Lengkap</label>
            <div class="input-icon-wrap">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            @error('name')
            <div class="field-error">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Email -->
        <div class="auth-field fade-in fade-in-1">
            <label for="email">Email</label>
            <div class="input-icon-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            @error('email')
            <div class="field-error">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Phone -->
        <div class="auth-field fade-in fade-in-2">
            <label for="phone">No. Telepon <span style="color: #9CA3AF; font-weight: 400;">(Opsional)</span></label>
            <div class="input-icon-wrap">
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="08xxxxxxxxxx">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </div>
            @error('phone')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role -->
        <div class="auth-field fade-in fade-in-2">
            <label for="role">Daftar Sebagai</label>
            <div class="input-icon-wrap">
                <select id="role" name="role" required style="padding-left: 44px; appearance: none; -webkit-appearance: none;">
                    <option value="petani" {{ old('role') == 'petani' ? 'selected' : '' }}>🌾 Petani (Anggota Gapoktan)</option>
                    <option value="ketua" {{ old('role') == 'ketua' ? 'selected' : '' }}>👤 Ketua Gapoktan</option>
                </select>
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div class="field-hint">Petani: ikut pre-order & ambil saprotan. Ketua: kelola kampanye & distribusi.</div>
            @error('role')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="auth-field fade-in fade-in-3">
            <label for="password">Password</label>
            <div class="input-icon-wrap">
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <button type="button" class="password-toggle" tabindex="-1">
                    <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg class="eye-closed" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
            @error('password')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="auth-field fade-in fade-in-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div class="input-icon-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            @error('password_confirmation')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-submit fade-in fade-in-4" style="margin-top: 8px;">
            <span class="btn-text">Daftar Sekarang</span>
            <div class="btn-spinner"></div>
        </button>
    </form>

    <div class="auth-divider fade-in fade-in-5"><span>atau</span></div>

    <div class="auth-footer fade-in fade-in-5">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</x-guest-layout>

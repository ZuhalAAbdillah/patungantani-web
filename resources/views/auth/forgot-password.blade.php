<x-guest-layout>
    <div class="auth-form-header fade-in">
        <img src="{{ asset('images/logo.png') }}" alt="PatunganTani" class="mobile-logo">
        <h2>Lupa Password?</h2>
        <p>Tidak masalah. Masukkan email Anda dan kami akan kirimkan link untuk reset password.</p>
    </div>

    @if(session('status'))
    <div class="auth-alert auth-alert-success fade-in">
        <svg style="width:16px;height:16px;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="auth-field fade-in fade-in-1">
            <label for="email">Email</label>
            <div class="input-icon-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            @error('email')
            <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="auth-submit fade-in fade-in-2">
            <span class="btn-text">Kirim Link Reset</span>
            <div class="btn-spinner"></div>
        </button>
    </form>

    <div class="auth-footer fade-in fade-in-3" style="margin-top: 24px;">
        Ingat password Anda? <a href="{{ route('login') }}">Kembali ke Login</a>
    </div>
</x-guest-layout>

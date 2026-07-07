<x-guest-layout>
    <div class="auth-form-header fade-in">
        <img src="{{ asset('images/logo.png') }}" alt="PatunganTani" class="mobile-logo">
        <h2>Masuk ke Akun Anda</h2>
        <p>Kelola pesanan saprotan dan pantau kampanye Gapoktan Anda.</p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
    <div class="auth-alert auth-alert-success fade-in">
        <svg style="width:16px;height:16px;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="auth-field fade-in fade-in-1">
            <label for="email">Email</label>
            <div class="input-icon-wrap">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            @error('email')
            <div class="field-error">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="auth-field fade-in fade-in-2">
            <label for="password">Password</label>
            <div class="input-icon-wrap">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <button type="button" class="password-toggle" tabindex="-1">
                    <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg class="eye-closed" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                </button>
            </div>
            @error('password')
            <div class="field-error">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Remember + Forgot -->
        <div class="auth-checkbox-row fade-in fade-in-3">
            <label class="auth-checkbox">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot">Lupa password?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-submit fade-in fade-in-4">
            <span class="btn-text">Masuk</span>
            <div class="btn-spinner"></div>
        </button>
    </form>

    <div class="auth-divider fade-in fade-in-5"><span>atau</span></div>

    <div class="auth-footer fade-in fade-in-5">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis</a>
    </div>
</x-guest-layout>

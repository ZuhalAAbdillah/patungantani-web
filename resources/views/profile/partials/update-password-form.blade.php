<section>
    <div class="panel-header" style="border-bottom: none; padding-bottom: 0;">
        <div>
            <h2 class="panel-title">Ubah Kata Sandi</h2>
            <p style="font-size: 13px; color: #6B7280; margin-top: 4px;">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" style="padding: 0 24px 24px;">
        @csrf
        @method('put')

        <div class="form-group" style="margin-top: 16px;">
            <label for="update_password_current_password" class="form-label">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            @error('current_password', 'updatePassword')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password" class="form-label">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            @error('password', 'updatePassword')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" class="btn btn-dark">Simpan Sandi Baru</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    style="font-size: 13px; font-weight: 500; color: #16A34A; margin: 0;"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>

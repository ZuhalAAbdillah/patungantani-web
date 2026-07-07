<section>
    <div class="panel-header" style="border-bottom: none; padding-bottom: 0;">
        <div>
            <h2 class="panel-title">Informasi Profil</h2>
            <p style="font-size: 13px; color: #6B7280; margin-top: 4px;">Perbarui informasi profil akun dan alamat email Anda.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="padding: 0 24px 24px;">
        @csrf
        @method('patch')

        <div class="form-group" style="margin-top: 16px;">
            <label for="name" class="form-label">Nama</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')<span class="text-danger">{{ $message }}</span>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 10px;">
                    <p style="font-size: 13px; color: #374151;">
                        Email Anda belum diverifikasi.
                        <button form="send-verification" style="background: none; border: none; color: #16A34A; text-decoration: underline; cursor: pointer; padding: 0; font-family: inherit;">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size: 13px; font-weight: 500; color: #16A34A; margin-top: 8px;">
                            Link verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" class="btn btn-dark">Simpan Perubahan</button>

            @if (session('status') === 'profile-updated')
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

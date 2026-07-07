<section>
    <div class="panel-header" style="border-bottom: none; padding-bottom: 0;">
        <div>
            <h2 class="panel-title" style="color: #991B1B;">Hapus Akun</h2>
            <p style="font-size: 13px; color: #6B7280; margin-top: 4px;">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
        </div>
    </div>

    <div style="padding: 16px 24px 24px;">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="btn" style="background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; box-shadow: none;"
            onmouseover="this.style.background='#FEE2E2'"
            onmouseout="this.style.background='#FEF2F2'"
        >Hapus Akun</button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 24px;">
            @csrf
            @method('delete')

            <h2 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 8px;">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p style="font-size: 14px; color: #6B7280; margin-bottom: 20px;">
                Setelah akun Anda dihapus, semua data akan hilang secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini.
            </p>

            <div class="form-group">
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="Kata Sandi Anda"
                />
                @error('password', 'userDeletion')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn btn-outline" x-on:click="$dispatch('close')">
                    Batal
                </button>

                <button type="submit" class="btn" style="background: #EF4444; color: #fff;">
                    Hapus Akun Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>

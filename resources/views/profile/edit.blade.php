<x-app-layout>
    <x-slot name="header">
        <h1>Pengaturan Profil</h1>
        <p>Kelola informasi akun dan pengaturan keamanan Anda.</p>
    </x-slot>

    <div style="max-width: 800px; display: flex; flex-direction: column; gap: 24px;">
        <div class="panel animate-in">
            <div class="panel-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="panel animate-in animate-delay-1">
            <div class="panel-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="panel animate-in animate-delay-2" style="border-color: #FECACA;">
            <div class="panel-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>

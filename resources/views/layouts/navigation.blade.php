<nav style="background: #fff; border-bottom: 1px solid #E5E7EB;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between;">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #1B3C2D;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 28px; width: auto;">
            <span style="font-weight: 700; font-size: 18px;">PatunganTani.id</span>
        </a>

        <!-- Navigation Links -->
        <div style="display: flex; align-items: center; gap: 32px;" class="nav-links">
            <a href="{{ route('home') }}" style="font-size: 14px; color: {{ request()->routeIs('home') ? '#1B3C2D' : '#6B7280' }}; text-decoration: none; font-weight: {{ request()->routeIs('home') ? '600' : '500' }}; {{ request()->routeIs('home') ? 'border-bottom: 2px solid #1B3C2D; padding-bottom: 4px;' : '' }}">Beranda</a>
            <a href="{{ route('dashboard') }}" style="font-size: 14px; color: {{ request()->routeIs('dashboard') ? '#1B3C2D' : '#6B7280' }}; text-decoration: none; font-weight: {{ request()->routeIs('dashboard') ? '600' : '500' }}; {{ request()->routeIs('dashboard') ? 'border-bottom: 2px solid #1B3C2D; padding-bottom: 4px;' : '' }}">Dashboard</a>
            <a href="{{ route('orders.index') }}" style="font-size: 14px; color: {{ request()->routeIs('orders.*') ? '#1B3C2D' : '#6B7280' }}; text-decoration: none; font-weight: {{ request()->routeIs('orders.*') ? '600' : '500' }}; {{ request()->routeIs('orders.*') ? 'border-bottom: 2px solid #1B3C2D; padding-bottom: 4px;' : '' }}">Pesanan Saya</a>
            @if(Auth::user()->isKetua() || Auth::user()->isAdmin())
            <a href="{{ route('scan') }}" style="font-size: 14px; color: {{ request()->routeIs('scan') ? '#1B3C2D' : '#6B7280' }}; text-decoration: none; font-weight: {{ request()->routeIs('scan') ? '600' : '500' }}; {{ request()->routeIs('scan') ? 'border-bottom: 2px solid #1B3C2D; padding-bottom: 4px;' : '' }}">Scan QR</a>
            @endif
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.finance') }}" style="font-size: 14px; color: {{ request()->routeIs('admin.finance') ? '#1B3C2D' : '#6B7280' }}; text-decoration: none; font-weight: {{ request()->routeIs('admin.finance') ? '600' : '500' }}; {{ request()->routeIs('admin.finance') ? 'border-bottom: 2px solid #1B3C2D; padding-bottom: 4px;' : '' }}">Keuangan</a>
            @endif
        </div>

        <!-- Right Side: User info + dropdown -->
        <div x-data="{ open: false }" style="position: relative; display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 11px; background: {{ Auth::user()->isAdmin() ? '#EF4444' : (Auth::user()->isKetua() ? '#F59E0B' : '#4CAF50') }}; color: #fff; padding: 2px 10px; border-radius: 99px; font-weight: 600; text-transform: uppercase;">{{ Auth::user()->role }}</span>
            <button @click="open = !open" style="display: flex; align-items: center; gap: 6px; background: none; border: none; cursor: pointer; font-size: 14px; color: #6B7280; font-weight: 500;">
                {{ Auth::user()->name }}
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition style="position: absolute; right: 0; top: 100%; margin-top: 8px; width: 220px; background: #fff; border: 1px solid #E5E7EB; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 50; overflow: hidden;">
                <div style="padding: 10px 16px; border-bottom: 1px solid #E5E7EB; background: #F9FAFB;">
                    <div style="font-size: 12px; color: #6B7280; margin-bottom: 4px;">Akun Saat Ini</div>
                    <div style="font-weight: 600; font-size: 14px; color: #111827;">{{ Auth::user()->name }}</div>
                </div>
                <a href="{{ route('login', ['add_account' => 1]) }}" target="_blank" style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; font-size: 13px; color: #10B981; text-decoration: none; font-weight: 500; border-bottom: 1px solid #E5E7EB;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buka Akun Tambahan
                </a>
                <a href="{{ route('profile.edit') }}" style="display: block; padding: 10px 16px; font-size: 14px; color: #374151; text-decoration: none;">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="display: block; width: 100%; padding: 10px 16px; font-size: 14px; color: #DC2626; text-decoration: none; background: none; border: none; text-align: left; cursor: pointer; border-top: 1px solid #E5E7EB;">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile menu toggle (hidden on desktop) -->
    <style>
        @media (max-width: 768px) {
            .nav-links { display: none !important; }
        }
    </style>
</nav>

<nav class="navbar">
    <h1>@yield('page-title', 'Dashboard')</h1>

    <div class="navbar-right">
        <div class="search-box">
            <i class="icon-search"></i>
            <input type="text" placeholder="Cari">
        </div>

        <div class="user-info">
            <span class="user-badge">{{ ucfirst(auth()->user()->role) }}</span>

            <button class="icon-btn" title="Pengaturan">
                <i class="icon-settings"></i>
            </button>

            <button class="icon-btn" title="Notifikasi">
                <i class="icon-bell"></i>
            </button>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="icon-btn" title="Logout" style="background-color: #ff4444; color: white;">
                    🚪
                </button>
            </form>
        </div>
    </div>
</nav>

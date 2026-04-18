<style>
/* ===== NAVBAR ===== */
#customer-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.navbar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 76px;
}

/* ===== LEFT (LOGO + MENU) ===== */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 18px; /* jarak logo ke menu */
}

/* ===== LOGO ===== */
.navbar-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo-icon {
    height: 70px;
    width: auto;
}

.logo-icon img {
    height: 100%;
    width: auto;
    object-fit: contain;
}

/* ===== NAV MENU ===== */
.navbar-nav {
    display: flex;
    gap: 8px;
    list-style: none;
}

.nav-item a {
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 14px;
    color: #555;
    text-decoration: none;
    transition: 0.2s;
}

.nav-item a.active {
    background: #5C2D0E;
    color: white;
}

.nav-item a:hover {
    background: #f5f5f5;
}

/* ===== SEARCH ===== */
.navbar-search {
    flex: 1;
    max-width: 380px;
    margin-left: auto;
    margin-right: 10px;
}

.search-input-wrap {
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #ddd;
    border-radius: 14px;
    padding: 0 14px;
    height: 42px;
    gap: 8px;
}

.search-input-wrap input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
}

.search-input-wrap i {
    color: #999;
}

/* ===== ACTION ICON ===== */
.navbar-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #444;
    position: relative;
    transition: 0.2s;
}

.action-btn:hover {
    background: #5C2D0E;
    color: white;
}

.action-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    background: #5C2D0E;
    color: white;
    font-size: 10px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .navbar-nav,
    .navbar-search {
        display: none;
    }
}
</style>

<nav id="customer-navbar">
    <div class="container">
        <div class="navbar-inner">

            <!-- LEFT: LOGO + MENU -->
            <div class="navbar-left">
                <a href="{{ route('customer.home') }}" class="navbar-logo">
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    </div>
                </a>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('customer.home') }}"
                           class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer.menu') }}"
                           class="{{ request()->routeIs('customer.menu') ? 'active' : '' }}">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer.about') }}"
                           class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">
                            About
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SEARCH -->
            <div class="navbar-search">
                <div class="search-input-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <!-- ICON -->
            <div class="navbar-actions">
                <a href="#" class="action-btn">
                    <i class="fas fa-bell"></i>
                    <span class="action-badge">0</span>
                </a>

                <a href="{{ route('keranjang.index') }}" class="action-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="action-badge">0</span>
                </a>

                @auth
                <div style="position:relative;">
                    <a href="#" class="action-btn" onclick="toggleDropdownProfil(event)">
                        <i class="fas fa-user"></i>
                    </a>
                    <div id="dropdown-profil" style="display:none; position:absolute; right:0; top:48px; background:#fff; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.12); padding:8px 0; min-width:160px; z-index:999;">
                        <div style="padding:12px 16px; font-weight:600; border-bottom:1px solid #f0e8df;">
                            {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('customer.profil') }}" style="display:block; padding:10px 16px; color:#3B1A08; font-size:14px;">Profil Saya</a>
                        <a href="{{ route('keranjang.index') }}" style="display:block; padding:10px 16px; color:#3B1A08; font-size:14px;">Keranjang</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width:100%; text-align:left; padding:10px 16px; background:none; border:none; color:#e74c3c; font-size:14px; cursor:pointer; font-family:inherit;">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="action-btn">
                    <i class="fas fa-user"></i>
                </a>
            @endauth
            </div>

        </div>
    </div>
</nav>

<script>
    // Search clear button
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');
    if (searchInput && searchClear) {
        searchInput.addEventListener('input', () => {
            searchClear.classList.toggle('show', searchInput.value.length > 0);
        });
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            searchClear.classList.remove('show');
            searchInput.focus();
        });
    }

    function toggleDropdownProfil(e) {
    e.preventDefault();
    const d = document.getElementById('dropdown-profil');
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    const d = document.getElementById('dropdown-profil');
    if (d && !e.target.closest('.action-btn')) {
        d.style.display = 'none';
    }
});
</script>
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
    color-scheme: light;
}

.navbar-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 76px;
}

/* LEFT */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 18px;
}

/* LOGO */
.navbar-logo {
    display: flex;
    align-items: center;
}

.logo-icon {
    height: 70px;
}
.logo-icon img {
    height: 100%;
    object-fit: contain;
}

/* MENU */
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
}
.nav-item a.active {
    background: #5C2D0E;
    color: white;
}

/* SEARCH */
.navbar-search {
    flex: 1;
    max-width: 380px;
    margin-left: auto;
    margin-right: 10px;
}
.search-input-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid #ddd;
    border-radius: 14px;
    padding: 0 14px;
    height: 42px;
}
.search-input-wrap input {
    border: none;
    outline: none;
    width: 100%;
}

/* ACTION */
.navbar-actions {
    display: flex;
    gap: 10px;
}
.action-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
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
</style>

<nav id="customer-navbar">
    <div class="container">
        <div class="navbar-inner">

            <!-- LEFT -->
            <div class="navbar-left">
                <a href="{{ route('customer.home') }}" class="navbar-logo">
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo.png') }}">
                    </div>
                </a>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('customer.home') }}" class="{{ request()->routeIs('customer.home') ? 'active' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer.menu') }}" class="{{ request()->routeIs('customer.menu') ? 'active' : '' }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">About</a>
                    </li>
                </ul>
            </div>

            <!-- SEARCH -->
            <div class="navbar-search">
                <div class="search-input-wrap">
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <!-- ACTION -->
            <div class="navbar-actions">

                <!-- CART -->
                <a href="{{ route('keranjang.index') }}" class="action-btn" style="position:relative;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="action-badge">
                        {{ Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') : 0 }}
                    </span>
                </a>

                <!-- USER -->
                @auth
                <div style="position:relative;">
                    <a href="#" class="action-btn" onclick="toggleDropdownProfil(event)">
                        <i class="fas fa-user"></i>
                    </a>

                    <div id="dropdown-profil" style="display:none; position:absolute; right:0; top:48px; background:#fff; border-radius:8px; box-shadow:0 4px 16px rgba(0,0,0,0.12); padding:8px 0; min-width:160px;">
                        <div style="padding:12px 16px; font-weight:600;">
                            {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('customer.profil') }}" style="display:block; padding:10px 16px;">Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width:100%; padding:10px 16px; background:none; border:none; color:red;">
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
function toggleDropdownProfil(e){
    e.preventDefault();
    const d = document.getElementById('dropdown-profil');
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
</script>

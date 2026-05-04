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
    border-color: #5C2D0E;
    box-shadow: 0 4px 14px rgba(92,45,14,0.25);
}

.action-btn:hover .action-badge {
    border-color: #fff;
    box-shadow: 0 0 0 1.5px #5C2D0E;
}

.action-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    background: #e74c3c;
    color: white;
    font-size: 10px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    z-index: 1;
    pointer-events: none;
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
                <form action="{{ route('customer.menu') }}" method="GET">
                    <div class="search-input-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>

            <!-- ICON -->
            <div class="navbar-actions">
                @auth
                <div style="position:relative;">
                    <button type="button" class="action-btn" onclick="toggleNotifPopup(event)" id="btn-notif">
                        <i class="fas fa-bell"></i>
                        <span class="action-badge" id="notif-badge" style="display:none;">0</span>
                    </button>

                    {{-- NOTIF POPUP --}}
                    <div id="notif-popup" style="display:none; position:absolute; right:0; top:52px; width:340px; background:#fff; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,0.15); z-index:9999; overflow:hidden; border:1px solid #ede0d0;">
                        {{-- Popup Header --}}
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; border-bottom:1px solid #f0e8df; background:#faf5ee;">
                            <span style="font-weight:700; font-size:14px; color:#1A0A00;">Notifikasi</span>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <button onclick="markAllReadPopup()" style="background:none; border:none; font-size:12px; color:#8B6050; cursor:pointer; font-family:inherit;" title="Tandai semua dibaca">
                                    <i class="fas fa-check-double"></i> Baca Semua
                                </button>
                                <a href="{{ route('customer.notifikasi') }}" style="font-size:12px; color:#5C2D0E; font-weight:600; text-decoration:none;">Lihat Semua</a>
                            </div>
                        </div>
                        {{-- Popup List --}}
                        <div id="notif-popup-list" style="max-height:360px; overflow-y:auto;">
                            <div style="padding:32px; text-align:center; color:#8B6050;">
                                <i class="fas fa-bell-slash" style="font-size:28px; color:#d4bfa0; display:block; margin-bottom:10px;"></i>
                                <span style="font-size:13px;">Belum ada notifikasi</span>
                            </div>
                        </div>
                        {{-- Popup Footer --}}
                        <div style="padding:12px 18px; border-top:1px solid #f0e8df; text-align:center;">
                            <a href="{{ route('customer.profil.notifikasi') }}" style="font-size:12px; color:#8B6050; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:6px;">
                                <i class="fas fa-cog"></i> Pengaturan Notifikasi
                            </a>
                        </div>
                    </div>
                </div>
                @endauth

                @guest
                <a href="#" class="action-btn">
                    <i class="fas fa-bell"></i>
                </a>
                @endguest

                <a href="{{ route('keranjang.index') }}" class="action-btn">
                    <i class="fas fa-shopping-cart"></i>
                    @auth
                    @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); @endphp
                    @if($cartCount > 0)
                    <span class="action-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    @endif
                    @endauth
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
                        <button type="button" onclick="document.getElementById('dropdown-profil').style.display='none'; openModal(document.getElementById('modal-logout') ? 'modal-logout' : 'modal-logout-navbar');" style="width:100%; text-align:left; padding:10px 16px; background:none; border:none; color:#e74c3c; font-size:14px; cursor:pointer; font-family:inherit;">
                            Logout
                        </button>
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
    // ===== SEARCH CLEAR =====
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

    // ===== PROFIL DROPDOWN =====
    function toggleDropdownProfil(e) {
        e.preventDefault();
        e.stopPropagation();
        const d = document.getElementById('dropdown-profil');
        const notif = document.getElementById('notif-popup');
        if (notif) notif.style.display = 'none';
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }

    // ===== NOTIFIKASI POPUP =====
    let notifLoaded = false;

    function toggleNotifPopup(e) {
        e.preventDefault();
        e.stopPropagation();
        const popup = document.getElementById('notif-popup');
        const profil = document.getElementById('dropdown-profil');
        if (profil) profil.style.display = 'none';

        const isOpen = popup.style.display !== 'none';
        popup.style.display = isOpen ? 'none' : 'block';

        if (!isOpen) {
            loadNotifPopup();
        }
    }

    function loadNotifPopup() {
        const list = document.getElementById('notif-popup-list');
        list.innerHTML = '<div style="padding:24px; text-align:center; color:#8B6050;"><i class="fas fa-spinner fa-spin"></i></div>';

        fetch('{{ route("customer.notifikasi.popup") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            // Update badge
            const badge = document.getElementById('notif-badge');
            if (data.unread > 0) {
                badge.textContent = data.unread > 99 ? '99+' : data.unread;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }

            // Render list
            if (!data.notifications || data.notifications.length === 0) {
                list.innerHTML = `
                    <div style="padding:32px; text-align:center; color:#8B6050;">
                        <i class="fas fa-bell-slash" style="font-size:28px; color:#d4bfa0; display:block; margin-bottom:10px;"></i>
                        <span style="font-size:13px;">Belum ada notifikasi</span>
                    </div>`;
                return;
            }

            list.innerHTML = data.notifications.map(n => `
                <div onclick="markReadPopup(${n.id}, this)" style="padding:14px 18px; border-bottom:1px solid #f5ece0; cursor:pointer; background:${n.is_read ? '#fff' : '#fdf7f0'}; transition:background 0.2s;"
                     onmouseover="this.style.background='#f5ece0'" onmouseout="this.style.background='${n.is_read ? '#fff' : '#fdf7f0'}'">
                    <div style="display:flex; align-items:flex-start; gap:10px;">
                        <div style="width:8px; height:8px; border-radius:50%; background:${n.is_read ? 'transparent' : '#5C2D0E'}; margin-top:5px; flex-shrink:0;"></div>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:${n.is_read ? '400' : '600'}; color:#1A0A00; margin-bottom:3px;">${escapeHtml(n.title || 'Notifikasi')}</div>
                            <div style="font-size:12px; color:#6b7280; margin-bottom:4px;">${escapeHtml(n.body || '')}</div>
                            <div style="font-size:11px; color:#a0855b;">${timeAgo(n.created_at)}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(() => {
            list.innerHTML = '<div style="padding:24px; text-align:center; color:#e74c3c; font-size:13px;"><i class="fas fa-exclamation-circle"></i> Gagal memuat notifikasi</div>';
        });
    }

    function markReadPopup(id, el) {
        fetch('{{ url('/notifikasi') }}/' + id + '/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            el.style.background = '#fff';
            const dot = el.querySelector('div[style*="border-radius:50%"]');
            if (dot) dot.style.background = 'transparent';
            const title = el.querySelector('div[style*="font-weight"]');
            if (title) title.style.fontWeight = '400';
            // Refresh badge
            refreshNotifBadge();
        });
    }

    function markAllReadPopup() {
        fetch('{{ route("customer.notifikasi.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(() => {
            loadNotifPopup();
        });
    }

    function refreshNotifBadge() {
        fetch('{{ route("customer.notifikasi.popup") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('notif-badge');
            if (data.unread > 0) {
                badge.textContent = data.unread > 99 ? '99+' : data.unread;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });
    }
    
    // ===== UPDATE CART BADGE DI NAVBAR =====
function updateCartBadge(count) {
    // Cari tombol keranjang di navbar (yang memiliki icon fa-shopping-cart)
    let cartBtn = document.querySelector('.action-btn i.fa-shopping-cart')?.closest('.action-btn');
    let badge = cartBtn?.querySelector('.action-badge');
    
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    } else {
        // Fallback: cari semua .action-badge yang berada di dalam .action-btn yang mengandung icon cart
        let allBtns = document.querySelectorAll('.action-btn');
        for (let btn of allBtns) {
            if (btn.innerHTML.includes('fa-shopping-cart')) {
                let b = btn.querySelector('.action-badge');
                if (b) {
                    if (count > 0) {
                        b.textContent = count > 99 ? '99+' : count;
                        b.style.display = 'flex';
                    } else {
                        b.style.display = 'none';
                    }
                }
                break;
            }
        }
    }
}

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function timeAgo(dateStr) {
        const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff/60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff/3600) + ' jam lalu';
        return Math.floor(diff/86400) + ' hari lalu';
    }

    // ===== CLOSE ON OUTSIDE CLICK =====
    document.addEventListener('click', function(e) {
        const profil = document.getElementById('dropdown-profil');
        const notif = document.getElementById('notif-popup');
        const btnNotif = document.getElementById('btn-notif');

        // Jangan tutup dropdown kalau klik tombol di dalamnya
        if (profil && !e.target.closest('#dropdown-profil') && !e.target.closest('[onclick="toggleDropdownProfil(event)"]')) {
            profil.style.display = 'none';
        }
        if (notif && e.target !== btnNotif && !btnNotif?.contains(e.target) && !notif.contains(e.target)) {
            notif.style.display = 'none';
        }
    });

    // ===== LOAD BADGE ON PAGE LOAD =====
    document.addEventListener('DOMContentLoaded', function() {
        const badge = document.getElementById('notif-badge');
        if (badge) {
            refreshNotifBadge();
            // Auto-refresh badge setiap 30 detik
            setInterval(refreshNotifBadge, 30000);
        }
    });

    // ===== MODAL HELPERS =====
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
    }
</script>

{{-- MODAL LOGOUT --}}
<div id="modal-logout-navbar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:20px; padding:36px 32px; max-width:380px; width:90%; text-align:center; box-shadow:0 8px 40px rgba(0,0,0,0.15);">
        <div style="width:64px; height:64px; background:#fff5f5; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
            <i class="fas fa-sign-out-alt" style="font-size:26px; color:#e74c3c;"></i>
        </div>
        <div style="font-size:18px; font-weight:700; color:#1A0A00; margin-bottom:8px;">Keluar dari Akun?</div>
        <div style="font-size:14px; color:#6b7280; margin-bottom:28px;">Kamu yakin ingin keluar dari akun Kuesaena?</div>
        <div style="display:flex; gap:12px;">
            <button onclick="closeModal('modal-logout-navbar')" style="flex:1; padding:12px; border-radius:12px; border:1.5px solid #ddd; background:#fff; color:#444; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit;">Batal</button>
            <form action="{{ route('logout') }}" method="POST" style="flex:1;" data-no-loader>
                @csrf
                <button type="submit" style="width:100%; padding:12px; border-radius:12px; border:none; background:#e74c3c; color:#fff; font-size:14px; font-weight:600; cursor:pointer; font-family:inherit;">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>
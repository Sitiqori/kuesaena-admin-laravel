<nav class="navbar">
    <h1>@yield('page-title', 'Dashboard')</h1>

    <div class="navbar-right">
        <div class="search-box">
            <i class="icon-search"></i>
            <input type="text" placeholder="Cari">
        </div>

        <div class="user-info">
            <span class="user-badge">{{ ucfirst(auth()->user()->role) }}</span>

            <!-- Pengaturan Dropdown -->
            <div style="position: relative; display: inline-block;">
                <button class="icon-btn" title="Pengaturan" onclick="toggleDropdown('settingsDropdown')">
                    <i class="icon-settings"></i>
                </button>
                <div id="settingsDropdown" style="display: none; position: absolute; right: 0; top: 45px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 200px; z-index: 1000; overflow: hidden;">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #eee; background: #f9f9f9;">
                        <strong>{{ auth()->user()->name }}</strong><br>
                        <span style="font-size: 12px; color: #666;">{{ auth()->user()->email }}</span>
                    </div>
                    <a href="#" onclick="alert('Fitur pengaturan profil sedang dalam tahap pengembangan.'); return false;" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px; border-bottom: 1px solid #eee;">Profil Saya</a>
                    <a href="#" onclick="alert('Fitur ubah password sedang dalam tahap pengembangan.'); return false;" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px;">Ubah Password</a>
                </div>
            </div>

            <!-- Notifikasi Dropdown -->
            <div style="position: relative; display: inline-block;">
                <button class="icon-btn" title="Notifikasi" onclick="toggleDropdown('notifDropdown')">
                    <i class="icon-bell"></i>
                </button>
                <div id="notifDropdown" style="display: none; position: absolute; right: 0; top: 45px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 280px; z-index: 1000; overflow: hidden;">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #eee; background: #f9f9f9; font-weight: bold;">
                        Notifikasi
                    </div>
                    <div style="padding: 24px 16px; text-align: center; color: #888; font-size: 13px;">
                        <div style="font-size: 24px; margin-bottom: 8px; color: #ddd;">🔕</div>
                        Belum ada notifikasi baru
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="icon-btn" title="Logout" style="background-color: #ff4444; color: white;">
                    🚪
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown(id) {
        // Tutup semua dropdown lain dulu
        if (id !== 'settingsDropdown') document.getElementById('settingsDropdown').style.display = 'none';
        if (id !== 'notifDropdown') document.getElementById('notifDropdown').style.display = 'none';
        
        // Toggle yang diklik
        var dropdown = document.getElementById(id);
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    // Tutup dropdown kalau klik di luar
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.icon-btn') && !e.target.closest('#settingsDropdown') && !e.target.closest('#notifDropdown')) {
            document.getElementById('settingsDropdown').style.display = 'none';
            document.getElementById('notifDropdown').style.display = 'none';
        }
    });
</script>
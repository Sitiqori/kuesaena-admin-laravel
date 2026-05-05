<nav class="navbar">
    <h1>@yield('page-title', 'Dashboard')</h1>

    <div class="navbar-right">
        <div class="search-box">
            <i class="fas fa-search" style="color:#888; font-size:14px;"></i>
            <input type="text" placeholder="Cari">
        </div>

        <div class="user-info">
            <span class="user-badge">{{ ucfirst(auth()->user()->role) }}</span>

            {{-- Notifikasi Bell --}}
            <div style="position:relative; display:inline-block;">
                <button class="icon-btn" title="Notifikasi" onclick="toggleAdminNotif(event)" id="btn-admin-notif" style="position:relative;">
                    <i class="fas fa-bell" style="font-size:15px;"></i>
                    <span id="admin-notif-badge" style="display:none; position:absolute; top:-4px; right:-4px; background:#e74c3c; color:#fff; border-radius:50%; width:18px; height:18px; font-size:10px; font-weight:700; align-items:center; justify-content:center; border:2px solid #fff;"></span>
                </button>
                <div id="admin-notif-dropdown" style="display:none; position:absolute; right:0; top:48px; width:320px; background:#fff; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,0.15); z-index:9999; overflow:hidden; border:1px solid #eee;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 16px; background:#f9f9f9; border-bottom:1px solid #eee;">
                        <span style="font-weight:700; font-size:14px; color:#333;">Notifikasi</span>
                        <button onclick="markAllAdminRead()" style="background:none; border:none; font-size:12px; color:#888; cursor:pointer; font-family:inherit;"><i class="fas fa-check-double" style="margin-right:4px;"></i>Baca Semua</button>
                    </div>
                    <div id="admin-notif-list" style="max-height:340px; overflow-y:auto;">
                        <div style="padding:32px 16px; text-align:center; color:#888;">
                            <i class="fas fa-bell-slash" style="font-size:28px; color:#ddd; display:block; margin-bottom:10px;"></i>
                            <span style="font-size:13px;">Belum ada notifikasi</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengaturan --}}
            <div style="position:relative; display:inline-block;">
                <button class="icon-btn" title="Pengaturan" onclick="toggleDropdown('settingsDropdown')">
                    <i class="fas fa-cog" style="font-size:15px;"></i>
                </button>
                <div id="settingsDropdown" style="display:none; position:absolute; right:0; top:45px; background:white; border:1px solid #ddd; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1); width:200px; z-index:1000; overflow:hidden;">
                    <div style="padding:12px 16px; border-bottom:1px solid #eee; background:#f9f9f9;">
                        <strong>{{ auth()->user()->name }}</strong><br>
                        <span style="font-size:12px; color:#666;">{{ auth()->user()->email }}</span>
                    </div>
                    <a href="#" style="display:block; padding:12px 16px; color:#333; text-decoration:none; font-size:14px; border-bottom:1px solid #eee;">Profil Saya</a>
                    <a href="#" style="display:block; padding:12px 16px; color:#333; text-decoration:none; font-size:14px;">Ubah Password</a>
                </div>
            </div>

            {{-- Logout --}}
            <button class="icon-btn" onclick="document.getElementById('modal-admin-logout').style.display='flex'" title="Logout" style="background-color:#ff4444; color:white;">
                <i class="fas fa-sign-out-alt" style="font-size:14px;"></i>
            </button>
        </div>
    </div>
</nav>

{{-- Modal Logout Admin --}}
<div id="modal-admin-logout" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:99999; align-items:center; justify-content:center;"
     onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#fff; border-radius:16px; padding:32px 28px; width:360px; max-width:92vw; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:60px; height:60px; background:#fff0f0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fas fa-sign-out-alt" style="font-size:24px; color:#e74c3c;"></i>
        </div>
        <h3 style="font-size:17px; font-weight:700; color:#333; margin-bottom:8px;">Yakin ingin logout?</h3>
        <p style="font-size:13px; color:#888; margin-bottom:24px;">Kamu akan keluar dari panel admin.</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button onclick="document.getElementById('modal-admin-logout').style.display='none'"
                style="min-width:110px; padding:10px 20px; border-radius:20px; border:1.5px solid #ddd; background:#fff; font-size:13px; cursor:pointer; font-family:inherit;">Batal</button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="min-width:110px; padding:10px 20px; border-radius:20px; background:#e74c3c; color:#fff; border:none; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit;">Ya, Logout</button>
            </form>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div id="admin-toast-container" style="position:fixed; top:20px; right:20px; z-index:999999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

<style>
@keyframes slideInRight { from { transform:translateX(110%); opacity:0; } to { transform:translateX(0); opacity:1; } }
</style>

<script>
// ===== ADMIN TOAST =====
function showAdminToast(title, message, type) {
    type = type || 'success';
    var colors  = { success:'#27ae60', error:'#e74c3c', info:'#2980b9', warning:'#e67e22' };
    var icons   = { success:'fa-check-circle', error:'fa-times-circle', info:'fa-info-circle', warning:'fa-bell' };
    var color   = colors[type] || colors.success;
    var icon    = icons[type]  || icons.success;
    var toast   = document.createElement('div');
    toast.style.cssText = 'background:#fff; border-radius:10px; padding:14px 16px; box-shadow:0 6px 24px rgba(0,0,0,0.15); display:flex; align-items:flex-start; gap:12px; min-width:280px; max-width:340px; border-left:4px solid '+color+'; animation:slideInRight 0.3s ease; pointer-events:all;';
    toast.innerHTML = '<i class="fas '+icon+'" style="color:'+color+'; font-size:18px; flex-shrink:0; margin-top:1px;"></i>'
        + '<div style="flex:1;"><p style="font-size:14px; font-weight:700; color:#333; margin-bottom:2px;">'+title+'</p>'
        + '<p style="font-size:12px; color:#666; line-height:1.4;">'+message+'</p></div>'
        + '<button onclick="this.parentElement.remove()" style="background:none; border:none; color:#aaa; cursor:pointer; font-size:16px; padding:0; flex-shrink:0; pointer-events:all;">×</button>';
    document.getElementById('admin-toast-container').appendChild(toast);
    setTimeout(function(){ toast.style.opacity='0'; toast.style.transition='opacity 0.3s'; setTimeout(function(){ toast.remove(); }, 300); }, 4500);
}

// Flash messages as toast
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function(){ showAdminToast('Berhasil', @json(session('success')), 'success'); });
@endif
@if(session('error'))
    document.addEventListener('DOMContentLoaded', function(){ showAdminToast('Gagal', @json(session('error')), 'error'); });
@endif
@if(session('info'))
    document.addEventListener('DOMContentLoaded', function(){ showAdminToast('Info', @json(session('info')), 'info'); });
@endif
@if(session('warning'))
    document.addEventListener('DOMContentLoaded', function(){ showAdminToast('Perhatian', @json(session('warning')), 'warning'); });
@endif

// ===== ADMIN NOTIF =====
var lastOrderCount = null;

function toggleAdminNotif(e) {
    e.stopPropagation();
    var dd = document.getElementById('admin-notif-dropdown');
    var isOpen = dd.style.display === 'block';
    document.getElementById('settingsDropdown').style.display = 'none';
    dd.style.display = isOpen ? 'none' : 'block';
    if (!isOpen) { loadAdminNotif(); }
}

function loadAdminNotif() {
    fetch('/admin/notif/list', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(function(r){ return r.json(); })
    .then(function(data) {
        var list = document.getElementById('admin-notif-list');
        if (!data.notifications || data.notifications.length === 0) {
            list.innerHTML = '<div style="padding:32px 16px; text-align:center; color:#888;"><i class="fas fa-bell-slash" style="font-size:28px; color:#ddd; display:block; margin-bottom:10px;"></i><span style="font-size:13px;">Belum ada notifikasi</span></div>';
            return;
        }
        list.innerHTML = data.notifications.map(function(n) {
            return '<div style="padding:12px 16px; border-bottom:1px solid #f5f5f5; display:flex; gap:12px; align-items:flex-start; background:'+(n.is_read?'#fff':'#fef9f0')+';">'
                + '<div style="width:36px; height:36px; border-radius:50%; background:'+n.color+'22; display:flex; align-items:center; justify-content:center; flex-shrink:0;"><i class="fas '+n.icon+'" style="color:'+n.color+'; font-size:13px;"></i></div>'
                + '<div style="flex:1; min-width:0;"><p style="font-size:13px; font-weight:'+(n.is_read?'500':'700')+'; color:#333; margin-bottom:2px; line-height:1.3;">'+n.title+'</p>'
                + '<p style="font-size:11px; color:#666; line-height:1.4; margin-bottom:1px;"><strong>Produk:</strong> '+n.body+'</p>'
                + '<p style="font-size:11px; color:#888; margin-bottom:3px;">'+n.details+'</p>'
                + '<p style="font-size:10px; color:#bbb;">'+n.time+'</p></div>'
                + (!n.is_read ? '<div style="width:7px; height:7px; border-radius:50%; background:#e67e22; flex-shrink:0; margin-top:4px;"></div>' : '')
                + '</div>';
        }).join('');
    }).catch(function(){});
}

function markAllAdminRead() {
    fetch('/admin/notif/mark-all-read', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '', 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function(r){ return r.json(); }).then(function(data) {
        if (data.success) {
            var badge = document.getElementById('admin-notif-badge');
            if (badge) badge.style.display = 'none';
            loadAdminNotif();
        }
    }).catch(function(){});
}

function checkNewOrders() {
    fetch('/admin/notif/check-orders', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(function(r){ return r.json(); })
    .then(function(data) {
        var badge = document.getElementById('admin-notif-badge');
        if (data.unread > 0) {
            badge.textContent = data.unread > 9 ? '9+' : data.unread;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
        if (lastOrderCount !== null && data.new_orders > lastOrderCount) {
            var diff = data.new_orders - lastOrderCount;
            showAdminToast('Pesanan Baru! 🛒', diff + ' pesanan baru masuk. Segera diproses!', 'warning');
        }
        lastOrderCount = data.new_orders;
    }).catch(function(){});
}

document.addEventListener('DOMContentLoaded', function() {
    checkNewOrders();
    setInterval(checkNewOrders, 30000);
});

function toggleDropdown(id) {
    if (id !== 'settingsDropdown') document.getElementById('settingsDropdown').style.display = 'none';
    if (id !== 'admin-notif-dropdown') document.getElementById('admin-notif-dropdown').style.display = 'none';
    var dd = document.getElementById(id);
    dd.style.display = (dd.style.display === 'none' || dd.style.display === '') ? 'block' : 'none';
}

window.addEventListener('click', function(e) {
    if (!e.target.closest('#btn-admin-notif') && !e.target.closest('#admin-notif-dropdown')) {
        var dd = document.getElementById('admin-notif-dropdown');
        if (dd) dd.style.display = 'none';
    }
    if (!e.target.closest('.icon-btn') && !e.target.closest('#settingsDropdown')) {
        document.getElementById('settingsDropdown').style.display = 'none';
    }
});
</script>
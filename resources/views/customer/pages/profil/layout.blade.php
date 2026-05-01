@extends('customer.layouts.app')

@section('title', 'Profil Saya - Kuesaena')

@push('styles')
<style>
.profil-wrapper {
    padding: 96px 0 60px;
    background: #f9f5f0;
    min-height: calc(100vh - 76px);
}

.profil-grid {
    display: flex;
    gap: 24px;
    align-items: flex-start;
}

/* ===== SIDEBAR ===== */
.profil-sidebar {
    width: 270px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #ede0d0;
    padding: 20px;
    position: sticky;
    top: 96px;
}

.sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid #ede0d0;
    margin-bottom: 16px;
}

.sidebar-avatar-wrap {
    position: relative;
    width: 64px;
    height: 64px;
    flex-shrink: 0;
    cursor: pointer;
}

.sidebar-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #e8d5b7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 2px solid #C68B5A;
}

.sidebar-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.sidebar-avatar i {
    font-size: 26px;
    color: #7B3F18;
}

.sidebar-avatar-edit {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 22px;
    height: 22px;
    background: #3B1A08;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 9px;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    transition: background 0.2s;
    z-index: 2;
}

.sidebar-avatar-wrap:hover .sidebar-avatar-edit {
    background: #5C2D0E;
}

.sidebar-name {
    font-weight: 700;
    font-size: 14px;
    color: #1A0A00;
    line-height: 1.3;
}

.sidebar-phone {
    font-size: 12px;
    color: #8B6050;
}

.sidebar-email {
    font-size: 11px;
    color: #8B6050;
    word-break: break-all;
}

.sidebar-logout {
    font-size: 12px;
    color: #c0392b;
    margin-top: 2px;
    display: inline-block;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-family: 'DM Sans', sans-serif;
    transition: opacity 0.2s;
}

.sidebar-logout:hover {
    opacity: 0.75;
}

.sidebar-group {
    margin-bottom: 14px;
}

.sidebar-group-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.sidebar-group-header i {
    color: #8B6050;
    width: 14px;
    font-size: 13px;
}

.sidebar-group-title {
    font-weight: 700;
    font-size: 13px;
    color: #3B1A08;
}

.sidebar-link {
    display: block;
    padding: 6px 0 6px 22px;
    font-size: 13px;
    color: #666;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s;
}

.sidebar-link:hover {
    color: #5C2D0E;
    background: #faf4ec;
    padding-left: 26px;
}

.sidebar-link.active {
    color: #5C2D0E;
    font-weight: 600;
}

/* ===== MAIN CONTENT ===== */
.profil-main {
    flex: 1;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #ede0d0;
    padding: 32px;
    min-height: 420px;
}

.profil-section-title {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #1A0A00;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid #ede0d0;
    font-family: 'DM Sans', sans-serif;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ===== FORM FIELDS ===== */
.form-field-row {
    display: grid;
    grid-template-columns: 155px 1fr;
    align-items: center;
    gap: 16px;
    margin-bottom: 18px;
}

.form-field-label {
    font-weight: 700;
    font-size: 14px;
    color: #1A0A00;
}

.form-input {
    width: 100%;
    padding: 13px 18px;
    border: none;
    border-radius: 12px;
    background: #f5ead8;
    font-size: 14px;
    color: #1A0A00;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: background 0.2s;
}

.form-input:focus {
    background: #eddfc5;
}

.form-select {
    width: 100%;
    padding: 13px 18px;
    border: none;
    border-radius: 12px;
    background: #f5ead8;
    font-size: 14px;
    color: #1A0A00;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%237B3F18' stroke-width='2' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
}

.btn-brown {
    display: inline-block;
    background: #3B1A08;
    color: #fff;
    padding: 11px 32px;
    border-radius: 24px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
}

.btn-brown:hover {
    background: #5C2D0E;
    transform: translateY(-1px);
}

.btn-red {
    display: inline-block;
    background: #c0392b;
    color: #fff;
    padding: 10px 24px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.2s;
}

/* ===== TOGGLE SWITCH ===== */
.toggle-wrap {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
    flex-shrink: 0;
}

.toggle-wrap input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    inset: 0;
    background: #ccc;
    border-radius: 14px;
    cursor: pointer;
    transition: 0.3s;
}

.toggle-slider::after {
    content: '';
    position: absolute;
    top: 4px;
    left: 4px;
    width: 20px;
    height: 20px;
    background: #fff;
    border-radius: 50%;
    transition: 0.3s;
}

.toggle-wrap input:checked + .toggle-slider {
    background: #5C2D0E;
}

.toggle-wrap input:checked + .toggle-slider::after {
    transform: translateX(24px);
}

/* ===== NOTIF CARD ===== */
.notif-card {
    background: #f5ead8;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.notif-card-title {
    font-weight: 700;
    font-size: 14px;
    color: #1A0A00;
    margin-bottom: 3px;
}

.notif-card-desc {
    font-size: 12px;
    color: #8B6050;
}

/* ===== ADDRESS CARD ===== */
.address-card {
    border: 1px solid #ede0d0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 16px;
    position: relative;
}

.address-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.address-label {
    font-weight: 700;
    font-size: 15px;
    color: #1A0A00;
}

.address-text {
    font-size: 13px;
    color: #4A2C10;
    line-height: 1.7;
    margin-bottom: 4px;
}

.address-actions {
    position: absolute;
    bottom: 18px;
    right: 20px;
    display: flex;
    gap: 8px;
}

/* ===== MODAL ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.modal-overlay.open {
    display: flex;
}

.modal-box {
    background: #fff;
    border-radius: 20px;
    padding: 32px;
    width: 540px;
    max-width: 95vw;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}

.modal-title {
    font-size: 16px;
    font-weight: 700;
    color: #1A0A00;
    margin-bottom: 22px;
}

.modal-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #ede0d0;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    color: #1A0A00;
    transition: border-color 0.2s;
}

.modal-input:focus {
    border-color: #7B3F18;
}

.modal-label {
    font-size: 13px;
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #3B1A08;
}

.modal-field {
    margin-bottom: 16px;
}

.modal-footer {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 24px;
}

.btn-ghost {
    padding: 10px 24px;
    border-radius: 20px;
    border: 1.5px solid #ddd;
    background: #fff;
    font-size: 14px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    color: #555;
    transition: all 0.2s;
}

.btn-ghost:hover {
    border-color: #7B3F18;
    color: #3B1A08;
}

/* ===== PRIVASI ===== */
.privasi-card {
    background: #f5ead8;
    border-radius: 16px;
    padding: 28px;
    display: flex;
    align-items: center;
    gap: 20px;
    max-width: 480px;
}

.privasi-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #d4bfa0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    border: 2px solid #C68B5A;
}

.privasi-avatar i {
    font-size: 32px;
    color: #7B3F18;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .profil-grid { flex-direction: column; }
    .profil-sidebar { width: 100%; position: static; }
    .form-field-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="profil-wrapper">
    <div class="container">
        <div class="profil-grid">

            {{-- ===== SIDEBAR ===== --}}
            <div class="profil-sidebar">
                <div class="sidebar-user">
                    <div class="sidebar-avatar-wrap" onclick="openModal('modal-foto-profil')" title="Ganti foto profil">
                        <div class="sidebar-avatar">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <i class="fas fa-user" style="display:none;"></i>
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="sidebar-avatar-edit">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div>
                        <div class="sidebar-name">{{ Auth::user()->username ?? Auth::user()->name }}</div>
                        <div class="sidebar-phone">{{ Auth::user()->masked_phone }}</div>
                        <div class="sidebar-email">{{ Auth::user()->email }}</div>
                        <button type="button" class="sidebar-logout" onclick="openModal('modal-logout')">Logout</button>
                    </div>
                </div>

                {{-- Akun Saya --}}
                <div class="sidebar-group">
                    <div class="sidebar-group-header">
                        <i class="fas fa-user"></i>
                        <span class="sidebar-group-title">Akun Saya</span>
                    </div>
                    <a href="{{ route('customer.profil') }}" class="sidebar-link {{ request()->routeIs('customer.profil') && !request()->routeIs('customer.profil.*') ? 'active' : '' }}">Profil</a>
                    <a href="{{ route('customer.profil.alamat') }}" class="sidebar-link {{ request()->routeIs('customer.profil.alamat') ? 'active' : '' }}">Alamat</a>
                    <a href="{{ route('customer.profil.password') }}" class="sidebar-link {{ request()->routeIs('customer.profil.password') ? 'active' : '' }}">Ubah Password</a>
                    <a href="{{ route('customer.profil.notifikasi') }}" class="sidebar-link {{ request()->routeIs('customer.profil.notifikasi') ? 'active' : '' }}">Pengaturan Notifikasi</a>
                    <a href="{{ route('customer.notifikasi') }}" class="sidebar-link {{ request()->routeIs('customer.notifikasi') ? 'active' : '' }}">Semua Notifikasi</a>
                    <a href="{{ route('customer.profil.privasi') }}" class="sidebar-link {{ request()->routeIs('customer.profil.privasi') ? 'active' : '' }}">Pengaturan Privasi</a>
                </div>

                {{-- Pesanan Saya --}}
                <div class="sidebar-group">
                    <div class="sidebar-group-header">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="sidebar-group-title">Pesanan Saya</span>
                    </div>
                    <a href="{{ route('customer.pesanan') }}" class="sidebar-link {{ request()->routeIs('customer.pesanan') && request()->query('status','all')=='all' ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('customer.pesanan', ['status'=>'belum-bayar']) }}" class="sidebar-link {{ request()->query('status')=='belum-bayar' ? 'active' : '' }}">Belum Bayar</a>
                    <a href="{{ route('customer.pesanan', ['status'=>'sedang-dikemas']) }}" class="sidebar-link {{ request()->query('status')=='sedang-dikemas' ? 'active' : '' }}">Sedang Dikemas</a>
                    <a href="{{ route('customer.pesanan', ['status'=>'selesai']) }}" class="sidebar-link {{ request()->query('status')=='selesai' ? 'active' : '' }}">Selesai</a>
                    <a href="{{ route('customer.pesanan', ['status'=>'dibatalkan']) }}" class="sidebar-link {{ request()->query('status')=='dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
                </div>

                {{-- Wishlist & Like --}}
                <div class="sidebar-group">
                    <div class="sidebar-group-header">
                        <i class="fas fa-heart"></i>
                        <span class="sidebar-group-title">Favorit Saya</span>
                    </div>
                    <a href="{{ route('customer.profil.wishlist') }}" class="sidebar-link {{ request()->routeIs('customer.profil.wishlist') ? 'active' : '' }}">
                        ❤️ Wishlist
                    </a>
                    <a href="{{ route('customer.profil.like') }}" class="sidebar-link {{ request()->routeIs('customer.profil.like') ? 'active' : '' }}">
                        👍 Produk yang Disukai
                    </a>
                </div>

            </div>

            {{-- ===== MAIN CONTENT ===== --}}
            <div class="profil-main">
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('profil-content')
            </div>

        </div>
    </div>
</div>
{{-- ===== MODAL LOGOUT ===== --}}
<div id="modal-logout" class="modal-overlay">
    <div class="modal-box" style="max-width:400px; text-align:center;">
        <div style="width:64px; height:64px; background:#fff3f3; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
            <i class="fas fa-sign-out-alt" style="font-size:26px; color:#c0392b;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A0A00; margin-bottom:8px;">Keluar dari Akun?</h3>
        <p style="font-size:14px; color:#8B6050; margin-bottom:28px; line-height:1.6;">
            Kamu akan keluar dari akun <strong>{{ Auth::user()->username ?? Auth::user()->name }}</strong>.<br>Yakin ingin logout?
        </p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" class="btn-ghost" onclick="closeModal('modal-logout')" style="min-width:110px;">Batal</button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-red" style="min-width:110px;">Ya, Logout</button>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL UPLOAD FOTO PROFIL ===== --}}
<div id="modal-foto-profil" class="modal-overlay">
    <div class="modal-box" style="max-width:420px; text-align:center;">
        <h3 class="modal-title" style="text-align:left;"><i class="fas fa-camera" style="color:#5C2D0E; margin-right:8px;"></i>Foto Profil</h3>

        {{-- Preview --}}
        <div style="position:relative; width:120px; height:120px; margin:0 auto 20px;">
            <div id="foto-preview-wrap" style="width:120px; height:120px; border-radius:50%; background:#e8d5b7; display:flex; align-items:center; justify-content:center; overflow:hidden; border:3px solid #C68B5A;">
                @if(Auth::user()->photo)
                    <img id="foto-preview-img" src="{{ asset('storage/' . Auth::user()->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i id="foto-preview-icon" class="fas fa-user" style="font-size:48px; color:#7B3F18;"></i>
                    <img id="foto-preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none;">
                @endif
            </div>
            <label for="foto-input" style="position:absolute; bottom:4px; right:4px; width:32px; height:32px; background:#3B1A08; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                <i class="fas fa-camera" style="color:#fff; font-size:12px;"></i>
            </label>
        </div>

        <p style="font-size:13px; color:#8B6050; margin-bottom:20px;">
            Klik ikon kamera untuk memilih foto.<br>
            <span style="font-size:11px;">Format: JPG, PNG, JPEG · Maks. 2MB</span>
        </p>

        <form action="{{ route('customer.profil.update.photo') }}" method="POST" enctype="multipart/form-data" id="form-foto">
            @csrf
            <input type="file" name="photo" id="foto-input" accept="image/jpeg,image/png,image/jpg" style="display:none;" onchange="previewFoto(event)">
            <div class="modal-footer" style="justify-content:center;">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-foto-profil')">Batal</button>
                <button type="submit" class="btn-brown" id="btn-simpan-foto" disabled style="opacity:0.5;">Simpan Foto</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

// Preview foto before upload
function previewFoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('foto-preview-img');
        const icon = document.getElementById('foto-preview-icon');
        img.src = e.target.result;
        img.style.display = 'block';
        if (icon) icon.style.display = 'none';
        const btn = document.getElementById('btn-simpan-foto');
        btn.disabled = false;
        btn.style.opacity = '1';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush

@endsection
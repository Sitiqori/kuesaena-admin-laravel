@extends('customer.pages.profil.layout')

@push('styles')
<style>
.notif-list-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    border-bottom: 1px solid #f0e8df;
    transition: background 0.2s;
    cursor: default;
    position: relative;
}
.notif-list-item:last-child { border-bottom: none; }
.notif-list-item:hover { background: #faf5ee; }
.notif-list-item.unread { background: #fdf8f2; }
.notif-list-item.unread::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: #5C2D0E;
    border-radius: 0 2px 2px 0;
}

.notif-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    color: #fff;
}

.notif-content { flex: 1; min-width: 0; }
.notif-title {
    font-size: 14px;
    font-weight: 700;
    color: #1A0A00;
    margin-bottom: 3px;
    line-height: 1.3;
}
.notif-body {
    font-size: 13px;
    color: #8B6050;
    line-height: 1.55;
    margin-bottom: 5px;
}
.notif-time {
    font-size: 11px;
    color: #b0a090;
}
.notif-delete-btn {
    background: none;
    border: none;
    color: #d0b0a0;
    font-size: 14px;
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
    transition: color 0.2s, background 0.2s;
    flex-shrink: 0;
}
.notif-delete-btn:hover { color: #c0392b; background: #fff0f0; }

.notif-filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.notif-filter-tab {
    padding: 7px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: 1.5px solid #ede0d0;
    background: #fff;
    color: #8B6050;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}
.notif-filter-tab.active, .notif-filter-tab:hover {
    background: #3B1A08;
    color: #fff;
    border-color: #3B1A08;
}
</style>
@endpush

@section('profil-content')

@php
    $filter = request()->query('filter', 'semua');
    $filtered = match($filter) {
        'pesanan'  => $notifications->where('type', 'pesanan'),
        'promo'    => $notifications->where('type', 'promo'),
        'belum-dibaca' => $notifications->where('is_read', false),
        default    => $notifications,
    };
@endphp

{{-- HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #ede0d0; flex-wrap:wrap; gap:10px;">
    <h2 class="profil-section-title" style="margin:0; padding:0; border:none;">NOTIFIKASI</h2>
    <div style="display:flex; gap:8px; align-items:center;">
        @if($notifications->count() > 0)
        <form action="{{ route('customer.notifikasi.destroyAll') }}" method="POST" onsubmit="return confirm('Hapus semua notifikasi?')">
            @csrf @method('DELETE')
            <button type="submit" style="background:none; border:1.5px solid #ede0d0; color:#8B6050; padding:7px 14px; border-radius:20px; font-size:12px; cursor:pointer; font-family:inherit; transition:all 0.2s;"
                onmouseover="this.style.borderColor='#c0392b'; this.style.color='#c0392b'"
                onmouseout="this.style.borderColor='#ede0d0'; this.style.color='#8B6050'">
                <i class="fas fa-trash-alt" style="margin-right:5px;"></i>Hapus Semua
            </button>
        </form>
        @endif
        <a href="{{ route('customer.profil.notifikasi') }}"
           style="display:flex; align-items:center; gap:6px; background:#f5ead8; color:#3B1A08; padding:7px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success" style="margin-bottom:16px;"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

{{-- FILTER TABS --}}
<div class="notif-filter-tabs">
    <a href="{{ route('customer.notifikasi') }}" class="notif-filter-tab {{ $filter === 'semua' ? 'active' : '' }}">Semua</a>
    <a href="{{ route('customer.notifikasi', ['filter'=>'belum-dibaca']) }}" class="notif-filter-tab {{ $filter === 'belum-dibaca' ? 'active' : '' }}">
        Belum Dibaca
        @php $unread = $notifications->where('is_read', false)->count(); @endphp
        @if($unread > 0)
            <span style="background:#c0392b; color:#fff; border-radius:10px; padding:1px 7px; font-size:10px; margin-left:4px;">{{ $unread }}</span>
        @endif
    </a>
    <a href="{{ route('customer.notifikasi', ['filter'=>'pesanan']) }}" class="notif-filter-tab {{ $filter === 'pesanan' ? 'active' : '' }}">Pesanan</a>
    <a href="{{ route('customer.notifikasi', ['filter'=>'promo']) }}" class="notif-filter-tab {{ $filter === 'promo' ? 'active' : '' }}">Promo</a>
</div>

{{-- NOTIFICATION LIST --}}
<div style="border:1px solid #ede0d0; border-radius:14px; overflow:hidden;">
    @forelse($filtered as $notif)
    <div class="notif-list-item {{ !$notif->is_read ? 'unread' : '' }}">
        {{-- Icon --}}
        <div class="notif-icon-wrap" style="background:{{ $notif->color ?? '#7B3F18' }}22;">
            <i class="fas {{ $notif->icon ?? 'fa-bell' }}" style="color:{{ $notif->color ?? '#7B3F18' }};"></i>
        </div>

        {{-- Content --}}
        <div class="notif-content">
            <p class="notif-title">{{ $notif->title }}</p>
            <p class="notif-body">{{ $notif->body }}</p>
            <p class="notif-time">
                <i class="fas fa-clock" style="margin-right:4px;"></i>
                {{ $notif->created_at->diffForHumans() }}
            </p>
        </div>

        {{-- Unread dot --}}
        @if(!$notif->is_read)
        <div style="width:8px; height:8px; border-radius:50%; background:#5C2D0E; flex-shrink:0; margin-top:4px;"></div>
        @endif

        {{-- Delete --}}
        <form action="{{ route('customer.notifikasi.destroy', $notif->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="notif-delete-btn" title="Hapus">
                <i class="fas fa-times"></i>
            </button>
        </form>
    </div>
    @empty
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:64px 24px; color:#8B6050;">
        <i class="fas fa-bell-slash" style="font-size:40px; color:#d4bfa0; margin-bottom:14px;"></i>
        <p style="font-size:14px; font-weight:600; color:#4A2C10; margin-bottom:4px;">Tidak ada notifikasi</p>
        <p style="font-size:13px;">Kamu sudah membaca semua notifikasi.</p>
    </div>
    @endforelse
</div>

@endsection

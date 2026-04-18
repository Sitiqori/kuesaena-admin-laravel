@extends('customer.pages.profil.layout')

@section('profil-content')

<h2 class="profil-section-title">PENGATURAN PRIVASI</h2>

@php $user = Auth::user(); @endphp

<div class="privasi-card">
    {{-- Avatar --}}
    <div class="privasi-avatar">
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
        @else
            <i class="fas fa-user"></i>
        @endif
    </div>

    {{-- Info & Hapus --}}
    <div style="flex:1;">
        <div style="background:#e8d5b7; border-radius:10px; padding:12px 18px; font-size:15px; font-weight:700; color:#1A0A00; margin-bottom:16px;">
            {{ $user->username ?? $user->name }}
        </div>
        <button type="button" class="btn-red" onclick="openModal('modal-hapus-akun')">Hapus</button>
        <p style="font-size:11px; color:#8B6050; margin-top:8px; line-height:1.5;">
            Menghapus akun akan menghapus semua data secara permanen dan tidak dapat dikembalikan.
        </p>
    </div>
</div>

{{-- ===== MODAL HAPUS AKUN ===== --}}
<div id="modal-hapus-akun" class="modal-overlay">
    <div class="modal-box" style="max-width:420px; text-align:center;">
        <div style="width:68px; height:68px; background:#fff3f3; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
            <i class="fas fa-trash-alt" style="font-size:28px; color:#c0392b;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A0A00; margin-bottom:8px;">Hapus Akun?</h3>
        <p style="font-size:14px; color:#8B6050; margin-bottom:8px; line-height:1.65;">
            Kamu akan menghapus akun <strong>{{ $user->username ?? $user->name }}</strong> secara permanen.
        </p>
        <div style="background:#fff3f3; border-radius:10px; padding:12px 16px; margin-bottom:24px; text-align:left;">
            <p style="font-size:13px; color:#c0392b; font-weight:600; margin-bottom:4px;">
                <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Peringatan!
            </p>
            <ul style="font-size:12px; color:#721c24; padding-left:16px; line-height:1.8; margin:0;">
                <li>Semua data profil akan dihapus</li>
                <li>Riwayat pesanan tidak dapat dipulihkan</li>
                <li>Reward &amp; poin akan hilang</li>
                <li>Tindakan ini tidak dapat dibatalkan</li>
            </ul>
        </div>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" class="btn-ghost" onclick="closeModal('modal-hapus-akun')" style="min-width:120px;">Batal</button>
            <form action="{{ route('customer.profil.privasi.hapus') }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-red" style="min-width:120px;">Ya, Hapus Akun</button>
            </form>
        </div>
    </div>
</div>

@endsection
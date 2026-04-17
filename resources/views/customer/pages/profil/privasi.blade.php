@extends('customer.pages.profil.layout')

@section('profil-content')

<h2 class="profil-section-title">PENGATURAN PRIVASI</h2>

@php $user = Auth::user(); @endphp

<div class="privasi-card">
    <div class="privasi-avatar">
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
        @else
            <i class="fas fa-user"></i>
        @endif
    </div>
    <div style="flex:1;">
        <div style="background:#e8d5b7; border-radius:10px; padding:12px 18px; font-size:15px; font-weight:700; color:#1A0A00; margin-bottom:16px;">
            {{ $user->username ?? $user->name }}
        </div>
        <form
            action="{{ route('customer.profil.privasi.hapus') }}"
            method="POST"
            onsubmit="return confirmHapusAkun()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-red">Hapus</button>
        </form>
        <p style="font-size:11px; color:#8B6050; margin-top:8px; line-height:1.5;">
            Menghapus akun akan menghapus semua data secara permanen dan tidak dapat dikembalikan.
        </p>
    </div>
</div>

@push('scripts')
<script>
function confirmHapusAkun() {
    return confirm('Apakah kamu yakin ingin menghapus akun?\nSemua data akan dihapus permanen dan tidak dapat dikembalikan.');
}
</script>
@endpush

@endsection

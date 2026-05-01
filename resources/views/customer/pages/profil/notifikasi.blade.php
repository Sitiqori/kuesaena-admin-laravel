@extends('customer.pages.profil.layout')

@section('profil-content')

<h2 class="profil-section-title">PENGATURAN NOTIFIKASI</h2>

@php $user = Auth::user(); @endphp

<div style="max-width: 600px;">

    {{-- WhatsApp --}}
    <div class="notif-card">
        <div>
            <p class="notif-card-title">Notifikasi WhatsApp</p>
            <p class="notif-card-desc">Notifikasi melalui WhatsApp API</p>
        </div>
        <form action="{{ route('customer.profil.notifikasi.update') }}" method="POST">
            @csrf
            <input type="hidden" name="field" value="notif_whatsapp">
            <label class="toggle-wrap">
                <input type="checkbox" name="notif_whatsapp" value="1"
                    {{ $user->notif_whatsapp ? 'checked' : '' }}
                    onchange="this.form.submit()">
                <span class="toggle-slider"></span>
            </label>
        </form>
    </div>

    {{-- Pesanan --}}
    <div class="notif-card">
        <div>
            <p class="notif-card-title">Pesanan</p>
            <p class="notif-card-desc">Informasi terbaru dari status pemesanan</p>
        </div>
        <form action="{{ route('customer.profil.notifikasi.update') }}" method="POST">
            @csrf
            <input type="hidden" name="field" value="notif_pesanan">
            <label class="toggle-wrap">
                <input type="checkbox" name="notif_pesanan" value="1"
                    {{ $user->notif_pesanan ? 'checked' : '' }}
                    onchange="this.form.submit()">
                <span class="toggle-slider"></span>
            </label>
        </form>
    </div>

    {{-- Promosi --}}
    <div class="notif-card">
        <div>
            <p class="notif-card-title">Promosi</p>
            <p class="notif-card-desc">Informasi Ekslusif tentang Promo dan penawaran</p>
        </div>
        <form action="{{ route('customer.profil.notifikasi.update') }}" method="POST">
            @csrf
            <input type="hidden" name="field" value="notif_promo">
            <label class="toggle-wrap">
                <input type="checkbox" name="notif_promo" value="1"
                    {{ $user->notif_promo ? 'checked' : '' }}
                    onchange="this.form.submit()">
                <span class="toggle-slider"></span>
            </label>
        </form>
    </div>

</div>

@endsection
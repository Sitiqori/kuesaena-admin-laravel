@extends('customer.layouts.app')

@section('title', 'Pemesanan Berhasil - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 80px; background: #f9f5f0; min-height: 100vh; }

.berhasil-wrapper {
    max-width: 700px;
    margin: 0 auto;
    padding: 40px 20px 60px;
}

.berhasil-card {
    background: #fff;
    border-radius: 12px;
    padding: 48px 32px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 24px;
}

.icon-berhasil {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #27ae60;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
}

.icon-berhasil svg {
    width: 40px;
    height: 40px;
}

.berhasil-card h1 {
    font-size: 24px;
    font-weight: 700;
    color: #1A0A00;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
}

.berhasil-card .subtitle {
    font-size: 15px;
    color: #8B6050;
    margin-bottom: 32px;
}

.total-pembelian {
    margin-bottom: 8px;
    font-size: 14px;
    color: #8B6050;
}

.total-nilai {
    font-size: 32px;
    font-weight: 700;
    color: #3B1A08;
    font-family: 'Playfair Display', serif;
}

.order-number {
    margin-top: 16px;
    font-size: 13px;
    color: #8B6050;
}
.order-number span {
    font-weight: 700;
    color: #3B1A08;
}

/* Tombol */
.btn-group {
    display: flex;
    gap: 16px;
    justify-content: space-between;
    margin-top: 8px;
}

.btn-lihat {
    flex: 1;
    background: #3B1A08;
    color: #fff;
    padding: 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 15px;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-lihat:hover { background: #5C2D0E; }

.btn-beranda {
    flex: 1;
    background: #3B1A08;
    color: #fff;
    padding: 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 15px;
    text-align: center;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-beranda:hover { background: #5C2D0E; }
</style>
@endpush

@section('content')
<div class="page-content">
<div class="berhasil-wrapper">

    <div class="berhasil-card">
        {{-- Icon centang --}}
        <div class="icon-berhasil">
            <svg viewBox="0 0 24 24" fill="none" stroke="#27ae60" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1>Pemesanan Berhasil!</h1>
        <p class="subtitle">Yay! Pemesananmu telah berhasil masuk!</p>

        <div class="total-pembelian">Total Pembelian</div>
        <div class="total-nilai">Rp {{ number_format($order->total, 0, ',', '.') }}</div>

        <div class="order-number">
            No. Pesanan : <span>{{ $order->order_number }}</span>
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('customer.pesanan') }}" class="btn-lihat">Lihat Pesanan</a>
        <a href="{{ route('customer.home') }}" class="btn-beranda">Beranda</a>
    </div>

</div>
</div>
@endsection
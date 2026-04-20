@extends('customer.pages.profil.layout')

@section('profil-content')

<div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #ede0d0;">
    <a href="{{ route('customer.pesanan') }}"
       style="width:34px; height:34px; background:#f5ead8; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#3B1A08; text-decoration:none; flex-shrink:0;">
        <i class="fas fa-arrow-left" style="font-size:13px;"></i>
    </a>
    <h2 class="profil-section-title" style="margin:0; padding:0; border:none;">DETAIL PESANAN</h2>
</div>

{{-- Status Banner --}}
<div style="background:{{ $order->status_color }}18; border:1px solid {{ $order->status_color }}44; border-radius:12px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between;">
    <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:10px; height:10px; border-radius:50%; background:{{ $order->status_color }};"></div>
        <span style="font-weight:700; font-size:14px; color:{{ $order->status_color }};">{{ $order->status_label }}</span>
    </div>
    <span style="font-size:12px; color:#8B6050;">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</span>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
    {{-- Info Pesanan --}}
    <div style="background:#faf5ee; border-radius:12px; padding:18px 20px;">
        <p style="font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#8B6050; margin-bottom:12px;">Info Pesanan</p>
        <div style="font-size:13px; color:#4A2C10; line-height:2;">
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:130px;">Nomor Pesanan</span>
                <span style="font-weight:600;">{{ $order->order_number }}</span>
            </div>
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:130px;">Tanggal Pesan</span>
                <span>{{ $order->created_at->translatedFormat('d F Y') }}</span>
            </div>
            @if($order->scheduled_at)
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:130px;">Jadwal Ambil</span>
                <span style="color:#A0522D; font-weight:600;">{{ $order->scheduled_at->translatedFormat('d F Y, H:i') }}</span>
            </div>
            @endif
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:130px;">Pengambilan</span>
                <span style="color:#A0522D; font-weight:600;">{{ $order->delivery_method === 'pickup' ? 'Pick Up' : 'Delivery' }}</span>
            </div>
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:130px;">Pembayaran</span>
                <span>{{ strtoupper($order->payment_method) }}</span>
            </div>
        </div>
    </div>

    {{-- Detail Kue --}}
    <div style="background:#faf5ee; border-radius:12px; padding:18px 20px;">
        <p style="font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#8B6050; margin-bottom:12px;">Detail Kue</p>
        <div style="font-size:13px; color:#4A2C10; line-height:2;">
            @if($order->size)
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:100px;">Size</span>
                <span>{{ $order->size }}</span>
            </div>
            @endif
            @if($order->cake_flavor)
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:100px;">Rasa Cake</span>
                <span>{{ $order->cake_flavor }}</span>
            </div>
            @endif
            @if($order->notes)
            <div style="display:flex; gap:8px;">
                <span style="color:#8B6050; min-width:100px;">Catatan</span>
                <span style="color:#A0522D; font-weight:600;">{{ $order->notes }}</span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Daftar Produk --}}
<div style="border:1px solid #ede0d0; border-radius:12px; overflow:hidden; margin-bottom:20px;">
    <div style="padding:14px 20px; background:#faf5ee; border-bottom:1px solid #ede0d0;">
        <p style="font-size:12px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#8B6050; margin:0;">Produk Dipesan</p>
    </div>
    @foreach($order->orderItems as $item)
    <div style="display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:{{ !$loop->last ? '1px solid #f0e8df' : 'none' }};">
        <div style="width:56px; height:56px; border-radius:8px; overflow:hidden; background:#f5ead8; flex-shrink:0;">
            @if($item->product && $item->product->image)
                <img src="{{ asset('images/products/' . $item->product->image) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-birthday-cake" style="color:#C68B5A;"></i>
                </div>
            @endif
        </div>
        <div style="flex:1;">
            <p style="font-size:14px; font-weight:600; color:#1A0A00; margin-bottom:2px;">{{ $item->product?->name ?? 'Produk' }}</p>
            <p style="font-size:12px; color:#8B6050;">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
        </div>
        <p style="font-size:14px; font-weight:700; color:#3B1A08;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
    </div>
    @endforeach
</div>

{{-- Ringkasan Harga --}}
<div style="background:#faf5ee; border-radius:12px; padding:18px 20px; margin-bottom:24px;">
    <p style="font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#8B6050; margin-bottom:14px;">Ringkasan Harga</p>
    <div style="font-size:13px; color:#4A2C10;">
        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <span style="color:#8B6050;">Subtotal</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($order->tax > 0)
        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <span style="color:#8B6050;">Pajak</span>
            <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($order->discount > 0)
        <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
            <span style="color:#8B6050;">Diskon</span>
            <span style="color:#27ae60;">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div style="display:flex; justify-content:space-between; padding-top:12px; border-top:1px solid #ede0d0; margin-top:4px;">
            <span style="font-weight:700; color:#1A0A00; font-size:14px;">Total</span>
            <span style="font-weight:700; color:#3B1A08; font-size:16px;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

{{-- Action --}}
<div style="display:flex; gap:12px;">
    <a href="{{ route('customer.pesanan') }}" class="btn-ghost" style="text-decoration:none;">
        ← Kembali ke Pesanan
    </a>
    <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya terkait pesanan {{ $order->order_number }}"
       target="_blank"
       class="btn-brown"
       style="text-decoration:none;">
        <i class="fab fa-whatsapp" style="margin-right:6px;"></i> Hubungi Penjual
    </a>
</div>

@endsection

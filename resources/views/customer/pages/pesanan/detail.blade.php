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

{{-- Status Tracker --}}
@php
    $isProcessing = in_array($order->status, ['processing', 'ready', 'completed']);
    $isReady      = in_array($order->status, ['ready', 'completed']);
    $isCompleted  = $order->status === 'completed';
    $isReviewed   = $order->review !== null;
    $activeColor  = '#3B6E3A';
    $deliveryLabel = $order->delivery_method === 'pickup' ? 'Pick Up' : 'Siap Diantar';

    $steps = [
        ['icon' => 'fas fa-clipboard-list', 'label' => 'Pesanan Dibuat',   'active' => true],
        ['icon' => 'fas fa-box-open',        'label' => $isProcessing ? 'Sedang Dikemas' : 'Belum Dikemas', 'active' => $isProcessing],
        ['icon' => $order->delivery_method === 'pickup' ? 'fas fa-store' : 'fas fa-truck',
                                             'label' => $isReady ? $deliveryLabel : ($order->delivery_method === 'pickup' ? 'Belum Siap Diambil' : 'Belum Siap Diantar'), 'active' => $isReady],
        ['icon' => 'fas fa-check-circle',   'label' => $isCompleted ? 'Pesanan Selesai' : 'Belum Selesai', 'active' => $isCompleted],
        ['icon' => 'fas fa-star',            'label' => $isReviewed  ? 'Pesanan Dinilai' : 'Belum Dinilai', 'active' => $isReviewed],
    ];
@endphp

<div style="background:#faf5ee; border-radius:12px; padding:24px 20px; margin-bottom:20px;">
    <div style="display:flex; align-items:flex-start; justify-content:space-between; position:relative;">
        <div style="position:absolute; top:22px; left:calc(10% - 1px); width:80%; height:2px; background:#d4c4b0; z-index:0;"></div>
        @foreach($steps as $step)
        <div style="display:flex; flex-direction:column; align-items:center; gap:8px; flex:1; position:relative; z-index:1;">
            <div style="width:44px; height:44px; border-radius:50%; background:{{ $step['active'] ? $activeColor : '#d4c4b0' }}; display:flex; align-items:center; justify-content:center;">
                <i class="{{ $step['icon'] }}" style="color:white; font-size:15px;"></i>
            </div>
            <span style="font-size:10px; font-weight:{{ $step['active'] ? '700' : '500' }}; color:{{ $step['active'] ? $activeColor : '#8B6050' }}; text-align:center; line-height:1.4;">
                {{ $step['label'] }}
            </span>
        </div>
        @endforeach
    </div>
</div>

{{-- Ulasan (hanya jika completed) --}}
@if($isCompleted)
    @if($isReviewed)
    <div style="background:#faf5ee; border:1px solid #ede0d0; border-radius:12px; padding:18px 20px; margin-bottom:20px;">
        <p style="font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#8B6050; margin-bottom:10px;">Ulasan Kamu</p>
        <div style="display:flex; gap:4px; margin-bottom:8px;">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star" style="color:{{ $i <= $order->review->rating ? '#e6a817' : '#d4c4b0' }}; font-size:18px;"></i>
            @endfor
        </div>
        <p style="font-size:13px; font-weight:600; color:#3B1A08; margin-bottom:4px;">{{ $order->review->name }}</p>
        <p style="font-size:13px; color:#4A2C10;">{{ $order->review->body }}</p>
    </div>
    @else
    <div style="margin-bottom:20px; text-align:right;">
        <button onclick="document.getElementById('modal-ulasan').style.display='flex'"
                style="background:#3B1A08; color:white; border:none; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
            Tulis Ulasan
        </button>
    </div>
    <div id="modal-ulasan" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:white; border-radius:16px; padding:28px; width:90%; max-width:440px; position:relative;">
            <button onclick="document.getElementById('modal-ulasan').style.display='none'"
                    style="position:absolute; top:16px; right:16px; background:none; border:none; font-size:20px; cursor:pointer; color:#8B6050;">×</button>
            <h3 style="font-size:16px; font-weight:700; color:#3B1A08; margin-bottom:20px;">Tulis Ulasan</h3>
            <form action="{{ route('customer.pesanan.ulasan', $order->id) }}" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <label style="font-size:12px; font-weight:600; color:#8B6050; display:block; margin-bottom:6px;">Nama</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required
                           style="width:100%; padding:10px 12px; border:1px solid #d4c4b0; border-radius:8px; font-size:13px; box-sizing:border-box; outline:none;">
                </div>
                <div style="margin-bottom:14px;">
                    <label style="font-size:12px; font-weight:600; color:#8B6050; display:block; margin-bottom:6px;">Tulis Ulasan</label>
                    <textarea name="body" rows="3" placeholder="Enak Banget" required
                              style="width:100%; padding:10px 12px; border:1px solid #d4c4b0; border-radius:8px; font-size:13px; box-sizing:border-box; resize:none; outline:none;"></textarea>
                </div>
                <div style="margin-bottom:20px;">
                    <input type="hidden" name="rating" id="rating-value" value="0">
                    <div style="display:flex; gap:6px;">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="far fa-star" id="star-{{ $i }}" onclick="setRating({{ $i }})"
                           style="font-size:28px; color:#d4c4b0; cursor:pointer;"></i>
                        @endfor
                    </div>
                </div>
                <button type="submit"
                        style="width:100%; background:#3B1A08; color:white; border:none; padding:12px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
                    ★ Simpan Ulasan
                </button>
            </form>
        </div>
    </div>
    @endif
@endif

{{-- Info Grid --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
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

{{-- Produk --}}
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
       target="_blank" class="btn-brown" style="text-decoration:none;">
        <i class="fab fa-whatsapp" style="margin-right:6px;"></i> Hubungi Penjual
    </a>
</div>

@push('scripts')
<script>
function setRating(val) {
    document.getElementById('rating-value').value = val;
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        star.className = i <= val ? 'fas fa-star' : 'far fa-star';
        star.style.color = i <= val ? '#e6a817' : '#d4c4b0';
    }
}
</script>
@endpush

@endsection
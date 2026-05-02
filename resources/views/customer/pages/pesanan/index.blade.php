@extends('customer.pages.profil.layout')

@push('styles')
<style>
/* Override profil-main padding untuk halaman pesanan */
.pesanan-wrapper .profil-main {
    padding: 0 !important;
}
</style>
@endpush

@section('profil-content')

@php
    $tabs = [
        'all'            => 'Semua',
        'belum-bayar'    => 'Belum Bayar',
        'sedang-dikemas' => 'Sedang Dikemas',
        'selesai'        => 'Selesai',
        'dibatalkan'     => 'Dibatalkan',
    ];
@endphp

{{-- ===== TAB NAVIGATION - flush, full width ===== --}}
<div style="display:flex; border-bottom:2px solid #ede0d0; margin:-32px -32px 0 -32px;">
    @foreach($tabs as $key => $label)
        <a href="{{ route('customer.pesanan', $key === 'all' ? [] : ['status' => $key]) }}"
           style="
               flex:1;
               display:block;
               padding:16px 8px;
               font-size:13px;
               font-weight: {{ $status === $key ? '700' : '500' }};
               color: {{ $status === $key ? '#3B1A08' : '#8B6050' }};
               text-decoration:none;
               text-align:center;
               border-bottom: 2px solid {{ $status === $key ? '#3B1A08' : 'transparent' }};
               margin-bottom:-2px;
               white-space:nowrap;
               transition:color 0.2s;
           "
           onmouseover="if('{{ $status }}' !== '{{ $key }}') this.style.color='#3B1A08'"
           onmouseout="if('{{ $status }}' !== '{{ $key }}') this.style.color='#8B6050'"
        >{{ strtoupper($label) }}</a>
    @endforeach
</div>

{{-- ===== ORDER LIST ===== --}}
<div style="padding:24px 32px 32px;">

@forelse($orders as $order)
    @php
        $firstItem = $order->orderItems->first();
        $product   = $firstItem?->product;
    @endphp
    <div style="border:1px solid #ede0d0; border-radius:14px; margin-bottom:16px; overflow:hidden;">

        {{-- Card Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 20px; background:#faf5ee; border-bottom:1px solid #ede0d0;">
            <span style="font-size:12px; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; color:{{ $order->status_color }};">
                {{ $order->status_label }}
            </span>
            <span style="font-size:12px; color:#8B6050;">
                {{ $order->created_at->translatedFormat('d F Y') }}
            </span>
        </div>

        {{-- Card Body --}}
        <div style="padding:16px 20px; display:flex; align-items:flex-start; gap:16px;">

            {{-- Product Image --}}
            <div style="width:90px; height:90px; flex-shrink:0; border-radius:10px; overflow:hidden; background:#f5ead8;">
                @if($product && $product->image)
                    <img src="{{ str_starts_with($product->image, 'images/') ? asset($product->image) : asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-birthday-cake" style="font-size:28px; color:#C68B5A;"></i>
                    </div>
                @endif
            </div>

            {{-- Order Info --}}
            <div style="flex:1; min-width:0;">
                <p style="font-weight:700; font-size:15px; color:#1A0A00; margin-bottom:4px; line-height:1.3;">
                    {{ $product?->name ?? 'Produk' }}
                    @if($order->orderItems->count() > 1)
                        <span style="font-size:12px; font-weight:400; color:#8B6050; margin-left:4px;">+{{ $order->orderItems->count() - 1 }} lainnya</span>
                    @endif
                </p>

                @if($order->scheduled_at)
                <p style="font-size:13px; color:#A0522D; font-weight:600; margin-bottom:6px;">
                    {{ $order->scheduled_at->translatedFormat('d F, H.i') }}
                </p>
                @endif

                <div style="font-size:13px; color:#4A2C10; line-height:2.0;">
                    <p>Pengambilan : <span style="color:#A0522D; font-weight:600;">{{ $order->delivery_method === 'pickup' ? 'Pick Up' : 'Delivery' }}</span></p>
                    @if($order->size)<p>Size : {{ $order->size }}</p>@endif
                    @if($order->cake_flavor)<p>Rasa Cake : {{ $order->cake_flavor }}</p>@endif
                    <p>Kuantitas : {{ $order->orderItems->sum('quantity') }}</p>
                    <p>Nomor Pesanan : <span style="font-weight:600; letter-spacing:0.5px;">{{ $order->order_number }}</span></p>
                    <p>Total Harga : <span style="font-weight:700;">Rp {{ number_format($order->total, 0, ',', '.') }}</span></p>
                    @if($order->notes)
                    <p>Catatan : <span style="color:#A0522D; font-weight:600;">{{ $order->notes }}</span></p>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex; flex-direction:column; gap:8px; flex-shrink:0; min-width:150px;">
                <a href="{{ route('customer.pesanan.show', $order->id) }}"
                   style="display:block; padding:9px 16px; background:#e8d5b7; color:#3B1A08; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; text-align:center; white-space:nowrap; transition:background 0.2s;"
                   onmouseover="this.style.background='#d4bfa0'" onmouseout="this.style.background='#e8d5b7'">
                    Lihat Detail Pesanan
                </a>
                <a href="https://wa.me/6285186860109?text=Halo,%20saya%20ingin%20bertanya%20terkait%20pesanan%20{{ $order->order_number }}"
                   target="_blank"
                   style="display:block; padding:9px 16px; background:#e8d5b7; color:#3B1A08; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; text-align:center; white-space:nowrap; transition:background 0.2s;"
                   onmouseover="this.style.background='#d4bfa0'" onmouseout="this.style.background='#e8d5b7'">
                    Hubungi Penjual
                </a>
                @if($order->status === 'completed' && !$order->review)
                <button onclick="openModalUlasan({{ $order->id }})"
                   style="display:block; width:100%; padding:9px 16px; background:#5C2D0E; color:#fff; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; text-align:center; white-space:nowrap; transition:background 0.2s; border:none; cursor:pointer; font-family:inherit;"
                   onmouseover="this.style.background='#3B1A08'" onmouseout="this.style.background='#5C2D0E'">
                    <i class="fas fa-star" style="margin-right:4px; font-size:11px;"></i> Tulis Ulasan
                </button>
                @endif
                @if($order->status === 'pending')
                <form action="{{ route('customer.pesanan.cancel', $order->id) }}" method="POST"
                      onsubmit="return confirm('Batalkan pesanan {{ $order->order_number }}?')">
                    @csrf
                    <button type="submit"
                        style="display:block; width:100%; padding:9px 16px; background:#fff; color:#c0392b; border:1.5px solid #c0392b; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; text-align:center; white-space:nowrap; transition:all 0.2s; font-family:inherit;"
                        onmouseover="this.style.background='#c0392b'; this.style.color='#fff'"
                        onmouseout="this.style.background='#fff'; this.style.color='#c0392b'">
                        Batalkan Pesanan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
@empty
    {{-- Empty State --}}
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:80px 24px; color:#8B6050;">
        <div style="position:relative; display:inline-block; margin-bottom:16px;">
            <i class="fas fa-clipboard-list" style="font-size:52px; color:#d4bfa0;"></i>
            <div style="position:absolute; bottom:-4px; right:-10px; width:26px; height:26px; background:#e8d5b7; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-times" style="font-size:11px; color:#A0522D;"></i>
            </div>
        </div>
        <p style="font-size:14px; color:#8B6050;">Belum ada pesanan</p>
    </div>
@endforelse

</div>

{{-- Modal Tulis Ulasan --}}
<div id="modal-ulasan-global" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:28px; width:90%; max-width:440px; position:relative;">
        <button onclick="closeModalUlasan()" style="position:absolute; top:16px; right:16px; background:none; border:none; font-size:20px; cursor:pointer; color:#8B6050;">×</button>
        <h3 style="font-size:16px; font-weight:700; color:#3B1A08; margin-bottom:20px;">Tulis Ulasan</h3>
        <form id="form-ulasan" method="POST">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:600; color:#8B6050; display:block; margin-bottom:6px;">Nama</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required
                       style="width:100%; padding:10px 12px; border:1px solid #d4c4b0; border-radius:8px; font-size:13px; box-sizing:border-box; outline:none;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:600; color:#8B6050; display:block; margin-bottom:6px;">Tulis Ulasan</label>
                <textarea name="body" rows="3" placeholder="Ceritakan pengalamanmu..." required
                          style="width:100%; padding:10px 12px; border:1px solid #d4c4b0; border-radius:8px; font-size:13px; box-sizing:border-box; resize:none; outline:none;"></textarea>
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:600; color:#8B6050; display:block; margin-bottom:8px;">Rating</label>
                <input type="hidden" name="rating" id="rating-value" value="0">
                <div style="display:flex; gap:6px;">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="far fa-star" id="star-{{ $i }}" onclick="setRating({{ $i }})"
                       style="font-size:28px; color:#d4c4b0; cursor:pointer;"></i>
                    @endfor
                </div>
            </div>
            <button type="submit" style="width:100%; background:#3B1A08; color:white; border:none; padding:12px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;">
                ★ Simpan Ulasan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModalUlasan(orderId) {
    const form = document.getElementById('form-ulasan');
    form.action = '/pesanan-saya/' + orderId + '/ulasan';
    // Reset form
    form.querySelector('textarea').value = '';
    setRating(0);
    document.getElementById('modal-ulasan-global').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeModalUlasan() {
    document.getElementById('modal-ulasan-global').style.display = 'none';
    document.body.style.overflow = '';
}
function setRating(val) {
    document.getElementById('rating-value').value = val;
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        star.className = i <= val ? 'fas fa-star' : 'far fa-star';
        star.style.color = i <= val ? '#e6a817' : '#d4c4b0';
    }
}
// Tutup modal klik luar
document.getElementById('modal-ulasan-global').addEventListener('click', function(e) {
    if (e.target === this) closeModalUlasan();
});
</script>
@endpush

@endsection
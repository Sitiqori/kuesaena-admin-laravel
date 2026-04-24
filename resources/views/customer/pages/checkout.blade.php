@extends('customer.layouts.app')

@section('title', 'Checkout - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 80px; background: #f9f5f0; min-height: 100vh; }

.checkout-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 20px 60px;
}

.checkout-card {
    background: #fff;
    border-radius: 12px;
    padding: 28px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.checkout-card h2 {
    font-size: 18px;
    font-weight: 700;
    color: #3B1A08;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0e8df;
}

/* Item produk */
.item-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid #f9f5f0;
}
.item-row:last-child { border-bottom: none; }
.item-row img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #f0e8df;
}
.item-info { flex: 1; }
.item-info .nama { font-weight: 600; color: #1A0A00; font-size: 14px; }
.item-info .detail { font-size: 12px; color: #8B6050; margin-top: 4px; }
.item-subtotal { font-weight: 700; color: #3B1A08; font-size: 15px; }

/* Form */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #3B1A08; margin-bottom: 6px; }
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #1A0A00;
    background: #fff;
    transition: border 0.2s;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #C68B5A;
}

/* Toggle pengambilan */
.toggle-group {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}
.toggle-btn {
    flex: 1;
    padding: 12px;
    border: 2px solid #e8d5b7;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    color: #8B6050;
    background: #fff;
    transition: all 0.2s;
}
.toggle-btn.active {
    border-color: #3B1A08;
    background: #3B1A08;
    color: #fff;
}

/* Alamat card */
.address-card {
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.2s;
}
.address-card:hover { border-color: #C68B5A; }
.address-card.selected { border-color: #3B1A08; background: #fdf8f3; }
.address-card .label { font-weight: 700; font-size: 13px; color: #3B1A08; }
.address-card .detail { font-size: 12px; color: #8B6050; margin-top: 4px; }

/* Ringkasan harga */
.harga-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #4A2C10;
    padding: 8px 0;
    border-bottom: 1px solid #f0e8df;
}
.harga-row:last-child { border-bottom: none; }
.harga-row.total {
    font-weight: 700;
    font-size: 16px;
    color: #1A0A00;
    padding-top: 12px;
}

/* Tombol aksi */
.btn-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 24px;
}
.btn-kembali {
    background: #3B1A08;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}
.btn-kembali:hover { background: #5C2D0E; }
.btn-lanjut {
    background: #3B1A08;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-lanjut:hover { background: #5C2D0E; }

.alert-error {
    background: #ffebee;
    color: #c62828;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 14px;
}

#section-alamat { display: none; }
</style>
@endpush

@section('content')
<div class="page-content">
<div class="checkout-wrapper">

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.pembayaran') }}" method="POST" id="checkout-form">
        @csrf

        {{-- ===== DETAIL PRODUK ===== --}}
        <div class="checkout-card">
            @foreach($cartItems as $item)
            <div class="item-row">
                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-image.png') }}"
                     alt="{{ $item->product->name }}">
                <div class="item-info">
                    <div class="nama">{{ $item->product->name }}</div>
                    <div class="detail">
                        @if($item->flavor) Rasa: {{ $item->flavor }} @endif
                        @if($item->size) | Ukuran: {{ $item->size }} @endif
                        @if($item->note) | Catatan: {{ $item->note }} @endif
                    </div>
                    <div class="detail">Jumlah: {{ $item->quantity }}</div>
                </div>
                <div class="item-subtotal">
                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        {{-- ===== FORM DETAIL PESANAN ===== --}}
        <div class="checkout-card">
            <h2>Detail Pesanan</h2>

            <div class="form-row">
                <div class="form-group">
                    <label>Rasa</label>
                    <input type="text" name="cake_flavor" placeholder="Contoh: Coklat, Stroberi" value="{{ old('cake_flavor') }}">
                </div>
                <div class="form-group">
                    <label>Ukuran</label>
                    <input type="text" name="size" placeholder="Contoh: 11cm, 22cm" value="{{ old('size') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="notes" rows="2" placeholder="Contoh: Krimnya jangan terlalu banyak.">{{ old('notes') }}</textarea>
            </div>

            {{-- Toggle Pengambilan --}}
            <div class="form-group">
                <label>Pengambilan</label>
                <div class="toggle-group">
                    <div class="toggle-btn active" id="btn-pickup" onclick="pilihPengambilan('pickup')">
                        Pickup
                    </div>
                    <div class="toggle-btn" id="btn-antar" onclick="pilihPengambilan('antar')">
                        Antar
                    </div>
                </div>
                <input type="hidden" name="delivery_method" id="delivery_method" value="pickup">
            </div>

            {{-- Section Alamat (muncul kalau pilih Antar) --}}
            <div id="section-alamat">
                <div class="form-group">
                    <label>Pilih Alamat Pengiriman</label>
                    @if($addresses->count() > 0)
                        @foreach($addresses as $addr)
                        <div class="address-card {{ $loop->first ? 'selected' : '' }}"
                             onclick="pilihAlamat({{ $addr->id }}, this)">
                            <div class="label">{{ $addr->label }}</div>
                            <div class="detail">{{ $addr->address }}, {{ $addr->kecamatan }}, {{ $addr->kota }}</div>
                            <div class="detail">{{ $addr->phone }}</div>
                        </div>
                        @endforeach
                        <input type="hidden" name="address_id" id="address_id"
                               value="{{ $addresses->first()->id }}">
                    @else
                        <p style="font-size:13px; color:#8B6050;">
                            Belum ada alamat tersimpan.
                            <a href="{{ route('customer.profil.alamat') }}" style="color:#3B1A08; font-weight:600;">
                                Tambah alamat
                            </a>
                        </p>
                        <input type="hidden" name="address_id" id="address_id" value="">
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== RINGKASAN HARGA ===== --}}
        <div class="checkout-card">
            <h2>Harga</h2>
            <div class="harga-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="harga-row">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>
            <div class="harga-row total">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="btn-actions">
            <a href="{{ route('keranjang.index') }}" class="btn-kembali">Kembali</a>
            <button type="submit" class="btn-lanjut">Pilih Opsi Pembayaran</button>
        </div>

    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
function pilihPengambilan(metode) {
    document.getElementById('delivery_method').value = metode;

    if (metode === 'pickup') {
        document.getElementById('btn-pickup').classList.add('active');
        document.getElementById('btn-antar').classList.remove('active');
        document.getElementById('section-alamat').style.display = 'none';
    } else {
        document.getElementById('btn-antar').classList.add('active');
        document.getElementById('btn-pickup').classList.remove('active');
        document.getElementById('section-alamat').style.display = 'block';
    }
}

function pilihAlamat(id, el) {
    document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('address_id').value = id;
}
</script>
@endpush
@extends('customer.layouts.app')

@section('title', 'Keranjang - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 76px; }

/* =====================
   KERANJANG SECTION
===================== */
.keranjang-wrapper {
    padding: 40px 0 60px;
    background: #f9f5f0;
    min-height: calc(100vh - 76px);
}

.keranjang-table {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 16px;
}

/* Header tabel */
.keranjang-header {
    display: grid;
    grid-template-columns: 40px 1fr 220px 130px 160px 100px;
    align-items: center;
    background: #3B1A08;
    color: #fff;
    padding: 14px 20px;
    font-weight: 600;
    font-size: 14px;
    gap: 12px;
}

/* Row item */
.keranjang-item {
    display: grid;
    grid-template-columns: 40px 1fr 220px 130px 160px 100px;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid #f0e8df;
    gap: 12px;
    background: #fff;
    transition: background 0.2s;
}
.keranjang-item:hover { background: #fdf8f3; }
.keranjang-item:last-child { border-bottom: none; }

/* Produk info */
.item-produk {
    display: flex;
    align-items: center;
    gap: 14px;
}
.item-produk img {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e8d5b7;
}
.item-produk-info .nama { font-weight: 600; color: #1A0A00; font-size: 14px; }
.item-produk-info .harga { color: #7B3F18; font-size: 13px; margin-top: 2px; }

/* Detail rasa/ukuran */
.item-detail {
    background: #f9f5f0;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 12px;
    color: #4A2C10;
    line-height: 1.8;
}
.item-detail span { color: #7B3F18; }

/* Kuantitas */
.qty-control {
    display: flex;
    align-items: center;
    gap: 8px;
}
.qty-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid #C68B5A;
    background: #fff;
    color: #3B1A08;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.qty-btn:hover { background: #3B1A08; color: #fff; }
.qty-input {
    width: 40px;
    text-align: center;
    border: 1px solid #e8d5b7;
    border-radius: 4px;
    padding: 4px;
    font-size: 14px;
    font-weight: 600;
    color: #1A0A00;
}

/* Total harga per item */
.item-total {
    font-weight: 700;
    color: #1A0A00;
    font-size: 15px;
}

/* Tombol hapus */
.btn-hapus {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-hapus:hover { background: #c0392b; }

/* Footer keranjang */
.keranjang-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #3B1A08;
    color: #fff;
    padding: 16px 20px;
    border-radius: 0 0 8px 8px;
}
.keranjang-footer .total-text { font-size: 15px; }
.keranjang-footer .total-text strong { font-size: 18px; margin-left: 8px; }
.btn-checkout {
    background: #fff;
    color: #3B1A08;
    padding: 10px 32px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-checkout:hover { background: #f5ecd8; }
.btn-hapus-semua {
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-hapus-semua:hover { background: #c0392b; }

/* Keranjang kosong */
.keranjang-kosong {
    text-align: center;
    padding: 80px 20px;
    background: #fff;
    border-radius: 8px;
}
.keranjang-kosong i { font-size: 60px; color: #C68B5A; margin-bottom: 16px; }
.keranjang-kosong h3 { font-size: 22px; color: #3B1A08; margin-bottom: 8px; }
.keranjang-kosong p { color: #8B6050; margin-bottom: 24px; }
.btn-belanja {
    background: #3B1A08;
    color: #fff;
    padding: 12px 32px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
}
.btn-belanja:hover { background: #5C2D0E; }

/* =====================
   REKOMENDASI SECTION
===================== */
.rekomendasi-section { padding: 48px 0; }

.rekomendasi-header {
    display: inline-block;
    background: #3B1A08;
    color: #fff;
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 24px;
}

.rekomendasi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.produk-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    color: inherit;
}
.produk-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
.produk-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}
.produk-card-info { padding: 12px; }
.produk-card-info .nama { font-weight: 600; font-size: 14px; color: #1A0A00; }
.produk-card-info .harga { color: #7B3F18; font-size: 13px; margin-top: 4px; }

.btn-lihat-lainnya {
    display: inline-block;
    background: #3B1A08;
    color: #fff;
    padding: 10px 24px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    margin-top: 24px;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-lihat-lainnya:hover { background: #5C2D0E; }

/* Alert */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 16px;
    border: 1px solid #c3e6cb;
}

@media (max-width: 768px) {
    .keranjang-header { display: none; }
    .keranjang-item {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    .rekomendasi-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
<div class="page-content">
<div class="keranjang-wrapper">
<div class="container">

    {{-- Alert success --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- ===== TABEL KERANJANG ===== --}}
    @if($cartItems->count() > 0)

        <div class="keranjang-table">
            {{-- Header --}}
            <div class="keranjang-header">
                <div>
                    <input type="checkbox" id="pilih-semua" onchange="pilihSemua(this)">
                </div>
                <div>Detail Produk</div>
                <div>Detail Pesanan</div>
                <div>Kuantitas</div>
                <div>Total Harga</div>
                <div>Aksi</div>
            </div>

            {{-- Item --}}
            @foreach($cartItems as $item)
            <div class="keranjang-item" id="item-{{ $item->id }}">
                {{-- Checkbox --}}
                <div>
                    <input type="checkbox" class="item-checkbox" value="{{ $item->id }}">
                </div>

                {{-- Produk info --}}
                <div class="item-produk">
                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/no-image.png') }}"
                         alt="{{ $item->product->name }}">
                    <div class="item-produk-info">
                        <div class="nama">{{ $item->product->name }}</div>
                        <div class="harga">Rp. {{ number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- Detail rasa/ukuran --}}
                <div class="item-detail">
                    <div>Rasa &nbsp;&nbsp;: <span>{{ $item->flavor ?? '-' }}</span></div>
                    <div>Ukuran : <span>{{ $item->size ?? '-' }}</span></div>
                    <div>Catatan : <span>{{ $item->note ?? '-' }}</span></div>
                </div>

                {{-- Kuantitas --}}
                <div class="qty-control">
                    <button class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
                    <input type="number" class="qty-input" id="qty-{{ $item->id }}"
                           value="{{ $item->quantity }}" min="1"
                           onchange="updateQtyDirect({{ $item->id }}, this.value)">
                    <button class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
                </div>

                {{-- Total harga --}}
                <div class="item-total" id="subtotal-{{ $item->id }}">
                    Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                </div>

                {{-- Hapus --}}
                <div>
                    <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                          onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Footer keranjang --}}
        <div class="keranjang-footer" style="border-radius: 8px; margin-top: 0;">
            <form action="{{ route('keranjang.hapusSemua') }}" method="POST"
                  onsubmit="return confirm('Hapus semua item dari keranjang?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-hapus-semua">Hapus</button>
            </form>

            <div class="total-text">
                Total ({{ $cartItems->count() }} Produk) :
                <strong id="grand-total">Rp.{{ number_format($total, 0, ',', '.') }}</strong>
            </div>

            <a href="{{ route('pembayaran.index') }}" class="btn-checkout">Checkout</a>
        </div>

    @else
        {{-- Keranjang kosong --}}
        <div class="keranjang-kosong">
            <i class="fas fa-shopping-cart"></i>
            <h3>Keranjang Masih Kosong</h3>
            <p>Yuk, tambahkan produk favoritmu ke keranjang!</p>
            <a href="{{ route('customer.menu') }}" class="btn-belanja">Lihat Menu</a>
        </div>
    @endif

    {{-- ===== REKOMENDASI ===== --}}
    <div class="rekomendasi-section">
        <div class="rekomendasi-header">Rekomendasi</div>
        <div class="rekomendasi-grid">
            @foreach($rekomendasi as $produk)
            <a href="#" class="produk-card">
                <img src="{{ $produk->image ? asset('storage/' . $produk->image) : asset('images/no-image.png') }}"
                     alt="{{ $produk->name }}">
                <div class="produk-card-info">
                    <div class="nama">{{ $produk->name }}</div>
                    <div class="harga">Rp. {{ number_format($produk->price, 0, ',', '.') }}</div>
                </div>
            </a>
            @endforeach
        </div>
        <a href="{{ route('customer.menu') }}" class="btn-lihat-lainnya">Lihat lainnya</a>
    </div>

</div>
</div>
</div>
@endsection

@push('scripts')
<script>
// Pilih semua checkbox
function pilihSemua(el) {
    document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = el.checked);
}

// Update kuantitas via tombol + / -
function updateQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    kirimUpdateQty(id, val);
}

// Update kuantitas langsung dari input
function updateQtyDirect(id, val) {
    if (val < 1) val = 1;
    kirimUpdateQty(id, val);
}

// Kirim AJAX update kuantitas
function kirimUpdateQty(id, qty) {
    fetch(`/keranjang/update/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('subtotal-' + id).textContent = 'Rp. ' + data.subtotal;
            hitungTotal();
        }
    });
}

// Hitung ulang grand total (opsional, bisa reload juga)
function hitungTotal() {
    // Untuk kesederhanaan, reload halaman setelah update
    // Bisa diganti dengan kalkulasi di frontend jika perlu
}
</script>
@endpush
@extends('customer.layouts.app')

@section('title', 'Checkout - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 80px; background: #f9f5f0; min-height: 100vh; }

.checkout-wrapper {
    max-width: 860px;
    margin: 0 auto;
    padding: 40px 20px 60px;
}

.checkout-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

/* Layout produk: gambar kiri, form kanan */
.produk-row {
    display: flex;
    gap: 24px;
    align-items: flex-start;
}

.produk-img {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 10px;
    flex-shrink: 0;
}

.produk-img-placeholder {
    width: 140px;
    height: 140px;
    border-radius: 10px;
    background: #f5ead8;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.produk-form { flex: 1; }

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}

.form-group { display: flex; flex-direction: column; gap: 6px; }

.form-group label {
    font-size: 14px;
    font-weight: 600;
    color: #3B1A08;
}

.form-group input,
.form-group textarea {
    padding: 10px 14px;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #1A0A00;
    background: #fff;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #C68B5A;
}

.form-group select {
    padding: 10px 14px;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #C68B5A;
    background: #3B1A08;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23C68B5A' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
}
.form-group select:focus {
    outline: none;
    border-color: #C68B5A;
}
.form-group select option {
    background: #3B1A08;
    color: #C68B5A;
}

/* Size dropdown (sama style dengan select rasa) */
.size-select {
    padding: 10px 14px;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #C68B5A;
    background: #3B1A08;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23C68B5A' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
    width: 100%;
}
.size-select:focus { outline: none; border-color: #C68B5A; }
.size-select option { background: #3B1A08; color: #C68B5A; }

/* Kontrol jumlah */
.qty-control {
    display: flex;
    align-items: center;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    overflow: hidden;
}
.qty-control button {
    width: 40px;
    height: 40px;
    background: #3B1A08;
    color: #fff;
    border: none;
    font-size: 20px;
    font-weight: 700;
    cursor: pointer;
    flex-shrink: 0;
}
.qty-control button:hover { background: #5C2D0E; }
.qty-control input {
    flex: 1;
    text-align: center;
    border: none;
    font-size: 15px;
    font-weight: 600;
    color: #1A0A00;
    padding: 8px;
}
.qty-control input:focus { outline: none; }

/* Toggle pengambilan */
.toggle-group {
    display: flex;
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    overflow: hidden;
}
.toggle-btn {
    flex: 1;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    color: #8B6050;
    background: #fff;
    border: none;
    transition: all 0.2s;
}
.toggle-btn.active {
    background: #3B1A08;
    color: #fff;
}

/* Keterangan harga per size */
.size-info {
    font-size: 12px;
    color: #8B6050;
    margin-top: 4px;
    font-style: italic;
}

/* ===== ALAMAT ===== */
.alamat-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    display: none;
}
.alamat-card h2 {
    font-size: 16px;
    font-weight: 700;
    color: #3B1A08;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0e8df;
}
.alamat-item {
    border: 1px solid #e8d5b7;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 10px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    transition: all 0.2s;
}
.alamat-item:hover { border-color: #C68B5A; }
.alamat-item.selected { border-color: #3B1A08; background: #fdf8f3; }
.alamat-item .nama { font-weight: 700; font-size: 13px; color: #3B1A08; }
.alamat-item .detail { font-size: 12px; color: #8B6050; margin-top: 4px; line-height: 1.5; }
.btn-ubah {
    background: #f5ead8;
    color: #3B1A08;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    flex-shrink: 0;
}

/* ===== HARGA ===== */
.harga-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.harga-card h2 {
    font-size: 16px;
    font-weight: 700;
    color: #3B1A08;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0e8df;
}
.harga-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #4A2C10;
    padding: 8px 0;
    border-bottom: 1px solid #f9f5f0;
}
.harga-row:last-child { border-bottom: none; }
.harga-row.total {
    font-weight: 700;
    font-size: 16px;
    color: #1A0A00;
    padding-top: 14px;
}

/* ===== TOMBOL ===== */
.btn-actions {
    display: flex;
    justify-content: space-between;
}
.btn-kembali {
    background: #3B1A08;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}
.btn-kembali:hover { background: #5C2D0E; color: #fff; }
.btn-lanjut {
    background: #3B1A08;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
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
</style>
@endpush

@section('content')
<div class="page-content">
<div class="checkout-wrapper">

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.pembayaran') }}" method="POST">
        @csrf

        {{-- ===== KARTU PRODUK + FORM ===== --}}
        @foreach($cartItems as $item)
        @php
            $prod    = $item->product;
            // Cek kolom gambar: bisa 'gambar' (path barang/) atau 'image' (path products/)
            $imgSrc  = null;
            if (!empty($prod->gambar)) {
                $imgSrc = asset('storage/barang/' . $prod->gambar);
            } elseif (!empty($prod->image)) {
                $imgSrc = asset('storage/' . $prod->image);
            }

            // Harga per ukuran (hanya kalau has_size = true)
            $sizePrices = [];
            if ($prod->has_size) {
                if ($prod->price_s  > 0) $sizePrices['S']  = $prod->price_s;
                if ($prod->price_m  > 0) $sizePrices['M']  = $prod->price_m;
                if ($prod->price_l  > 0) $sizePrices['L']  = $prod->price_l;
                if ($prod->price_xl > 0) $sizePrices['XL'] = $prod->price_xl;
            }

            // Nama produk (support dua kemungkinan kolom)
            $prodName = $prod->nama_barang ?? $prod->name ?? 'Produk';
        @endphp

        <div class="checkout-card">
            <div class="produk-row">
                {{-- Gambar --}}
                @if($imgSrc)
                    <img src="{{ $imgSrc }}" alt="{{ $prodName }}" class="produk-img"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="produk-img-placeholder" style="display:none;">
                        <i class="fas fa-birthday-cake" style="font-size:40px;color:#C68B5A;"></i>
                    </div>
                @else
                    <div class="produk-img-placeholder">
                        <i class="fas fa-birthday-cake" style="font-size:40px;color:#C68B5A;"></i>
                    </div>
                @endif

                {{-- Form --}}
                <div class="produk-form">
                    <p style="font-size:15px;font-weight:700;color:#3B1A08;margin-bottom:14px;">
                        {{ $prodName }}
                    </p>

                    <div class="form-grid">
                        {{-- Rasa --}}
                        <div class="form-group">
                            <label>Rasa</label>
                            <select name="cake_flavor[]">
                                <option value="">Pilih opsi</option>
                                @foreach(['Coklat','Vanila','Stroberi','Pandan','Red Velvet','Matcha','Keju','Tiramisu'] as $rasa)
                                    <option value="{{ $rasa }}"
                                        {{ old('cake_flavor.0', $item->flavor ?? '') == $rasa ? 'selected' : '' }}>
                                        {{ $rasa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah --}}
                        <div class="form-group">
                            <label>Jumlah</label>
                            <div class="qty-control">
                                <button type="button" onclick="ubahQty(this, -1)">−</button>
                                <input type="number" name="quantity[]" class="qty-input"
                                       value="{{ $item->quantity }}" min="1" readonly>
                                <button type="button" onclick="ubahQty(this, 1)">+</button>
                            </div>
                        </div>

                        {{-- Ukuran: dropdown kalau has_size, sembunyi kalau tidak --}}
                        @if($prod->has_size && count($sizePrices) > 0)
                            <div class="form-group">
                                <label>Ukuran</label>
                                <select name="size[]" class="size-select"
                                        data-prices="{{ json_encode($sizePrices) }}"
                                        onchange="updateHarga(this)">
                                    <option value="">Pilih ukuran</option>
                                    @foreach($sizePrices as $label => $harga)
                                        <option value="{{ $label }}"
                                                data-price="{{ $harga }}"
                                            {{ old('size.0', $item->size ?? '') == $label ? 'selected' : '' }}>
                                            {{ $label }} — Rp {{ number_format($harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="size-info">Harga menyesuaikan ukuran yang dipilih</span>
                            </div>
                        @else
                            {{-- Produk tanpa ukuran: kirim size kosong agar controller tidak error --}}
                            <input type="hidden" name="size[]" value="">
                        @endif

                        {{-- Pengambilan --}}
                        <div class="form-group">
                            <label>Pengambilan</label>
                            <div class="toggle-group">
                                <button type="button" class="toggle-btn active" id="btn-pickup-{{ $loop->index }}"
                                        onclick="pilihPengambilan('pickup', {{ $loop->index }})">Pickup</button>
                                <button type="button" class="toggle-btn" id="btn-antar-{{ $loop->index }}"
                                        onclick="pilihPengambilan('antar', {{ $loop->index }})">Antar</button>
                            </div>
                            <input type="hidden" name="delivery_method[]" id="delivery_method_{{ $loop->index }}" value="pickup">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <input type="text" name="notes[]" placeholder="Krimnya jangan terlalu banyak."
                               value="{{ old('notes.0', $item->note ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ===== ALAMAT ===== --}}
        <div class="alamat-card" id="alamat-card">
            <h2>Alamat Pengiriman</h2>
            @if($addresses->count() > 0)
                @foreach($addresses as $addr)
                <div class="alamat-item {{ $loop->first ? 'selected' : '' }}"
                     onclick="pilihAlamat({{ $addr->id }}, this)">
                    <div>
                        <div class="nama">{{ Auth::user()->name }} — {{ $addr->phone }}</div>
                        <div class="detail">{{ $addr->address }}, {{ $addr->kecamatan }}, {{ $addr->kota }}</div>
                    </div>
                    <button type="button" class="btn-ubah">Ubah Alamat</button>
                </div>
                @endforeach
                <input type="hidden" name="address_id" id="address_id" value="{{ $addresses->first()->id }}">
            @else
                <p style="font-size:13px;color:#8B6050;">
                    Belum ada alamat. Jika memilih pengiriman "Antar", kamu harus menambah alamat terlebih dahulu.
                    <a href="{{ route('customer.profil.alamat') }}" style="color:#3B1A08;font-weight:600;text-decoration:underline;">+ Tambah Alamat Sekarang</a>
                </p>
                <input type="hidden" name="address_id" id="address_id" value="">
            @endif
        </div>

        {{-- ===== HARGA ===== --}}
        <div class="harga-card">
            <h2>Harga</h2>
            <div class="harga-row">
                <span>Subtotal</span>
                <span id="subtotal-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="harga-row">
                <span>Biaya Layanan</span>
                <span>Rp 0</span>
            </div>
            <div class="harga-row total">
                <span>Total Pembayaran</span>
                <span id="total-display">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
// ── Qty per item ──────────────────────────────────────────────
function ubahQty(btn, delta) {
    const input = btn.closest('.qty-control').querySelector('.qty-input');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
}

// ── Pilih metode pengambilan per item ────────────────────────
function pilihPengambilan(metode, idx) {
    document.getElementById('delivery_method_' + idx).value = metode;
    if (metode === 'pickup') {
        document.getElementById('btn-pickup-' + idx).classList.add('active');
        document.getElementById('btn-antar-'  + idx).classList.remove('active');
        // Sembunyikan alamat kalau semua item pickup
        const anyAntar = [...document.querySelectorAll('[id^="delivery_method_"]')]
            .some(el => el.value === 'antar');
        if (!anyAntar) document.getElementById('alamat-card').style.display = 'none';
    } else {
        document.getElementById('btn-antar-'  + idx).classList.add('active');
        document.getElementById('btn-pickup-' + idx).classList.remove('active');
        document.getElementById('alamat-card').style.display = 'block';
    }
}

// ── Update harga saat pilih ukuran ───────────────────────────
function updateHarga(selectEl) {
    const selectedOpt = selectEl.options[selectEl.selectedIndex];
    const harga = parseFloat(selectedOpt.dataset.price || 0);

    // Hitung total semua size yang sudah dipilih
    let total = 0;
    document.querySelectorAll('.size-select').forEach(sel => {
        const opt = sel.options[sel.selectedIndex];
        if (opt && opt.dataset.price) {
            total += parseFloat(opt.dataset.price);
        }
    });

    // Produk tanpa size: ambil base price dari server (dikirim via hidden input kalau ada)
    // Sementara hanya total dari size yang diselect
    if (total > 0) {
        document.getElementById('subtotal-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total-display').textContent    = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// ── Pilih alamat ─────────────────────────────────────────────
function pilihAlamat(id, el) {
    document.querySelectorAll('.alamat-item').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('address_id').value = id;
}
</script>
@endpush
@extends('customer.layouts.app')

@section('title', ($product->nama_barang ?? 'Detail Produk') . ' - Kuesaena')

@push('styles')
<style>
/* ============================================================
   PRODUCT DETAIL PAGE — sesuai desain
============================================================ */
.page-content { padding-top: 76px; }

/* ============================================================
   BACK BUTTON
============================================================ */
.back-section {
    padding: 28px 0 0;
    background: #fff;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    transition: color 0.2s;
}

.back-btn:hover { color: #5C2D0E; }

.back-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: #444;
    transition: all 0.2s;
    flex-shrink: 0;
}

.back-btn:hover .back-circle {
    border-color: #5C2D0E;
    color: #5C2D0E;
    background: #fdf6ee;
}

/* ============================================================
   PRODUCT DETAIL MAIN
============================================================ */
.product-detail-section {
    padding: 24px 0 0;
    background: #fff;
}

.detail-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 48px;
    align-items: flex-start;
    padding-bottom: 36px;
}

/* Gambar produk */
.detail-img-wrap {
    border-radius: 16px;
    overflow: hidden;
    border: 1.5px solid #eee;
    aspect-ratio: 1;
    background: #f9f5f0;
}

.detail-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Copy kanan */
.detail-copy h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 3.5vw, 38px);
    font-weight: 800;
    color: #5C2D0E;
    margin-bottom: 18px;
    line-height: 1.2;
}

.detail-copy .detail-desc {
    font-size: 15px;
    color: #555;
    line-height: 1.85;
}

/* ============================================================
   ACTION BAR
============================================================ */
.action-bar {
    border-top: 1px solid #e8e8e8;
    border-bottom: 1px solid #e8e8e8;
    padding: 18px 0;
    background: #fff;
}

.action-bar-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

/* Favorite */
.fav-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 500;
    color: #444;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    transition: color 0.2s;
    font-family: 'DM Sans', sans-serif;
}

.fav-btn i { font-size: 18px; transition: all 0.2s; }

.fav-btn:hover { color: #e74c3c; }
.fav-btn.active { color: #e74c3c; }
.fav-btn.active i { font-weight: 900; }

/* Separator vertical */
.action-sep {
    width: 1px;
    height: 32px;
    background: #e0e0e0;
}

/* Size selector */
.size-group {
    display: flex;
    align-items: center;
    gap: 0;
    border: 1.5px solid #ccc;
    border-radius: 6px;
    overflow: hidden;
}

.size-btn {
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    color: #555;
    background: #fff;
    border: none;
    cursor: pointer;
    border-right: 1.5px solid #ccc;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
    letter-spacing: 0.3px;
}

.size-btn:last-child { border-right: none; }

.size-btn.active {
    background: #5C2D0E;
    color: #fff;
}

.size-btn:hover:not(.active) {
    background: #f9f5f0;
    color: #5C2D0E;
}

/* Price */
.detail-price {
    font-family: 'DM Sans', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #222;
    letter-spacing: -0.3px;
}

/* Cart icon button */
.cart-action-btn {
    position: relative;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 1.5px solid #ddd;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #444;
    font-size: 18px;
    transition: all 0.25s;
}

.cart-action-btn:hover {
    background: #5C2D0E;
    color: #fff;
    border-color: #5C2D0E;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(92,45,14,0.25);
}

.cart-action-btn .cart-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    width: 18px;
    height: 18px;
    background: #5C2D0E;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
}

/* ============================================================
   POPULAR PRODUCTS SECTION
============================================================ */
.popular-section {
    padding: 72px 0 80px;
    background: #fff;
}

.popular-header {
    text-align: center;
    margin-bottom: 44px;
}

.popular-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #C68B5A;
    margin-bottom: 8px;
    font-family: 'DM Sans', sans-serif;
}

.popular-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 40px);
    font-weight: 800;
    color: #1A0A00;
}

/* Product grid */
.popular-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* Product card (local style) */
.pop-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.07);
    transition: all 0.3s ease;
    cursor: pointer;
}

.pop-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(60,20,0,0.13);
}

.pop-card__img-wrap {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #f9f5f0;
}

.pop-card__img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s ease;
    display: block;
}

.pop-card:hover .pop-card__img-wrap img {
    transform: scale(1.06);
}

/* Badge diskon */
.pop-badge {
    position: absolute;
    top: 12px;
    left: 0;
    background: #D32F2F;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 14px 5px 10px;
    clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%);
    z-index: 2;
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Card body */
.pop-card__body {
    padding: 14px 16px 16px;
}

.pop-card__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
}

.pop-card__name {
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #1A0A00;
    flex: 1;
}

.pop-card__actions {
    display: flex;
    gap: 6px;
}

.pop-action-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1.5px solid #ddd;
    background: transparent;
    color: #888;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.pop-action-btn:hover { background: #5C2D0E; color: #fff; border-color: #5C2D0E; }

.pop-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.pop-price-current {
    font-size: 15px;
    font-weight: 700;
    color: #5C2D0E;
    font-family: 'DM Sans', sans-serif;
}

.pop-price-original {
    font-size: 12px;
    color: #aaa;
    text-decoration: line-through;
}

.pop-po {
    font-size: 12px;
    color: #999;
    margin-bottom: 8px;
}

.pop-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.pop-stars { display: flex; gap: 2px; }
.pop-stars i { font-size: 11px; color: #F59E0B; }

.pop-dots { display: flex; gap: 4px; }
.pop-dot {
    width: 13px; height: 13px;
    border-radius: 50%;
    border: 1.5px solid rgba(0,0,0,0.1);
    cursor: pointer;
}
.pop-dot.cream { background: #C8A882; }
.pop-dot.red   { background: #C0392B; }
.pop-dot.green { background: #27AE60; }

/* View All */
.pop-view-all {
    text-align: center;
    margin-top: 36px;
}

.pop-view-all a {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #444;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    text-decoration: none;
    transition: gap 0.2s, color 0.2s;
    border-bottom: 1.5px solid #ccc;
    padding-bottom: 2px;
}

.pop-view-all a:hover {
    color: #5C2D0E;
    gap: 18px;
    border-bottom-color: #5C2D0E;
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 900px) {
    .detail-grid { grid-template-columns: 220px 1fr; gap: 28px; }
}

@media (max-width: 680px) {
    .detail-grid { grid-template-columns: 1fr; }
    .detail-img-wrap { max-width: 320px; margin: 0 auto; }
    .action-bar-inner { gap: 20px; justify-content: flex-start; }
    .popular-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
}

@media (max-width: 480px) {
    .popular-grid { grid-template-columns: 1fr; }
    .detail-price { font-size: 18px; }
    .action-sep { display: none; }
}
</style>
@endpush

@section('content')
<div class="page-content">

    {{-- ====================================================
         BACK BUTTON
    ==================================================== --}}
    <div class="back-section">
        <div class="container">
            <a href="{{ url()->previous() }}" class="back-btn">
                <span class="back-circle"><i class="fas fa-chevron-left"></i></span>
                Kembali
            </a>
        </div>
    </div>

    {{-- ====================================================
         PRODUCT DETAIL
    ==================================================== --}}
    <section class="product-detail-section">
        <div class="container">
            <div class="detail-grid">

                {{-- Gambar --}}
                <div class="detail-img-wrap">
                    @php
                        $imgSrc = ($product->gambar ?? null)
                            ? asset('storage/barang/' . $product->gambar)
                            : 'https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=600&q=80';
                    @endphp
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->nama_barang ?? 'Produk' }}"
                         onerror="this.src='https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=600&q=80'">
                </div>

                {{-- Info --}}
                <div class="detail-copy">
                    <h1>{{ $product->nama_barang ?? $product->name }}</h1>
                    <p class="detail-desc">
                        {{ $product->deskripsi ?? $product->description ?? 'Produk premium berkualitas tinggi dari Kuesaena, dibuat dengan bahan pilihan terbaik untuk momen spesialmu.' }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ====================================================
             ACTION BAR
        ==================================================== --}}
        <div class="action-bar">
            <div class="container">
                <div class="action-bar-inner">

                    {{-- Favorite --}}
                    <button class="fav-btn" id="fav-btn" type="button">
                        <i class="far fa-heart"></i>
                        Favorite
                    </button>

                    <div class="action-sep"></div>

                    {{-- Size Selector --}}
                    <div class="size-group" id="size-group">
                        <button class="size-btn" data-size="S" type="button">S</button>
                        <button class="size-btn active" data-size="M" type="button">M</button>
                        <button class="size-btn" data-size="L" type="button">L</button>
                    </div>

                    <div class="action-sep"></div>

                    {{-- Price --}}
                    <span class="detail-price" id="detail-price">
                        Rp. {{ number_format($product->harga_jual ?? 0, 0, ',', '.') }}
                    </span>

                    {{-- Cart --}}
                    <button class="cart-action-btn" id="add-cart-btn" type="button"
                            data-id="{{ $product->id }}"
                            title="Tambah ke Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cart-count">0</span>
                    </button>

                </div>
            </div>
        </div>
    </section>

    {{-- ====================================================
         POPULAR PRODUCTS
    ==================================================== --}}
    <section class="popular-section">
        <div class="container">
            <div class="popular-header">
                <p class="popular-label">NEW PRODUCTS</p>
                <h2 class="popular-title">Popular Products</h2>
            </div>

            <div class="popular-grid">
                @forelse($popularProducts as $pop)
                    @php
                        $popImg     = ($pop->gambar ?? null)
                            ? asset('storage/barang/' . $pop->gambar)
                            : 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80';
                        $popPrice   = $pop->harga_jual ?? 0;
                        $popOri     = $pop->harga_modal ?? null;
                        $popName    = $pop->nama_barang ?? $pop->name ?? 'Produk';
                        $popDisc    = $popOri && $popOri > $popPrice
                            ? round((($popOri - $popPrice) / $popOri) * 100)
                            : 0;
                    @endphp

                    <a href="{{ route('customer.product.show', $pop->id) }}"
                       class="pop-card"
                       style="text-decoration:none;color:inherit;">

                        <div class="pop-card__img-wrap">
                            @if($popDisc > 0)
                                <div class="pop-badge">
                                    <i class="fas fa-tag"></i>
                                    Get up to {{ $popDisc }}% off Today Only!
                                </div>
                            @else
                                <div class="pop-badge">
                                    <i class="fas fa-tag"></i>
                                    Get up to 10% off Today Only!
                                </div>
                            @endif
                            <img src="{{ $popImg }}"
                                 alt="{{ $popName }}"
                                 onerror="this.src='https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80'">
                        </div>

                        <div class="pop-card__body">
                            <div class="pop-card__top">
                                <span class="pop-card__name">{{ $popName }}</span>
                                <div class="pop-card__actions">
                                    <button class="pop-action-btn wishlist-pop" type="button"
                                            onclick="event.preventDefault()">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="pop-action-btn" type="button"
                                            onclick="event.preventDefault()">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="pop-price-row">
                                <span class="pop-price-current">Rp {{ number_format($popPrice, 0, ',', '.') }}</span>
                                @if($popOri)
                                    <span class="pop-price-original">Rp {{ number_format($popOri, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <p class="pop-po">PO 5 hari</p>
                            <div class="pop-footer">
                                <div class="pop-stars">
                                    @for($s=0;$s<5;$s++)<i class="fas fa-star"></i>@endfor
                                </div>
                                <div class="pop-dots">
                                    <span class="pop-dot cream"></span>
                                    <span class="pop-dot red"></span>
                                    <span class="pop-dot green"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Fallback dummy jika belum ada produk --}}
                    @php
                        $dummyProducts = [
                            ['name' => 'Birthday Double Cake', 'price' => 310000, 'ori' => 365000,
                             'img' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80'],
                            ['name' => 'Strawberry Cake',      'price' => 90000,  'ori' => 113000,
                             'img' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400&q=80'],
                            ['name' => 'Vintages Cake',        'price' => 194000, 'ori' => 220000,
                             'img' => 'https://images.unsplash.com/photo-1571506165871-ee72a35bc9d4?w=400&q=80'],
                            ['name' => 'Lion Cake',            'price' => 180000, 'ori' => 195000,
                             'img' => 'https://images.unsplash.com/photo-1535141192574-5d4897c12636?w=400&q=80'],
                            ['name' => 'Kuromi Cupcake',       'price' => 134999, 'ori' => 160000,
                             'img' => 'https://images.unsplash.com/photo-1587248720327-8eb72564be1e?w=400&q=80'],
                            ['name' => 'Bento Cake',           'price' => 35000,  'ori' => 50000,
                             'img' => 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80'],
                        ];
                    @endphp
                    @foreach($dummyProducts as $dp)
                        @php
                            $dpDisc = round((($dp['ori'] - $dp['price']) / $dp['ori']) * 100);
                        @endphp
                        <div class="pop-card">
                            <div class="pop-card__img-wrap">
                                <div class="pop-badge">
                                    <i class="fas fa-tag"></i>
                                    Get up to {{ $dpDisc }}% off Today Only!
                                </div>
                                <img src="{{ $dp['img'] }}" alt="{{ $dp['name'] }}">
                            </div>
                            <div class="pop-card__body">
                                <div class="pop-card__top">
                                    <span class="pop-card__name">{{ $dp['name'] }}</span>
                                    <div class="pop-card__actions">
                                        <button class="pop-action-btn" type="button"><i class="far fa-heart"></i></button>
                                        <button class="pop-action-btn" type="button"><i class="fas fa-shopping-cart"></i></button>
                                    </div>
                                </div>
                                <div class="pop-price-row">
                                    <span class="pop-price-current">Rp {{ number_format($dp['price'], 0, ',', '.') }}</span>
                                    <span class="pop-price-original">Rp {{ number_format($dp['ori'], 0, ',', '.') }}</span>
                                </div>
                                <p class="pop-po">PO 5 hari</p>
                                <div class="pop-footer">
                                    <div class="pop-stars">@for($s=0;$s<5;$s++)<i class="fas fa-star"></i>@endfor</div>
                                    <div class="pop-dots">
                                        <span class="pop-dot cream"></span>
                                        <span class="pop-dot red"></span>
                                        <span class="pop-dot green"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>

            <div class="pop-view-all">
                <a href="{{ route('customer.menu') }}">
                    VIEW ALL <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>{{-- end page-content --}}
@endsection

@push('scripts')
<script>
    // ── Favorite toggle ──────────────────────────────────
    const favBtn = document.getElementById('fav-btn');
    if (favBtn) {
        favBtn.addEventListener('click', () => {
            favBtn.classList.toggle('active');
            const icon = favBtn.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
        });
    }

    // ── Size selector ────────────────────────────────────
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            sizeBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // ── Add to cart ──────────────────────────────────────
    const cartBtn   = document.getElementById('add-cart-btn');
    const cartCount = document.getElementById('cart-count');
    let count = 0;

    if (cartBtn) {
        cartBtn.addEventListener('click', () => {
            count++;
            cartCount.textContent = count;

            // visual feedback
            cartBtn.style.background  = '#5C2D0E';
            cartBtn.style.color       = '#fff';
            cartBtn.style.borderColor = '#5C2D0E';
            cartBtn.style.transform   = 'scale(1.15)';
            setTimeout(() => {
                cartBtn.style.transform = '';
            }, 200);
        });
    }

    // ── Wishlist on popular cards ────────────────────────
    document.querySelectorAll('.wishlist-pop').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
        });
    });
</script>
@endpush

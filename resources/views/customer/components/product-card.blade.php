{{--<img src="{{ $imgUrl }}"
     alt="{{ $productName }}"
     loading="lazy"
     onerror="this.src='https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80'"
     style="width:100%;height:100%;object-fit:cover;">

    Expected $product fields (model Barang):
        - id
        - nama_barang (or name)
        - harga_jual
        - harga_modal  (optional, used as "original price")
        - gambar       (image filename stored in storage/app/public/barang/ or similar)
        - kategori     (relation to Kategori)
        - stok
--}}

@php
    $productName  = $product->name ?? 'Produk';
    $sellPrice    = $product->price ?? 0;
    $oriPrice     = $product->hpp  ?? null;
    $image        = $product->image ?? null;
    $stock        = $product->stock ?? 0;
    $productId    = $product->id;

    // Discount badge: tampil jika ada harga modal lebih tinggi dari harga jual
    $hasDiscount = $oriPrice && $oriPrice > $sellPrice;
    $discountPct = $hasDiscount
        ? round((($oriPrice - $sellPrice) / $oriPrice) * 100)
        : 0;

    // Image URL
   $imgUrl = $image
    ? asset('storage/' . $image)
    : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80';
@endphp
<div class="product-card">
    {{-- Image Container --}}
    <div class="product-card__img-wrap">
        @if($hasDiscount)
            <div class="product-card__badge">
                <i class="fas fa-tag"></i>
                Get up to {{ $discountPct }}% off Today Only!
            </div>
        @endif

        <img src="{{ $imgUrl }}"
             alt="{{ $productName }}"
             loading="lazy"
             onerror="this.src='https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80'">

        {{-- Overlay Actions --}}
        <div class="product-card__overlay">
            <a href="#" class="product-quick-view" title="Lihat Detail">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div class="product-card__body">
        <div class="product-card__top">
            <h3 class="product-card__name">{{ $productName }}</h3>
            <div class="product-card__actions">
                
		{{-- Tombol Wishlist (Love) --}}
		    <button class="prod-action-btn wishlist-btn" title="Wishlist" 
		            data-id="{{ $product->id }}"
		            onclick="toggleWishlist({{ $product->id }}, this)">
		        <i class="far fa-heart"></i>
		    </button>
		    
		    {{-- Tombol Favorite/Like (Jempol) --}}
		    <button class="prod-action-btn like-btn" title="Suka" 
		            data-id="{{ $product->id }}"
		            onclick="toggleLike({{ $product->id }}, this)">
		        <i class="far fa-thumbs-up"></i>
		        <span class="like-count" style="font-size:10px; margin-left:3px;">{{ $product->likes()->count() }}</span>
		    </button>

                <button class="prod-action-btn cart-btn" title="Tambah ke Keranjang" data-id="{{ $productId }}">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </div>
        </div>

        {{-- Price --}}
        <div class="product-card__price-row">
            <span class="price-current">Rp {{ number_format($sellPrice, 0, ',', '.') }}</span>
            @if($hasDiscount)
                <span class="price-original">Rp {{ number_format($oriPrice, 0, ',', '.') }}</span>
            @endif
        </div>

        {{-- PO / Stock Info --}}
        <p class="product-card__po">
            @if($stock > 0)
                <i class="fas fa-check-circle" style="color:#27ae60"></i> Stok tersedia
            @else
                <i class="fas fa-clock" style="color:#e67e22"></i> PO 5 hari
            @endif
        </p>

        {{-- Rating & Color Dots --}}
        <div class="product-card__footer">
            <div class="product-card__stars">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star"></i>
                @endfor
            </div>
            <div class="product-card__dots">
                <span class="dot dot--cream"></span>
                <span class="dot dot--red"></span>
                <span class="dot dot--green"></span>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== PRODUCT CARD ===== */
.product-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(91,45,14,0.06);
    position: relative;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
    border-color: rgba(91,45,14,0.12);
}

/* Image */
.product-card__img-wrap {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: var(--cream-light);
}

.product-card__img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-card__img-wrap img {
    transform: scale(1.06);
}

/* Discount Badge */
.product-card__badge {
    position: absolute;
    top: 12px;
    left: 0;
    background: #D32F2F;
    color: white;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 14px 5px 10px;
    clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%);
    z-index: 2;
    max-width: 85%;
    line-height: 1.3;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Overlay */
.product-card__overlay {
    position: absolute;
    inset: 0;
    background: rgba(59,26,8,0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
    z-index: 1;
}

.product-card:hover .product-card__overlay {
    background: rgba(59,26,8,0.18);
}

.product-quick-view {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--white);
    color: var(--brown-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.product-card:hover .product-quick-view {
    opacity: 1;
    transform: scale(1);
}

/* Body */
.product-card__body {
    padding: 16px 18px 18px;
}

.product-card__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 8px;
}

.product-card__name {
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    line-height: 1.3;
    flex: 1;
}

.product-card__actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.prod-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid var(--cream-dark);
    background: transparent;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.25s ease;
}

.prod-action-btn:hover,
.prod-action-btn.active {
    background: var(--brown-dark);
    color: var(--white);
    border-color: var(--brown-dark);
}

.wishlist-btn.active i { class: fas; }

/* Price */
.product-card__price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.price-current {
    font-family: 'DM Sans', sans-serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--brown-dark);
}

.price-original {
    font-size: 13px;
    color: var(--text-muted);
    text-decoration: line-through;
}

.product-card__po {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Footer */
.product-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.product-card__stars {
    display: flex;
    gap: 2px;
}

.product-card__stars i {
    font-size: 12px;
    color: #F59E0B;
}

.product-card__dots {
    display: flex;
    gap: 5px;
}

.dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,0.1);
    cursor: pointer;
    transition: transform 0.2s;
}

.dot:hover { transform: scale(1.2); }

.dot--cream  { background: #C8A882; }
.dot--red    { background: #C0392B; }
.dot--green  { background: #27AE60; }
</style>

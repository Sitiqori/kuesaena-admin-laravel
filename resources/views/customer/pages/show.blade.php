@extends('customer.layouts.app')

@section('title', ($product->name ?? 'Detail Produk') . ' - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 76px; }

.back-section { padding: 28px 0 0; background: #fff; }

.back-btn {
    display: inline-flex; align-items: center; gap: 10px;
    font-size: 15px; font-weight: 600; color: #333;
    text-decoration: none; transition: color 0.2s;
}
.back-btn:hover { color: #5C2D0E; }

.back-circle {
    width: 32px; height: 32px; border-radius: 50%;
    border: 1.5px solid #ccc; display: flex;
    align-items: center; justify-content: center;
    font-size: 13px; color: #444; transition: all 0.2s; flex-shrink: 0;
}
.back-btn:hover .back-circle { border-color: #5C2D0E; color: #5C2D0E; background: #fdf6ee; }

.product-detail-section { padding: 24px 0 0; background: #fff; }

.detail-grid {
    display: grid; grid-template-columns: 280px 1fr;
    gap: 48px; align-items: flex-start; padding-bottom: 36px;
}

.detail-img-wrap {
    border-radius: 16px; overflow: hidden;
    border: 1.5px solid #eee; aspect-ratio: 1; background: #f9f5f0;
}
.detail-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }

.detail-copy h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 3.5vw, 38px); font-weight: 800;
    color: #5C2D0E; margin-bottom: 18px; line-height: 1.2;
}
.detail-copy .detail-desc { font-size: 15px; color: #555; line-height: 1.85; }

.action-bar {
    border-top: 1px solid #e8e8e8; border-bottom: 1px solid #e8e8e8;
    padding: 18px 0; background: #fff;
}
.action-bar-inner {
    display: flex; align-items: center; justify-content: center;
    gap: 40px; flex-wrap: wrap;
}

.fav-btn {
    display: flex; align-items: center; gap: 8px;
    font-size: 15px; font-weight: 500; color: #444;
    cursor: pointer; background: none; border: none; padding: 0;
    transition: color 0.2s; font-family: 'DM Sans', sans-serif;
}
.fav-btn i { font-size: 18px; transition: all 0.2s; }
.fav-btn:hover { color: #e74c3c; }
.fav-btn.active { color: #e74c3c; }
.fav-btn.active i { font-weight: 900; }

.action-sep { width: 1px; height: 32px; background: #e0e0e0; }

.size-group {
    display: flex; align-items: center; gap: 0;
    border: 1.5px solid #ccc; border-radius: 6px; overflow: hidden;
}
.size-btn {
    padding: 8px 16px; font-size: 14px; font-weight: 600;
    color: #555; background: #fff; border: none; cursor: pointer;
    border-right: 1.5px solid #ccc; transition: all 0.2s;
    font-family: 'DM Sans', sans-serif; letter-spacing: 0.3px;
}
.size-btn:last-child { border-right: none; }
.size-btn.active { background: #5C2D0E; color: #fff; }
.size-btn:hover:not(.active) { background: #f9f5f0; color: #5C2D0E; }

.detail-price {
    font-family: 'DM Sans', sans-serif; font-size: 22px;
    font-weight: 700; color: #222; letter-spacing: -0.3px;
}

.cart-action-btn {
    position: relative; width: 46px; height: 46px; border-radius: 50%;
    border: 1.5px solid #ddd; background: #fff; display: flex;
    align-items: center; justify-content: center; cursor: pointer;
    color: #444; font-size: 18px; transition: all 0.25s;
}
.cart-action-btn:hover {
    background: #5C2D0E; color: #fff; border-color: #5C2D0E;
    transform: translateY(-2px); box-shadow: 0 6px 18px rgba(92,45,14,0.25);
}

.popular-section { padding: 72px 0 80px; background: #fff; }
.popular-header { text-align: center; margin-bottom: 44px; }
.popular-label {
    font-size: 11px; font-weight: 700; letter-spacing: 2.5px;
    text-transform: uppercase; color: #C68B5A; margin-bottom: 8px;
    font-family: 'DM Sans', sans-serif;
}
.popular-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 40px); font-weight: 800; color: #1A0A00;
}
.popular-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }

.pop-card {
    background: #fff; border-radius: 16px; overflow: hidden;
    border: 1px solid rgba(0,0,0,0.07); transition: all 0.3s ease; cursor: pointer;
}
.pop-card:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(60,20,0,0.13); }
.pop-card__img-wrap { position: relative; aspect-ratio: 4/3; overflow: hidden; background: #f9f5f0; }
.pop-card__img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.45s ease; display: block; }
.pop-card:hover .pop-card__img-wrap img { transform: scale(1.06); }
.pop-badge {
    position: absolute; top: 12px; left: 0; background: #D32F2F; color: #fff;
    font-size: 11px; font-weight: 600; padding: 5px 14px 5px 10px;
    clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%);
    z-index: 2; line-height: 1.3; display: flex; align-items: center; gap: 4px;
}
.pop-card__body { padding: 14px 16px 16px; }
.pop-card__top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
.pop-card__name { font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600; color: #1A0A00; flex: 1; }
.pop-card__actions { display: flex; gap: 6px; }
.pop-action-btn {
    width: 30px; height: 30px; border-radius: 50%; border: 1.5px solid #ddd;
    background: transparent; color: #888; display: flex; align-items: center;
    justify-content: center; font-size: 12px; cursor: pointer; transition: all 0.2s;
}
.pop-action-btn:hover { background: #5C2D0E; color: #fff; border-color: #5C2D0E; }
.pop-price-row { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
.pop-price-current { font-size: 15px; font-weight: 700; color: #5C2D0E; font-family: 'DM Sans', sans-serif; }
.pop-po { font-size: 12px; color: #999; margin-bottom: 8px; }
.pop-footer { display: flex; align-items: center; justify-content: space-between; }
.pop-stars { display: flex; gap: 2px; }
.pop-stars i { font-size: 11px; color: #F59E0B; }
.pop-view-all { text-align: center; margin-top: 36px; }
.pop-view-all a {
    display: inline-flex; align-items: center; gap: 10px; font-size: 13px;
    font-weight: 700; color: #444; letter-spacing: 1.5px; text-transform: uppercase;
    text-decoration: none; transition: gap 0.2s, color 0.2s;
    border-bottom: 1.5px solid #ccc; padding-bottom: 2px;
}
.pop-view-all a:hover { color: #5C2D0E; gap: 18px; border-bottom-color: #5C2D0E; }

/* Tombol Keranjang di Detail Produk */
.cart-toggle-btn {
    background: transparent;
    border: 1px solid #ddd;
    padding: 10px 20px;
    border-radius: 40px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.cart-toggle-btn i {
    font-size: 16px;
}

.cart-toggle-btn.active {
    background: #e67e22;
    border-color: #e67e22;
    color: white;
}

.cart-toggle-btn.active i {
    color: white;
}

.cart-toggle-btn:not(.active) {
    background: white;
    color: #333;
}

.cart-toggle-btn:not(.active) i {
    color: #888;
}

/* Untuk popular products */
.pop-action-btn.cart-toggle-btn {
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 11px;
}

.pop-action-btn.cart-toggle-btn i {
    font-size: 11px;
}

@media (max-width: 900px) { .detail-grid { grid-template-columns: 220px 1fr; gap: 28px; } }
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

/* Tombol Keranjang - Lingkaran hanya muncul saat aktif */
/* Tombol Keranjang di Detail Produk */
.cart-toggle-btn {
    background: transparent;
    border: 1.5px solid #ddd;
    border-radius: 40px;
    padding: 10px 20px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    font-family: 'DM Sans', sans-serif;
}

.cart-toggle-btn i {
    font-size: 16px;
}

/* State belum aktif (border saja, tanpa lingkaran) */
.cart-toggle-btn:not(.active) {
    background: white;
    color: #333;
}

.cart-toggle-btn:not(.active) i {
    font-weight: 400;
    color: #888;
}

/* State aktif (sudah di keranjang) - dengan border warna */
.cart-toggle-btn.active {
    background: transparent;
    border: 1.5px solid #e67e22;
    color: #e67e22;
}

.cart-toggle-btn.active i {
    font-weight: 900;
    color: #e67e22;
}

/* Efek klik */
.cart-clicked {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}
</style>
@endpush

@section('content')
<div class="page-content">

    <div class="back-section">
        <div class="container">
            <a href="{{ url()->previous() }}" class="back-btn">
                <span class="back-circle"><i class="fas fa-chevron-left"></i></span>
                Kembali
            </a>
        </div>
    </div>

    <section class="product-detail-section">
        <div class="container">
            <div class="detail-grid">

                <div class="detail-img-wrap">
                    @php
                        $imgSrc = $product->image
                            ? asset('storage/' . $product->image)
                            : 'https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=600&q=80';
                    @endphp
                    <img src="{{ $imgSrc }}" alt="{{ $product->name }}"
                         onerror="this.src='https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=600&q=80'">
                </div>

                <div class="detail-copy">
                    <h1>{{ $product->name }}</h1>
                    <p class="detail-desc">
                        {{ $product->description ?? 'Produk premium berkualitas tinggi dari Kuesaena, dibuat dengan bahan pilihan terbaik untuk momen spesialmu.' }}
                    </p>
                </div>

            </div>
        </div>

        <div class="action-bar">
            <div class="container">
                

            <div class="action-bar-inner">

    {{-- WISHLIST BUTTON --}}
    @php
        $isWishlisted = Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists();
    @endphp
    <button class="fav-btn" type="button" onclick="toggleWishlist({{ $product->id }}, this.querySelector('i'))">
        <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart" 
           style="color: {{ $isWishlisted ? '#e74c3c' : '#888' }};"></i> 
        Wishlist
    </button>

    <div class="action-sep"></div>

    {{-- LIKE BUTTON --}}
    @php
        $isLiked = Auth::check() && Auth::user()->productLikes()->where('product_id', $product->id)->exists();
    @endphp
    <button class="fav-btn" type="button" onclick="toggleLike({{ $product->id }}, this.querySelector('i'))" style="gap: 4px;">
        <i class="{{ $isLiked ? 'fas' : 'far' }} fa-thumbs-up" 
           style="color: {{ $isLiked ? '#27ae60' : '#888' }};"></i> 
        Like
        <span class="like-count-{{ $product->id }}" style="font-size: 13px; margin-left: 2px;">({{ $product->likes()->count() }})</span>
    </button>

    <div class="action-sep"></div>

    {{-- Size selector — hanya muncul kalau has_size = true --}}
    @if($product->has_size)
    <div class="size-group" id="size-group">
        @if($product->price_s)
        <button class="size-btn" data-size="S" data-price="{{ $product->price_s }}" type="button">S</button>
        @endif
        @if($product->price_m)
        <button class="size-btn" data-size="M" data-price="{{ $product->price_m }}" type="button">M</button>
        @endif
        @if($product->price_l)
        <button class="size-btn" data-size="L" data-price="{{ $product->price_l }}" type="button">L</button>
        @endif
        @if($product->price_xl)
        <button class="size-btn" data-size="XL" data-price="{{ $product->price_xl }}" type="button">XL</button>
        @endif
    </div>
    <div class="action-sep"></div>
    @endif

    <span class="detail-price" id="detail-price">
        @php
            $defaultPrice = $product->has_size
                ? ($product->price_s ?? $product->price_m ?? $product->price_l ?? $product->price_xl ?? $product->price)
                : $product->price;
        @endphp
        Rp {{ number_format($defaultPrice, 0, ',', '.') }}
    </span>

    @php
    $isInCart = Auth::check() && Auth::user()->carts()->where('product_id', $product->id)->exists();
@endphp


<button class="cart-toggle-btn {{ $isInCart ? 'active' : '' }}" 
        onclick="toggleCart(this, {{ $product->id }})">
    <i class="{{ $isInCart ? 'fas' : 'far' }} fa-shopping-cart"></i>
    <span class="cart-text">{{ $isInCart ? 'Hapus dari Keranjang' : 'Tambah ke Keranjang' }}</span>
</button>
</div>


            </div>
        </div>
    </section>

    <section class="popular-section">
        <div class="container">
            <div class="popular-header">
                <p class="popular-label">NEW PRODUCTS</p>
                <h2 class="popular-title">Popular Products</h2>
            </div>

            
            <div class="popular-grid">
    @push('scripts')
<script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // ============================================================
    // TOGGLE CART (KERANJANG)
    // ============================================================
    window.toggleCart = function(button, productId) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        let icon = button.querySelector('i');
        let textSpan = button.querySelector('.cart-text');
        let wasInCart = button.classList.contains('active');
        
        if (wasInCart) {
            button.classList.remove('active');
            icon.classList.remove('fas');
            icon.classList.add('far');
            if (textSpan) textSpan.textContent = 'Tambah ke Keranjang';
        } else {
            button.classList.add('active');
            icon.classList.remove('far');
            icon.classList.add('fas');
            if (textSpan) textSpan.textContent = 'Hapus dari Keranjang';
        }
        
        fetch('{{ route("keranjang.toggle") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                if (wasInCart) {
                    button.classList.add('active');
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    if (textSpan) textSpan.textContent = 'Hapus dari Keranjang';
                } else {
                    button.classList.remove('active');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    if (textSpan) textSpan.textContent = 'Tambah ke Keranjang';
                }
            } else {
                let cartBadge = document.querySelector('.action-badge');
                if (cartBadge) {
                    cartBadge.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
                    cartBadge.style.display = data.cart_count > 0 ? 'flex' : 'none';
                }
            }
        })
        .catch(err => console.error('Cart error:', err));
    };

    // ============================================================
    // TOGGLE WISHLIST
    // ============================================================
    window.toggleWishlist = function(productId, element) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        if (element.classList.contains('fas')) {
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
        } else {
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#e74c3c';
        }
        
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        }).catch(err => console.error('Wishlist error:', err));
    };

    // ============================================================
    // TOGGLE LIKE
    // ============================================================
    window.toggleLike = function(productId, element) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        let countSpan = document.querySelector(`.like-count-${productId}`);
        let currentCount = parseInt(countSpan?.innerText?.replace(/[()]/g, '') || 0);
        
        if (element.classList.contains('fas')) {
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
            if (countSpan) countSpan.innerText = `(${currentCount - 1})`;
        } else {
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#27ae60';
            if (countSpan) countSpan.innerText = `(${currentCount + 1})`;
        }
        
        fetch(`/product/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        }).catch(err => console.error('Like error:', err));
    };

    // ============================================================
    // POPULAR PRODUCTS - WISHLIST
    // ============================================================
    window.toggleWishlistPop = function(productId, element) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        if (element.classList.contains('fas')) {
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
        } else {
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#e74c3c';
        }
        
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        }).catch(err => console.error('Wishlist pop error:', err));
    };

    // ============================================================
    // POPULAR PRODUCTS - LIKE
    // ============================================================
    window.toggleLikePop = function(productId, button) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        const icon = button.querySelector('i');
        const countSpan = document.querySelector(`.pop-like-count-${productId}`);
        let currentCount = parseInt(countSpan?.innerText?.replace(/[()]/g, '') || 0);
        
        if (icon.classList.contains('fas')) {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '#888';
            if (countSpan) countSpan.innerText = `(${currentCount - 1})`;
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#27ae60';
            if (countSpan) countSpan.innerText = `(${currentCount + 1})`;
        }
        
        fetch(`/product/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        }).catch(err => console.error('Like pop error:', err));
    };

    // ============================================================
    // SIZE SELECTOR
    // ============================================================
    const hasSize = {{ $product->has_size ? 'true' : 'false' }};
    const basePrice = {{ $defaultPrice }};

    let selectedSize = null;
    let selectedPrice = basePrice;

    if (hasSize) {
        const firstBtn = document.querySelector('.size-btn');
        if (firstBtn) {
            firstBtn.classList.add('active');
            selectedSize = firstBtn.dataset.size;
            selectedPrice = parseFloat(firstBtn.dataset.price);
        }
    }

    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedSize = btn.dataset.size;
            selectedPrice = parseFloat(btn.dataset.price);
            document.getElementById('detail-price').textContent = 'Rp ' + selectedPrice.toLocaleString('id-ID');
        });
    });
</script>
@endpush
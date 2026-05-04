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

    <button class="cart-action-btn" id="add-cart-btn" type="button" title="Tambah ke Keranjang">
        <i class="fas fa-shopping-cart"></i>
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
    @forelse($popularProducts as $pop)
        @php
            $popImg   = $pop->image ? asset('storage/' . $pop->image) : 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80';
            $popPrice = $pop->price ?? 0;
            $popName  = $pop->name ?? 'Produk';
            $isWishlistedPop = Auth::check() && Auth::user()->wishlists()->where('product_id', $pop->id)->exists();
            $isLikedPop = Auth::check() && Auth::user()->productLikes()->where('product_id', $pop->id)->exists();
        @endphp
        <div class="pop-card" style="text-decoration:none;color:inherit; cursor: pointer;">
            <a href="{{ route('customer.product.show', $pop->id) }}" style="text-decoration:none;color:inherit;">
                <div class="pop-card__img-wrap">
                    <div class="pop-badge"><i class="fas fa-tag"></i> Get up to 10% off Today Only!</div>
                    <img src="{{ $popImg }}" alt="{{ $popName }}"
                         onerror="this.src='https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80'">
                </div>
                <div class="pop-card__body">
                    <div class="pop-card__top">
                        <span class="pop-card__name">{{ $popName }}</span>
                        <div class="pop-card__actions">
                            <!-- Wishlist Button -->
                            <button class="pop-action-btn" type="button" 
                                    onclick="event.stopPropagation(); toggleWishlistPop({{ $pop->id }}, this.querySelector('i'))">
                                <i class="{{ $isWishlistedPop ? 'fas' : 'far' }} fa-heart" 
                                   style="color: {{ $isWishlistedPop ? '#e74c3c' : '#888' }}; font-size: 12px;"></i>
                            </button>
                            
                            <!-- Like Button -->
                            <button class="pop-action-btn" type="button" 
                                    onclick="event.stopPropagation(); toggleLikePop({{ $pop->id }}, this)">
                                <i class="{{ $isLikedPop ? 'fas' : 'far' }} fa-thumbs-up" 
                                   style="color: {{ $isLikedPop ? '#27ae60' : '#888' }}; font-size: 12px;"></i>
                                <span class="pop-like-count-{{ $pop->id }}" style="font-size: 9px; margin-left: 2px;">({{ $pop->likes()->count() }})</span>
                            </button>
                            
                            <!-- Cart Button -->
                            <button class="pop-action-btn" type="button" 
                                    onclick="event.stopPropagation(); tambahKeKeranjangPop({{ $pop->id }})">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="pop-price-row">
                        <span class="pop-price-current">Rp {{ number_format($popPrice, 0, ',', '.') }}</span>
                    </div>
                    <p class="pop-po">PO 5 hari</p>
                    <div class="pop-footer">
                        <div class="pop-stars">@for($s=0;$s<5;$s++)<i class="fas fa-star"></i>@endfor</div>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <p style="color:#999; grid-column:1/-1; text-align:center;">Belum ada produk lain.</p>
    @endforelse
</div>


            <div class="pop-view-all">
                <a href="{{ route('customer.menu') }}">VIEW ALL <i class="fas fa-long-arrow-alt-right"></i></a>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    const productId   = {{ $product->id }};
    const hasSize     = {{ $product->has_size ? 'true' : 'false' }};
    const basePrice   = {{ $defaultPrice }};

    let selectedSize  = null;
    let selectedPrice = basePrice;

    // Set default ke size pertama yang tersedia
    if (hasSize) {
        const firstBtn = document.querySelector('.size-btn');
        if (firstBtn) {
            firstBtn.classList.add('active');
            selectedSize  = firstBtn.dataset.size;
            selectedPrice = parseFloat(firstBtn.dataset.price);
        }
    }

    // Klik size
    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedSize  = btn.dataset.size;
            selectedPrice = parseFloat(btn.dataset.price);
            document.getElementById('detail-price').textContent =
                'Rp ' + selectedPrice.toLocaleString('id-ID');
        });
    });

    // ✅ WISHLIST - LANGSUNG BERUBAH TANPA REFRESH
    window.toggleWishlist = function(productId, element) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        // Langsung ubah warna
        if (element.classList.contains('fas')) {
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
        } else {
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#e74c3c';
        }
        
        // Kirim ke server (background)
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        })
        .catch(err => console.error('Wishlist error:', err));
    };

    // ✅ LIKE - LANGSUNG BERUBAH WARNA & COUNT TANPA REFRESH
    window.toggleLike = function(productId, element) {
        event.stopPropagation();
        
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        // Ambil elemen count
        let countSpan = document.querySelector(`.like-count-${productId}`);
        let currentCount = parseInt(countSpan?.innerText?.replace(/[()]/g, '') || 0);
        
        // Langsung ubah warna & count
        if (element.classList.contains('fas')) {
            // Sudah like → jadi unlike
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
            if (countSpan) countSpan.innerText = `(${currentCount - 1})`;
        } else {
            // Belum like → jadi like
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#27ae60';
            if (countSpan) countSpan.innerText = `(${currentCount + 1})`;
        }
        
        // Kirim ke server (background)
        fetch(`/product/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        })
        .catch(err => {
            console.error('Like error:', err);
            // Revert jika gagal
            if (element.classList.contains('fas')) {
                element.classList.remove('fas');
                element.classList.add('far');
                element.style.color = '#888';
                if (countSpan) countSpan.innerText = `(${currentCount})`;
            } else {
                element.classList.remove('far');
                element.classList.add('fas');
                element.style.color = '#27ae60';
                if (countSpan) countSpan.innerText = `(${currentCount})`;
            }
        });
    };

    // Add to cart
    document.getElementById('add-cart-btn').addEventListener('click', () => {
        if (hasSize && !selectedSize) {
            alert('Pilih ukuran terlebih dahulu.');
            return;
        }

        fetch('{{ route("keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1,
                size: selectedSize ?? '',
                flavor: '',
                note: ''
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById('add-cart-btn');
                btn.style.background  = '#5C2D0E';
                btn.style.color       = '#fff';
                btn.style.borderColor = '#5C2D0E';
                btn.style.transform   = 'scale(1.15)';
                setTimeout(() => { btn.style.transform = ''; }, 200);
                
                // Update badge keranjang di navbar
                if (typeof updateCartBadge === 'function') {
                    updateCartBadge(1);
                }
                showToast('🛒 ' + data.message);
            } else {
                showToast(data.message ?? 'Gagal menambah ke keranjang.', 'error');
            }
        })
        .catch(error => {
            console.error('Cart Error:', error);
            showToast('Gagal menambah ke keranjang.', 'error');
        });
    });
    
    // Toast notifikasi (opsional)
    function showToast(message) {
        let toast = document.getElementById('detail-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'detail-toast';
            toast.style.cssText = `
                position: fixed; bottom: 24px; right: 24px;
                background: #5C2D0E; color: #fff;
                padding: 12px 20px; border-radius: 10px;
                font-size: 13px; font-weight: 500;
                box-shadow: 0 4px 16px rgba(0,0,0,0.2);
                z-index: 99999; opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
            `;
            document.body.appendChild(toast);
        }
        toast.innerText = message;
        toast.style.opacity = '1';
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => { toast.style.opacity = '0'; }, 2000);
    }

    // ✅ WISHLIST UNTUK POPULAR PRODUCTS
window.toggleWishlistPop = function(productId, element) {
    event.stopPropagation();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '/login';
        return;
    }
    
    // Langsung ubah warna
    if (element.classList.contains('fas')) {
        element.classList.remove('fas');
        element.classList.add('far');
        element.style.color = '#888';
    } else {
        element.classList.remove('far');
        element.classList.add('fas');
        element.style.color = '#e74c3c';
    }
    
    // Kirim ke server
    fetch(`/wishlist/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1,
            size: selectedSize ?? '',
            flavor: '',
            note: ''
        })
    })
    .catch(err => console.error('Wishlist error:', err));
};

// ✅ LIKE UNTUK POPULAR PRODUCTS
window.toggleLikePop = function(productId, element) {
    event.stopPropagation();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '/login';
        return;
    }
    
    // Ambil ikon dan count
    const icon = element.querySelector('i');
    const countSpan = document.querySelector(`.pop-like-count-${productId}`);
    let currentCount = parseInt(countSpan?.innerText?.replace(/[()]/g, '') || 0);
    
    // Langsung ubah warna & count
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
    
    // Kirim ke server
    fetch(`/product/like/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        }
    })
    .catch(err => {
        console.error('Like error:', err);
        // Revert jika gagal
        if (icon.classList.contains('fas')) {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '#888';
            if (countSpan) countSpan.innerText = `(${currentCount})`;
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#27ae60';
            if (countSpan) countSpan.innerText = `(${currentCount})`;
        }
    });
};

// ✅ TAMBAH KE KERANJANG UNTUK POPULAR PRODUCTS
window.tambahKeKeranjangPop = async function(productId) {
    event.stopPropagation();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await fetch('{{ route("keranjang.tambah") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1,
                size: '',
                flavor: '',
                note: ''
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const btn = element;
            if (btn) {
                btn.style.background  = '#5C2D0E';
                btn.style.color       = '#fff';
                btn.style.borderColor = '#5C2D0E';
                btn.style.transform   = 'scale(1.15)';
                setTimeout(() => { btn.style.transform = ''; }, 200);
            }
            
            if (typeof updateCartBadge === 'function') {
                updateCartBadge(1);
            }
            showToast('🛒 ' + data.message);
        } else {
            showToast(data.message ?? 'Gagal menambah ke keranjang.', 'error');
        }
    } catch (err) {
        console.error('Cart error:', err);
        showToast('Gagal menambah ke keranjang.', 'error');
    }
};
</script>
@endpush
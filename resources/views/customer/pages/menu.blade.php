@extends('customer.layouts.app')

@section('title', 'Kuesaena - Menu')

@push('styles')
<style>
    .page-content {
        padding-top: 100px;
        background-color: #ffffff;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    /* Banner Image Section */
    .banner-section {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto 40px;
        height: 250px;
        position: relative;
    }
    
    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-color: #4a2c2a; 
    }

    .menu-container {
        display: flex;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }

    /* Sidebar Filter */
    .sidebar-filter {
        width: 250px;
        flex-shrink: 0;
        border-right: 1px solid #eaeaea;
        padding-right: 20px;
    }

    .filter-header {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #000;
        padding-bottom: 15px;
    }

    .filter-group {
        margin-bottom: 25px;
    }

    .filter-group-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }

    .filter-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 13px;
        color: #555;
    }

    .filter-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        accent-color: #5C4033;
        cursor: pointer;
    }

    .range-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }

    .range-input-group input[type="text"] {
        flex: 1;
        padding: 6px 10px;
        border: 1px solid #eee;
        background-color: #f1f1f1;
        border-radius: 4px;
        font-size: 12px;
        color: #333;
    }

    .range-input-group button {
        padding: 6px 12px;
        background-color: #d1d1d1;
        border: none;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        color: #555;
        font-weight: 500;
    }

    /* Products Section */
    .products-section {
        flex: 1;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .product-image-wrapper {
    position: relative;
    height: 180px;
    overflow: hidden;
    }

    .discount-badge {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #d32f2f;
        color: white;
        padding: 4px 14px 4px 8px;
        font-size: 9px;
        font-weight: 600;
        z-index: 10;
        clip-path: polygon(0 0, 100% 0, 90% 50%, 100% 100%, 0 100%);
    }

    .po-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background-color: rgba(92, 64, 51, 0.9);
        color: white;
        padding: 4px 8px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 12px;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info-wrap {
        padding: 12px;
        background: #f1f1f1;
        border-top: 1px solid #e0e0e0;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: background 0.3s, color 0.3s;
    }
    
    /* Dark variant like in the first row of mockup */
    .product-card.dark-card .product-info-wrap,
    .product-card:hover .product-info-wrap {
        background: #4A3326;
        color: #ffffff;
    }
    .product-card.dark-card .product-name, 
    .product-card.dark-card .price-current, 
    .product-card.dark-card .product-actions i,
    .product-card.dark-card .meta-left,
    .product-card:hover .product-name, 
    .product-card:hover .price-current, 
    .product-card:hover .product-actions i,
    .product-card:hover .meta-left {
        color: #ffffff;
    }
    .product-card.dark-card .price-old,
    .product-card:hover .price-old {
        color: #e0e0e0;
    }

    .product-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .product-name {
    font-size: 11px;
    font-weight: 600;
    color: #333;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    max-width: 100%;
    }

    .product-actions {
        display: flex;
        gap: 8px;
        color: #555;
    }

    .product-actions i {
        cursor: pointer;
        font-size: 12px;
        transition: color 0.2s;
    }

    /* Tombol Keranjang - HANYA IKON BORDER (SAMA PERSIS DENGAN LIKE & WISHLIST) */
.cart-toggle-btn {
    background: transparent;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.cart-toggle-btn i {
    font-size: 12px;
    font-weight: 900 !important;
    color: #fff !important;
    transition: color 0.2s;
}
.cart-toggle-btn.active i {
    color: #e67e22 !important;
}

/* State aktif (sudah di keranjang) - HANYA UBAH WARNA & JADI SOLID */
.cart-toggle-btn.active {
    color: #e67e22;  /* Warna oranye/coklat sesuai tema */
}

.cart-toggle-btn.active i {
    font-weight: 900;  /* fas = solid */
}

/* Efek klik pada tombol */
.cart-clicked {
    transform: scale(1.2);
    transition: transform 0.2s ease;
}

/* Efek pada gambar produk saat klik */
.product-image-clicked {
    transform: scale(0.95);
    transition: transform 0.2s ease;
}

    .product-price-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
    }

    .price-current {
        font-size: 11px;
        font-weight: 700;
        color: #000;
    }

    .price-old {
        font-size: 9px;
        color: #888;
        text-decoration: line-through;
    }

    .product-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 9px;
        color: #888;
    }

    .meta-left {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .star-icon {
        color: #ccc;
    }

    .meta-colors {
        display: flex;
        gap: 3px;
    }

    .color-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .color-dot.red { background-color: #d32f2f; }
    .color-dot.green { background-color: #388e3c; }
    .color-dot.brown { background-color: #5d4037; }

    /* Collage Section */
    .collage-section {
        max-width: 1200px;
        margin: 40px auto 80px;
        display: grid;
        grid-template-columns: 1fr 1fr 1.5fr;
        gap: 15px;
        padding: 0 20px;
    }
    
    .collage-grid-left {
        display: grid;
        grid-template-rows: auto auto;
        gap: 15px;
    }

    .collage-grid-center {
        display: grid;
        grid-template-rows: auto auto auto;
        gap: 15px;
    }

    .collage-item {
        border-radius: 20px;
        overflow: hidden;
    }
    
    .collage-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 992px) {
        .products-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .collage-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .menu-container {
            flex-direction: column;
        }
        .sidebar-filter {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

/* Tombol Keranjang - Lingkaran hanya muncul saat aktif */
.cart-toggle-btn {
    background: transparent;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: auto;
    height: auto;
    transition: all 0.3s ease;
}

/* State aktif: icon + lingkaran luar */
.cart-toggle-btn.active {
    border: 1.5px solid #e67e22;
    border-radius: 50%;
    padding: 4px;
    width: 28px;
    height: 28px;
}

.cart-toggle-btn.active i {
    font-weight: 900;
    color: #e67e22;
}
</style>
@endpush

@section('content')
<div class="page-content">

    <!-- Banner Section -->
    <div class="banner-section">
        <img src="https://images.unsplash.com/photo-1558222218-b7b54eede3f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Special Banner" class="banner-image">
    </div>

    <div class="menu-container">
        <!-- Sidebar Filter -->
        <form method="GET" action="{{ route('customer.menu') }}" id="filterForm" class="sidebar-filter">
            <div class="filter-header">
                <i class="fas fa-filter"></i> Filter
            </div>

            <!-- Kategori Produk -->
            <div class="filter-group">
                <div class="filter-group-title">Kategori Produk</div>
                @foreach($categories as $category)
                @if($category->name !== 'Milkshake')
                <label class="filter-item">{{ $category->name }} <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ (is_array(request('categories')) && in_array($category->id, request('categories'))) ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                @endif
                @endforeach
            </div>

            <!-- Tema (Disabled - No DB Columns) -->
            <!-- h 
            <div class="filter-group">
                <div class="filter-group-title">Tema</div>
                <label class="filter-item">Ulang Tahun <input type="checkbox"></label>
                <label class="filter-item">Wedding <input type="checkbox"></label>
                <label class="filter-item">Anniversary <input type="checkbox"></label>
                <label class="filter-item">Graduation <input type="checkbox"></label>
                <label class="filter-item">Custom <input type="checkbox"></label>
            </div>
            -->

            <!-- Ukuran (Disabled - No DB Columns) -->
            <!--
            <div class="filter-group">
                <div class="filter-group-title">Ukuran</div>
                <label class="filter-item">Small <input type="checkbox"></label>
                <label class="filter-item">Medium <input type="checkbox"></label>
                <label class="filter-item">Large <input type="checkbox"></label>
            </div>
            -->

            <!-- Rasa (Disabled - No DB Columns) -->
            <!--
            <div class="filter-group">
                <div class="filter-group-title">Rasa</div>
                <label class="filter-item">Coklat <input type="checkbox"></label>
                <label class="filter-item">Strawberry <input type="checkbox"></label>
                <label class="filter-item">Vanilla <input type="checkbox"></label>
            </div>
            -->
            
            <!-- Kategori Spesial (Disabled - No DB Columns) -->
            <!--
            <div class="filter-group">
                <div class="filter-group-title">Kategori Spesial</div>
                <label class="filter-item">Vegan <input type="checkbox"></label>
                <label class="filter-item">Gluten-free <input type="checkbox"></label>
                <label class="filter-item">Less Sugar <input type="checkbox"></label>
                <label class="filter-item">Dairy-free <input type="checkbox"></label>
            </div>
            -->

            <!-- Range Harga -->
            <div class="filter-group">
                <div class="filter-group-title">Range Harga</div>
                <div class="range-input-group">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min">
                </div>
                <div class="range-input-group">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max">
                    <button type="submit">Filter</button>
                </div>
            </div>

            <!-- Urut Berdasarkan -->
            <div class="filter-group">
                <div class="filter-group-title">Urut Berdasarkan</div>
                <label class="filter-item">Terbaru <input type="radio" name="sort_by" value="terbaru" {{ request('sort_by') == 'terbaru' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                <label class="filter-item">Terlaris <input type="radio" name="sort_by" value="terlaris" {{ request('sort_by') == 'terlaris' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                <label class="filter-item">Terendah <input type="radio" name="sort_by" value="terendah" {{ request('sort_by') == 'terendah' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                <label class="filter-item">Tertinggi <input type="radio" name="sort_by" value="tertinggi" {{ request('sort_by') == 'tertinggi' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                @if(request('sort_by'))
            <button type="button" onclick="resetSort()" style="margin-top:8px; font-size:12px; color:#999; background:none; border:none; cursor:pointer; padding:0;">✕ Reset urutan</button>
            @endif
            </div>


        </form>

        <!-- Products Section -->
        <div class="products-section">
            <div class="products-grid">
                @foreach($products as $product)
                @php
                    $isDark = true;
                @endphp
                <div class="product-card {{ $isDark ? 'dark-card' : '' }}" onclick="window.location.href='{{ route('customer.product.show', $product->id) }}'" style="cursor: pointer;">
                    <a href="{{ route('customer.product.show', $product->id) }}" style="text-decoration:none; color:inherit; display:block;" onclick="event.preventDefault();">
                        <div class="product-image-wrapper">
                            @if($product->is_po)
                            <span class="po-badge">PO {{ $product->po_days }} Hari</span>
                            @endif
                           @php
                                $imgRaw = $product->image;
                                if ($imgRaw && str_starts_with($imgRaw, 'images/')) {
                                    $imgSrc = asset($imgRaw);
                                } elseif ($imgRaw) {
                                    $imgSrc = asset('storage/' . $imgRaw);
                                } else {
                                    $fallback = ['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg'];
                                    $imgSrc = asset('images/products/' . $fallback[$product->id % count($fallback)]);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/no-image.jpg') }}'">
                            </div>
                    </a>
                    
                    <div class="product-info-wrap">
                        <div class="product-header-row">
                            <a href="{{ route('customer.product.show', $product->id) }}" style="text-decoration:none; color:inherit; max-width: 70%;" onclick="event.preventDefault();">
                                <div class="product-name">{{ $product->name }}</div>
                            </a>
                            
                         <div class="product-actions">
    @php
        $isWishlisted = Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists();
        $isLiked = Auth::check() && Auth::user()->productLikes()->where('product_id', $product->id)->exists();
        $isInCart = Auth::check() && Auth::user()->carts()->where('product_id', $product->id)->exists();
    @endphp
    
    <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart" 
       style="cursor:pointer; color: {{ $isWishlisted ? '#e74c3c' : '#888' }};" 
       onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"></i>
    
    <i class="{{ $isLiked ? 'fas' : 'far' }} fa-thumbs-up" 
       style="cursor:pointer; color: {{ $isLiked ? '#27ae60' : '#888' }};" 
       onclick="event.stopPropagation(); toggleLike({{ $product->id }}, this)"></i>
    
    <span class="like-count-{{ $product->id }}" style="font-size:9px; margin-left:2px;">{{ $product->likes()->count() }}</span>
    
    <button class="cart-toggle-btn {{ $isInCart ? 'active' : '' }}" 
        onclick="toggleCart(this, {{ $product->id }})">
    <i class="fas fa-shopping-cart"></i>
</button>
</div>

                        </div>
                        <div class="product-price-row">
                            <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="product-meta-row">
                            <div class="meta-left">
                                <i class="fas fa-star" style="color: #FFD700;"></i> 4.9/5 | 50 Sold
                            </div>
                            <div class="meta-colors">
                                <div class="color-dot red"></div>
                                <div class="color-dot green"></div>
                                <div class="color-dot brown"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Collage Section at the bottom -->
    <div class="collage-section">
        <div class="collage-grid-left">
            <div class="collage-item" style="height: 245px;">
                <img src="{{ asset('images/products/7.jpg') }}" alt="Collage 1">
            </div>
            <div class="collage-item" style="height: 135px;">
                <img src="{{ asset('images/products/8.jpg') }}" alt="Collage 2">
            </div>
        </div>
        
        <div class="collage-grid-center">
             <div class="collage-item" style="height: 120px;">
                <img src="{{ asset('images/products/10.jpg') }}" alt="Collage 3">
            </div>
            <div class="collage-item" style="height: 120px;">
                <img src="{{ asset('images/products/12.jpg') }}" alt="Collage 4">
            </div>
            <div class="collage-item" style="height: 120px;">
                <img src="{{ asset('images/products/14.jpg') }}" alt="Collage 5">
            </div>
        </div>

        <div class="collage-item" style="height: 395px; border-radius: 30px;">
             <img src="{{ asset('images/products/15.jpg') }}" alt="Collage Master">
        </div>
    </div>

</div>
@endsection


@push('scripts')
<script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    function resetSort() {
    const url = new URL(window.location.href);
    url.searchParams.delete('sort_by');
    window.location.href = url.toString();
    }

    // ✅ WISHLIST - LANGSUNG BERUBAH WARNA TANPA REFRESH
    window.toggleWishlist = function(productId, element) {
        event.stopPropagation();
        
        // Cek login
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        // 🔥 LANGSUNG UBAH WARNA (TANPA NUNGGU SERVER)
        if (element.classList.contains('fas')) {
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
        } else {
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#e74c3c';
        }

        if (typeof showToast === 'function') {
            showToast(element.classList.contains('fas') ? '❤️ Ditambahkan ke wishlist' : '🤍 Dihapus dari wishlist');
        }
        
        // Kirim ke server (background) - TANPA update ulang
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        })
        .catch(err => console.error('Error:', err));
    };

    // ✅ LIKE - LANGSUNG BERUBAH WARNA & COUNT TANPA KEDIP
    window.toggleLike = function(productId, element) {
        event.stopPropagation();
        
        // Cek login
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }
        
        // Ambil elemen count
        let countSpan = document.querySelector(`.like-count-${productId}`);
        let currentCount = parseInt(countSpan?.innerText || 0);
        
        // 🔥 LANGSUNG UBAH WARNA & COUNT
        if (element.classList.contains('fas')) {
            // Sudah like → jadi unlike
            element.classList.remove('fas');
            element.classList.add('far');
            element.style.color = '#888';
            if (countSpan) countSpan.innerText = currentCount - 1;
        } else {
            // Belum like → jadi like
            element.classList.remove('far');
            element.classList.add('fas');
            element.style.color = '#27ae60';
            if (countSpan) countSpan.innerText = currentCount + 1;
        }
        
        if (typeof showToast === 'function') {
            showToast(element.classList.contains('fas') ? '👍 Produk disukai' : '👎 Batal menyukai');
        }

        // Kirim ke server (background) - JANGAN update ulang biar gak kedip
        fetch(`/product/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            }
        })
        .catch(err => {
            console.error('Error:', err);
            // Jika gagal, revert perubahan (opsional)
            if (element.classList.contains('fas')) {
                element.classList.remove('fas');
                element.classList.add('far');
                element.style.color = '#888';
                if (countSpan) countSpan.innerText = currentCount;
            } else {
                element.classList.remove('far');
                element.classList.add('fas');
                element.style.color = '#27ae60';
                if (countSpan) countSpan.innerText = currentCount;
            }
        });
    };

    window.toggleCart = function(button, productId) {
    event.stopPropagation();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '/login';
        return;
    }
    
    // Ambil data produk (termasuk gambar)
    let productCard = button.closest('.product-card, .pop-card');
    let productImage = productCard?.querySelector('img')?.src;
    let productName = productCard?.querySelector('.product-name, .pop-card__name')?.innerText;
    let productPrice = productCard?.querySelector('.price-current, .pop-price-current')?.innerText;
    
    // Animasi klik
    button.classList.add('cart-clicked');
    setTimeout(() => button.classList.remove('cart-clicked'), 200);
    
    // Animasi gambar
    let img = productCard?.querySelector('img');
    if (img) {
        img.classList.add('product-image-clicked');
        setTimeout(() => img.classList.remove('product-image-clicked'), 200);
    }
    
    let icon = button.querySelector('i');
    let wasInCart = button.classList.contains('active');
    
    // Optimistic update tampilan
    if (wasInCart) {
        button.classList.remove('active');
        icon.classList.remove('fas');
        icon.classList.add('far');
        if (button.querySelector('.cart-text')) {
            button.querySelector('.cart-text').textContent = 'Tambah ke Keranjang';
        }
    } else {
        button.classList.add('active');
        icon.classList.remove('far');
        icon.classList.add('fas');
        if (button.querySelector('.cart-text')) {
            button.querySelector('.cart-text').textContent = 'Hapus dari Keranjang';
        }
    }
    
    // Kirim ke server (toggle di database)
    fetch('{{ route("keranjang.toggle") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            product_id: productId,
            image: productImage || '',
            name: productName || '',
            price: productPrice || ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revert jika gagal
            if (wasInCart) {
                button.classList.add('active');
                icon.classList.remove('far');
                icon.classList.add('fas');
                if (button.querySelector('.cart-text')) {
                    button.querySelector('.cart-text').textContent = 'Hapus dari Keranjang';
                }
            } else {
                button.classList.remove('active');
                icon.classList.remove('fas');
                icon.classList.add('far');
                if (button.querySelector('.cart-text')) {
                    button.querySelector('.cart-text').textContent = 'Tambah ke Keranjang';
                }
            }
        } else {
            // Update badge navbar
            let cartBadge = document.querySelector('.action-badge');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
                cartBadge.style.display = data.cart_count > 0 ? 'flex' : 'none';
            }
            
            // Optional: Toast notifikasi
            if (typeof showToast === 'function') {
                showToast(data.is_in_cart ? '✓ Ditambahkan ke keranjang' : '✗ Dihapus dari keranjang');
            }
        }
    })
    .catch(err => {
        console.error('Error:', err);
        if (wasInCart) {
            button.classList.add('active');
            icon.classList.remove('far');
            icon.classList.add('fas');
            if (button.querySelector('.cart-text')) {
                button.querySelector('.cart-text').textContent = 'Hapus dari Keranjang';
            }
        } else {
            button.classList.remove('active');
            icon.classList.remove('fas');
            icon.classList.add('far');
            if (button.querySelector('.cart-text')) {
                button.querySelector('.cart-text').textContent = 'Tambah ke Keranjang';
            }
        }
    });
};
</script>
@endpush
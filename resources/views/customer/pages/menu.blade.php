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
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
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
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%;
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
                <label class="filter-item">{{ $category->name }} <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ (is_array(request('categories')) && in_array($category->id, request('categories'))) ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"></label>
                @endforeach
            </div>

            <!-- Tema (Disabled - No DB Columns) -->
            <!--
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
                            @if($isDark)
                            <span class="discount-badge">Get it on 10% Off Today Only</span>
                            @endif
                            <span class="po-badge">PO 5 Hari</span>
                            @php
                                $imgSrc = $product->image;
                                if (!$imgSrc || !file_exists(public_path($imgSrc))) {
                                    $jpgPath = 'images/products/' . $product->id . '.jpg';
                                    $pngPath = 'images/products/' . $product->id . '.png';
                                    if (file_exists(public_path($jpgPath))) {
                                        $imgSrc = $jpgPath;
                                    } elseif (file_exists(public_path($pngPath))) {
                                        $imgSrc = $pngPath;
                                    } else {
                                        // Pick a default image from the products folder as a placeholder
                                        $fallbackImages = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '10.jpg', '11.jpg', '12.jpg', '13.jpg', '14.jpg', '15.jpg'];
                                        $imgSrc = 'images/products/' . $fallbackImages[$product->id % count($fallbackImages)];
                                    }
                                }
                            @endphp
                            <img src="{{ asset($imgSrc) }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/no-image.jpg') }}'">
                        </div>
                    </a>
                    
                    <div class="product-info-wrap">
                        <div class="product-header-row">
                            <a href="{{ route('customer.product.show', $product->id) }}" style="text-decoration:none; color:inherit; max-width: 70%;" onclick="event.preventDefault();">
                                <div class="product-name">{{ $product->name }}</div>
                            </a>
                            <div class="product-actions">
                                    <i   class="far fa-heart" style="cursor:pointer;" onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"></i>
                                    <i   class="far fa-thumbs-up" style="cursor:pointer;" onclick="event.stopPropagation(); toggleLike({{ $product->id }}, this)"></i>
                                 <span  pan class="like-count-{{ $product->id }}" style="font-size:9px; margin-left:2px;">{{ $product->likes()->count() }}</span>
                                    <i   class="fas fa-shopping-cart" style="cursor:pointer;" onclick="event.stopPropagation(); tambahKeKeranjang({{ $product->id }})"></i>
                                </div>  
                        </div>
                        <div class="product-price-row">
                            <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="price-old">Rp {{ number_format($product->price + 11000, 0, ',', '.') }}</span>
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
    function tambahKeKeranjang(productId) {
        if (!{{ Auth::check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }

        fetch('/keranjang/tambah', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(res => {
            if (res.ok || res.redirected) {
                // Update badge keranjang di navbar langsung tanpa reload
                if (typeof updateCartBadge === 'function') {
                    updateCartBadge(1);
                }

                // Flash notif kecil di pojok kanan bawah
                showToast('🛒 Ditambahkan ke keranjang!');
            }
        })
        .catch(() => showToast('Gagal menambahkan ke keranjang.', true));
    }

    // Wishlist Toggle
    window.toggleWishlist = function(productId, element) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'added') {
                element.classList.remove('far');
                element.classList.add('fas');
                element.style.color = '#e67e22';
                showToast('❤️ Ditambahkan ke wishlist!');
            } else {
                element.classList.remove('fas');
                element.classList.add('far');
                element.style.color = '';
                showToast('Dihapus dari wishlist');
            }
        })
        .catch(() => console.error('Wishlist error'));
    };

    // Like Toggle
    window.toggleLike = function(productId, element) {
        fetch(`/product/like/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const countSpan = document.querySelector(`.like-count-${productId}`);
            if (countSpan) countSpan.innerText = data.total_likes;

            if (data.liked) {
                element.classList.remove('far');
                element.classList.add('fas');
                element.style.color = '#27ae60';
                showToast('👍 Berhasil disukai!');
            } else {
                element.classList.remove('fas');
                element.classList.add('far');
                element.style.color = '';
                showToast('Batal menyukai');
            }
        })
        .catch(() => console.error('Like error'));
    };

    // Toast notif kecil (muncul di pojok kanan bawah, hilang otomatis)
    function showToast(message, isError = false) {
        let toast = document.getElementById('menu-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'menu-toast';
            toast.style.cssText = `
                position: fixed; bottom: 24px; right: 24px;
                background: #3B1A08; color: #fff;
                padding: 12px 20px; border-radius: 10px;
                font-size: 13px; font-weight: 500;
                box-shadow: 0 4px 16px rgba(0,0,0,0.2);
                z-index: 99999; opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
            `;
            document.body.appendChild(toast);
        }
        if (isError) toast.style.background = '#c0392b';
        else toast.style.background = '#3B1A08';

        toast.innerText = message;
        toast.style.opacity = '1';
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => { toast.style.opacity = '0'; }, 2500);
    }
</script>
@endpush
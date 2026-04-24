@extends('customer.layouts.app')

@section('title', 'Kuesaena - Setiap Gigitan Kenangan Manis yang Tak Terlupakan')

@push('styles')
<style>
/* ================================================================
   CUSTOMER HOME PAGE
================================================================ */

/* Push content below fixed navbar */
.page-content { padding-top: 76px; }

/* ================================================================
   1. HERO SECTION
================================================================ */

.hero {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    align-items: center;
    min-height: calc(100vh - 76px);
    padding: 0 80px;
    gap: 40px;

    background: radial-gradient(circle at 75% 50%, #d6a77a 0%, transparent 40%),
                linear-gradient(135deg, #2b1a14, #5a2e1b);
    color: #fff;
}

.hero-content {
    max-width: 520px;
    margin-left: 40px;
}

.hero-content h1 {
    font-size: 56px;
    font-weight: 600;
    line-height: 1.2;
}

.hero-content h1 span {
    font-style: italic;
    color: #e6c3a3;
}

.hero-content p {
    margin-top: 20px;
    color: #ddd;
    line-height: 1.6;
}

.btn-order {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 28px;
    border-radius: 8px;
    background: rgba(0,0,0,0.6);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
}

.btn-order:hover {
    background: #000;
    transform: translateY(-2px);
}

.hero-image {
    position: relative;
    z-index: 2;
}

.hero-image img {
    width: 500px;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.6));
}

/* glow effect belakang cake */
.hero::after {
    content: "";
    position: absolute;
    right: 10%;
    top: 50%;
    transform: translateY(-50%);
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 200, 150, 0.4), transparent 70%);
    z-index: 1;
}

/* ================================================================
   2. CATEGORIES SECTION
================================================================ */

.categories-section {
    padding: 80px 0px;
    background: #fff;
}

/* HEADER */
.section-header {
    text-align: center;
    margin-bottom: 40px;
}

.section-title {
    font-size: 32px;
    font-weight: 600;
    color: #2b1a14;
}

.section-subtitle {
    margin-top: 10px;
    color: #5a2e1b;
    font-size: 14px;
}

/* SCROLL */
.categories-scroll {
    display: flex;
    gap: 28px;
    overflow-x: auto;
    padding: 20px 0;
    scrollbar-width: thin;
    scrollbar-color: var(--brown-mid) var(--cream-light);
}

/* CARD */
.category-card {
    min-width: 220px;
    background: #4b2a1f;
    border-radius: 16px;
    padding: 14px;
    cursor: pointer;
    transition: 0.3s ease;
    border: none;
}

.category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

/* IMAGE */
.category-card__img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    background: #fff;
    padding: 6px;
}

.category-card:hover .category-card__img {
    transform: scale(1.05);
}

/* FALLBACK */
.category-card__img-placeholder {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    background: #3a2117;
    border-radius: 12px;
}

/* TEXT */
.category-card__name {
    margin-top: 12px;
    font-weight: 600;
    text-align: center;
    color: #fff;
    font-size: 15px;
}

/* VIEW ALL */
.view-all-btn {
    color: #e6c3a3;
    border-bottom: 1px solid #e6c3a3;
    text-decoration: none;
    padding-bottom: 4px;
    transition: 0.3s;
}

.view-all-btn:hover {
    color: #fff;
    border-color: #fff;
}

/* ================================================================
   3. PRODUCTS SECTION
================================================================ */
.products-section {
    padding: 80px 0;
    background: #fff;
}

.products-section .section-title { color: #3e2c23; }
.products-section .section-subtitle { color: #8b7d75; }
.products-section .section-header { text-align: center; margin-bottom: 48px; }

.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.products-grid a {
    display: block;
}

.product-card__link {
    display: block;
    text-decoration: none;
    color: inherit;
    width: 100%;
    height: 100%;
}

.product-card {
    display: block;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    position: relative;
    pointer-events: auto;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: transform 0.2s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-card__badge {
    position: absolute;
    top: 21px;
    left: 0px;
    background: #d62828;
    color: #fff;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    pointer-events: none;
}

.product-card button {
    pointer-events: auto;
}

.product-card__badge::after {
    content: "";
    position: absolute;
    right: -20px;
    top: 0;
    width: 0;
    height: 0;
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    border-left: 20px solid #d62828;
    background: linear-gradient(90deg, #d62828, #e63946);
}

.view-all-wrap {
    text-align: center;
    margin-top: 40px;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--cream-dark);
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    transition: all 0.25s ease;
    text-decoration: none;
    padding-bottom: 3px;
    border-bottom: 1.5px solid rgba(245,236,216,0.3);
}

.view-all-btn:hover {
    color: var(--white);
    gap: 14px;
    border-bottom-color: var(--cream-main);
}

/* ================================================================
   4. ABOUT / CINTA KAMI SECTION
================================================================ */
.about-text-box {
    color: #fff;
    max-width: 500px;
    margin-right: 40px;
}

.about-section {
    position: relative;
    min-height: 450px;
    overflow: hidden;
}

.about-bg {
    position: absolute;
    inset: 0;
    background: url('/images/baking.png') center/cover no-repeat;
    z-index: 1;
}

.about-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        rgba(0,0,0,0.45),
        rgba(0,0,0,0.1),
        rgba(0,0,0,0)
    );
    z-index: 2;
}

.about-content {
    position: relative;
    z-index: 3;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    min-height: 450px;
    padding-left: 10%;
}

.about-text-box h2 {
    color: #fff;
    font-size: 2.5rem;
    margin-bottom: 20px
}

.about-text-box p {
    color: rgba(255,255,255,0.85);
    font-size: 1.2rem;
    line-height: 1.8;
}

.about-text-box h2,
.about-text-box p {
    text-shadow: 0 2px 6px rgba(0,0,0,0.4);
}

/* ================================================================
   5. WHY CHOOSE US
================================================================ */

.why-section {
    position: relative;
    padding: 100px 0;
    overflow: hidden;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.why-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=1400&q=80');
    background-size: cover;
    background-position: center;
    filter: brightness(0.5);
}

.why-overlay {
    position: absolute;
    inset: 0;
    background: rgba(45, 25, 15, 0.7);
}

.why-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
}

.why-title {
    text-align: center;
    font-size: 36px;
    color: #fff;
    margin-bottom: 50px;
    font-weight: 700;
}

.why-grid-outer {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    position: relative;
    padding: 20px;
}

.why-card {
    background: #f8f8f8;
    padding: 40px;
    min-height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    transition: all 0.3s ease;
}

.why-card h3 {
    font-size: 22px;
    font-weight: 800;
    color: #4b2e1e;
    margin-bottom: 10px;
}

.why-card p {
    font-size: 15px;
    color: #444;
    line-height: 1.5;
    margin: 0;
}

.card-tl { border-radius: 30px 30px 0 30px; text-align: right; }
.card-tr { border-radius: 30px 30px 30px 0; text-align: left; }
.card-bl { border-radius: 30px 0 30px 30px; text-align: right; }
.card-br { border-radius: 0 30px 30px 30px; text-align: left; }

.why-center-logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: #fff;
    border: 10px solid #4b2e1e;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
}

.why-center-logo img {
    width: 100px;
    height: auto;
}

@media (max-width: 768px) {
    .why-grid-outer {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .why-center-logo { display: none; }
    .why-card {
        border-radius: 20px !important;
        text-align: center;
    }
}

/* ================================================================
   6. GALLERY
================================================================ */
.gallery-section {
    padding: 80px 0;
    background: var(--white);
}

.gallery-title { text-align: center; margin-bottom: 40px; }

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: auto auto;
    gap: 12px;
}

.gallery-item {
    border-radius: var(--radius-md);
    overflow: hidden;
    cursor: pointer;
    position: relative;
}

.gallery-item:first-child {
    grid-column: span 2;
    grid-row: span 2;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
    min-height: 160px;
}

.gallery-item:first-child img { min-height: 320px; }

.gallery-item:hover img { transform: scale(1.05); }

.gallery-item::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(59,26,8,0);
    transition: background 0.3s ease;
}

.gallery-item:hover::after { background: rgba(59,26,8,0.2); }

/* ================================================================
   7. TESTIMONIALS
================================================================ */
.testi-section {
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.testi-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #6B3A1F 0%, #8B4513 50%, #A0522D 100%);
}

.testi-bg-img {
    position: absolute;
    inset: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
}

.testi-bg-img div {
    background-size: cover;
    background-position: center;
    opacity: 0.15;
}

.testi-bg-img div:first-child {
    background-image: url('https://images.unsplash.com/photo-1607478900766-efe13248b125?w=600&q=80');
}

.testi-bg-img div:last-child {
    background-image: url('https://images.unsplash.com/photo-1593085512500-5d55148d6f0d?w=600&q=80');
    background-position: right center;
}

.testi-content {
    position: relative;
    z-index: 2;
}

.testi-header {
    text-align: center;
    margin-bottom: 48px;
}

.testi-header h2 {
    font-size: clamp(28px, 4vw, 48px);
    font-weight: 800;
    color: var(--white);
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 8px;
}

.testi-header p {
    font-size: 15px;
    color: rgba(255,255,255,0.7);
}

.testi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* ================================================================
   RESPONSIVE
================================================================ */
@media (max-width: 1024px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .gallery-grid { grid-template-columns: repeat(3, 1fr); }
    .gallery-item:first-child { grid-column: span 2; }
    .why-grid-outer {
        grid-template-columns: 1fr;
        max-width: 520px;
    }
    .why-center-logo { margin: 0 auto; }
    .why-column { flex-direction: row; flex-wrap: wrap; }
    .why-card { flex: 1; min-width: 200px; }
}

@media (max-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 48px 0;
    }
    .hero-image-wrap { display: none; }
    .hero-cta-row { justify-content: center; }
    .products-grid { grid-template-columns: 1fr; }
    .testi-grid { grid-template-columns: 1fr; }
    .about-text-box { text-align: left; max-width: 100%; }
    .about-content { justify-content: flex-start; }
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: unset;
    }
    .gallery-item:first-child { grid-column: span 2; grid-row: unset; }
}

@media (max-width: 480px) {
    .hero-title { font-size: 28px; }
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
<div class="page-content">

{{-- ================================================================
     1. HERO SECTION
================================================================ --}}
<section class="hero">
    <div class="hero-content">
        <h1>
            Setiap Gigitan <br />
            <span>Kenangan Manis</span> <br />
            yang Tak Terlupakan
        </h1>

        <p>
            Kami menciptakan kue dan roti lezat dengan cita rasa homemade,
            menggunakan bahan pilihan terbaik untuk moment spesialmu
        </p>

        <a href="#" class="btn-order">Pesan Sekarang</a>
    </div>

    <div class="hero-image">
        <img src="{{ asset('images/cake.png') }}" alt="Cake" style="border-radius:24px; box-shadow:0 10px 40px rgba(0,0,0,0.1); width:100%; max-width:500px;" />
    </div>
</section>

{{-- ================================================================
     2. CATEGORIES
================================================================ --}}
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Temukan Kelezatan Favoritmu</h2>
            <p class="section-subtitle">
                Kami menciptakan kue dan roti lezat, dengan bahan pilihan terbaik untuk moment spesialmu
            </p>
        </div>

        <div class="categories-scroll">
            @forelse($categories as $cat)
                @php
                    $catImg = $cat->image ? asset('storage/' . $cat->image) : asset('images/products/' . ($loop->iteration % 10 + 1) . '.jpg');
                @endphp
                <div class="category-card">
                    <img class="category-card__img"
                         src="{{ $catImg }}"
                         alt="{{ $cat->name }}">
                    <div class="category-card__name">
                        {{ $cat->name }}
                    </div>
                </div>
            @empty
                {{-- Fallback dummy categories --}}
                @foreach(['🧁 Combo', '🍞 Chocolate Bread', '🎂 Rose White Cake', '🎁 Hampers', '🥛 Milkshake', '🍪 Cookies'] as $dummy)
                    <div class="category-card">
                        <div class="category-card__img-placeholder">
                            {{ explode(' ', $dummy)[0] }}
                        </div>
                        <div class="category-card__name">{{ trim(substr($dummy, 2)) }}</div>
                    </div>
                @endforeach
            @endforelse
        </div>

        <div class="view-all-wrap" style="margin-top: 28px;">
            <a href="{{ route('customer.menu') }}" class="view-all-btn" style="color: var(--text-muted); border-bottom-color: var(--cream-dark);">
                VIEW ALL <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>


{{-- ================================================================
     4. ABOUT / CINTA KAMI
================================================================ --}}
<section class="about-section">
    <div class="about-bg"></div>
    <div class="about-overlay"></div>
    <div class="container">
        <div class="about-content">
            <div class="about-text-box">
                <h2>Cinta Kami dalam Setiap Adonan</h2>
                <p>
                Sejak 2021, kami percaya bahwa kue bukan sekadar hidangan penutup,
                melainkan penghubung hati. Setiap kreasi kami dibuat dengan resep
                turun-temurun dan inovasi rasa terkini, membawa kehangatan dan
                kebahagiaan ke meja makan Anda.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     3. FEATURED PRODUCTS
================================================================ --}}
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Pesan dan Rayakan Semua Kebahagian</h2>
            <p class="section-subtitle">
                Kami menciptakan kue dan roti lezat, dengan bahan pilihan terbaik untuk moment spesialmu
            </p>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                <a href="{{ route('customer.product.show', $product->id) }}" class="product-card">
                    <div class="product-card__img-wrap">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80" alt="{{ $product->name }}">
                        @endif
                    </div>
                    <div class="product-card__body">
                        <div class="product-card__top">
                            <h3 class="product-card__name">{{ $product->name }}</h3>
                        </div>
                        <div class="product-card__price-row">
                            <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="product-card__footer">
                            <div class="product-card__stars">
                                @for($s=0;$s<5;$s++)<i class="fas fa-star"></i>@endfor
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                {{-- Fallback jika belum ada produk --}}
                @for($i = 0; $i < 6; $i++)
                    <div class="product-card">
                        <div class="product-card__img-wrap">
                            <div class="product-card__badge">
                                <i class="fas fa-tag"></i> Get up to 10% off Today Only!
                            </div>
                            <img src="https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=400&q=80"
                                 alt="Combo Cupcake">
                        </div>
                        <div class="product-card__body">
                            <div class="product-card__top">
                                <h3 class="product-card__name">Combo Cupcake</h3>
                                <div class="product-card__actions">
                                    <button class="prod-action-btn"><i class="far fa-heart"></i></button>
                                    <button class="prod-action-btn"><i class="fas fa-shopping-cart"></i></button>
                                </div>
                            </div>
                            <div class="product-card__price-row">
                                <span class="price-current">Rp 249.999</span>
                                <span class="price-original">Rp 269.999</span>
                            </div>
                            <p class="product-card__po"><i class="fas fa-clock" style="color:#e67e22"></i> PO 5 hari</p>
                            <div class="product-card__footer">
                                <div class="product-card__stars">
                                    @for($s=0;$s<5;$s++)<i class="fas fa-star"></i>@endfor
                                </div>
                                <div class="product-card__dots">
                                    <span class="dot dot--cream"></span>
                                    <span class="dot dot--red"></span>
                                    <span class="dot dot--green"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <div class="view-all-wrap">
            <a href="{{ route('customer.menu') }}" class="view-all-btn">
                VIEW ALL <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ================================================================
     5. WHY CHOOSE US
================================================================ --}}
<section class="why-section">
    <div class="why-bg"></div>
    <div class="why-overlay"></div>

    <div class="container">
        <div class="why-content">
            <h2 class="why-title">Mengapa Memilih Kami?</h2>

            <div class="why-grid-outer">
                <div class="why-card card-tl">
                    <h3>Bahan Premium</h3>
                    <p>Hanya yang terbaik, tanpa kompromi untuk rasa dan kualitas.</p>
                </div>

                <div class="why-card card-tr">
                    <h3>Dibuat dengan Cinta</h3>
                    <p>Setiap pesanan dibuat khusus dengan perhatian penuh pada detail.</p>
                </div>

                <div class="why-center-logo">
                    <img src="/images/logo.png" alt="Kuesaena Logo">
                </div>

                <div class="why-card card-bl">
                    <h3>Segar Setiap Hari</h3>
                    <p>Kami jamin kesegaran dan kelezatan dalam setiap produk.</p>
                </div>

                <div class="why-card card-br">
                    <h3>Pelayanan Ramah</h3>
                    <p>Siap membantu mewujudkan moment manis impian Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     6. GALLERY
================================================================ --}}
<section class="gallery-section">
    <div class="container">
        <div class="gallery-title">
            <h2 class="section-title">Karya Kami</h2>
        </div>
        <div class="gallery-grid">
            @php
                $galleryImages = [
                    asset('images/products/1.jpg'),
                    asset('images/products/2.jpg'),
                    asset('images/products/3.jpg'),
                    asset('images/products/4.jpg'),
                    asset('images/products/5.jpg'),
                    asset('images/products/7.jpg'),
                ];
            @endphp

            @foreach($galleryImages as $gi => $gSrc)
                <div class="gallery-item">
                    <img src="{{ $gSrc }}" alt="Gallery {{ $gi + 1 }}" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================================================================
     7. TESTIMONIALS
================================================================ --}}
<section class="testi-section">
    <div class="testi-bg"></div>
    <div class="testi-bg-img">
        <div></div>
        <div></div>
    </div>

    <div class="container">
        <div class="testi-content">
            <div class="testi-header">
                <h2>Testimoni Pelanggan</h2>
                <p>Kata Mereka yang Sudah Merasakan Manisnya</p>
            </div>
            <div class="testi-grid">
                @forelse($testimonials as $tItem)
                    @include('customer.components.testimonial-card', ['testimonial' => $tItem])
                @empty
                    {{-- Dummy testimonials --}}
                    @foreach([
                        ['name' => 'Sari90',    'rating' => 5, 'review' => 'Kue ulang tahunnya tidak hanya cantik tapi juga enak banget! Keluarga sampai berebut. Terima kasih!'],
                        ['name' => 'Dewi_K',   'rating' => 5, 'review' => 'Orderan hampers lebaran sudah 3 tahun berturut-turut selalu di sini. Kualitas dan kemasannya top banget!'],
                        ['name' => 'Budi123',  'rating' => 5, 'review' => 'Pesannya gampang, responnya cepat, rasanya enak. Pokoknya recommended banget buat yang mau pesan kue!'],
                    ] as $dummy)
                        @include('customer.components.testimonial-card', ['testimonial' => $dummy])
                    @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>

</div>{{-- end page-content --}}
@endsection

@push('scripts')
<script>
    // Wishlist toggle
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
        });
    });

    // Cart button
    document.querySelectorAll('.cart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            // TODO: implement add to cart logic
            this.style.background = 'var(--brown-dark)';
            this.style.color = 'white';
            this.style.borderColor = 'var(--brown-dark)';
            setTimeout(() => {
                this.style.background = '';
                this.style.color = '';
                this.style.borderColor = '';
            }, 800);
        });
    });

    // Category active toggle
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush

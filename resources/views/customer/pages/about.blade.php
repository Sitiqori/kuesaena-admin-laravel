@extends('customer.layouts.app')

@section('title', 'About Us - Kuesaena')

@push('styles')
<style>
/* ============================================================
   ABOUT PAGE — percis sesuai desain
============================================================ */

.page-content { padding-top: 76px; }

/* ============================================================
   SECTION 1 — ABOUT US
============================================================ */
.about-hero {
    padding: 100px 0 90px;
    background: #fff;
}

.about-hero-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: start;
    padding-top: 30px;
    gap: 80px;
}

/* IMAGE */
.about-img-wrap {
    position: relative;
}

.about-main-img {
    width: 100%;
    height: 420px; display: ;
    object-fit: cover;
    border-radius: 20px;
}

.about-card-overlay {
    position: absolute;
    bottom: -30px;
    right: -200px;
    transform: translateX(-20%);
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    padding: 22px 26px;
    max-width: 400px;
}

.about-card-badge {
    background: #5C2D0E;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 6px;
    margin-bottom: 10px;
    display: inline-block;
}

.about-card-overlay p {
    font-size: 13.5px;
    color: #555;
    line-height: 1.7;
}

/* TEXT */
.about-hero-copy h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 3.5vw, 44px);
    font-weight: 800;
    color: #1A0A00;
    margin-bottom: 20px;
}

.about-hero-copy p {
    font-size: 15px;
    color: #555;
    line-height: 1.9;
}


/* ============================================================
   SECTION 2 — STORY (INI PALING PENTING)
============================================================ */
.about-story {
    margin-top: 120px;
    margin-bottom: 120px;
}

.about-story-inner {
    position: relative;
    display: flex;
    align-items: center;
}

/* 🔥 FIX CARD BIAR LEBIH ELEGAN */
.story-card {
    background: #5A4E35;
    padding: 60px 60px 60px 80px;
    width: 55%;
    border-radius: 12px;
    position: relative;
    z-index: 2;
}

.story-card p {
    font-size: 14.5px;
    color: rgba(255,255,255,0.9);
    line-height: 1.9;
}

/* 🔥 FIX GAMBAR OVERLAP */
.story-img-wrap {
    position: relative;
    width: 55%;
    margin-left: -120px; /* ini kunci overlap natural */
}

.story-img-wrap img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}


/* ============================================================
   SECTION 3 — DIGITAL
============================================================ */
.about-digital {
    padding: 100px 0;
    background: #f7f7f7;
}

.digital-grid {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    align-items: center;
    gap: 0px;
}

.digital-img-side {
    position: relative;
    display: flex;
    justify-content: center;

}

.digital-img-side::before {
    content: "";
    position: absolute;
    width: 420px;
    height: 380px;
    background: #e9efe9;

    border-radius: 60% 40% 55% 45% / 55% 55% 45% 45%;

    z-index: 1;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.digital-dots {
    position: absolute;
    width: 200px;
    height: 200px;
    top: 0;
    left: 0;

    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    opacity: 0.2;

    z-index: 0;
}

.digital-dots span {
    width: 8px;
    height: 8px;
    background: #8B4513;
    border-radius: 50%;
}

.digital-circle-img {
    width: 360px;
    height: 360px;
    object-fit: cover;
    position: relative;
    z-index: 2;

    border-radius: 40% 0% 35% 45%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}
/* TEXT */
.digital-copy h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(30px, 3vw, 42px);
    font-weight: 800;
    color: #1A0A00;
    margin-bottom: 24px;
}

.digital-copy p {
    font-size: 15px;
    color: #555;
    line-height: 1.9;
}
/* ============================================================
   SECTION 4 — GALLERY MOSAIC
============================================================ */
.about-gallery {
    margin-top: 70px;
    margin-bottom: 70px;
    background: #fff;
}

.gallery-mosaic {
    display: grid;
    grid-template-columns: 1.15fr 1fr 1fr;
    grid-template-rows: 220px 220px;
    gap: 10px;
    border-radius: 16px;
    overflow: hidden;
}

/* Foto 1 — tall, span 2 baris */
.gal-item-1 {
    grid-column: 1;
    grid-row: 1 / 3;
}

/* Foto 2 — top middle */
.gal-item-2 {
    grid-column: 2;
    grid-row: 1;
}

/* Foto 3 — top right */
.gal-item-3 {
    grid-column: 3;
    grid-row: 1;
}

/* Foto 4 — bottom middle */
.gal-item-4 {
    grid-column: 2;
    grid-row: 2;
}

/* Foto 5 — bottom right */
.gal-item-5 {
    grid-column: 3;
    grid-row: 2;
}

.gal-item {
    overflow: hidden;
    border-radius: 0;
}

.gal-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s ease;
}

.gal-item:hover img {
    transform: scale(1.06);
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 1024px) {
    .about-hero-grid { gap: 36px; }
    .digital-grid { gap: 40px; }
    .digital-circle-img { width: 280px; height: 280px; }
    .gallery-mosaic { grid-template-rows: 180px 180px; }
}

@media (max-width: 768px) {
    .about-hero-grid {
        grid-template-columns: 1fr;
    }
    .about-card-overlay {
        bottom: 12px;
        left: 12px;
    }

    .about-story-inner {
        flex-direction: column;
        min-height: unset;
    }
    .story-card {
        width: 100%;
        padding: 40px 24px;
    }
    .story-img-wrap {
        position: relative;
        top: 0;
        width: 100%;
        height: 280px;
    }
    .story-img-wrap img { border-radius: 0; }

    .digital-grid {
        grid-template-columns: 1fr;
    }
    .digital-img-side {
        justify-content: center;
    }
    .digital-circle-img { width: 240px; height: 240px; }

    .gallery-mosaic {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 180px 180px 180px;
    }
    .gal-item-1 { grid-column: 1 / 3; grid-row: 1; }
    .gal-item-2 { grid-column: 1; grid-row: 2; }
    .gal-item-3 { grid-column: 2; grid-row: 2; }
    .gal-item-4 { grid-column: 1; grid-row: 3; }
    .gal-item-5 { grid-column: 2; grid-row: 3; }
}

@media (max-width: 480px) {
    .about-hero { padding: 48px 0; }
    .about-digital { padding: 48px 0; }
    .story-card { padding: 32px 20px; }
    .story-card p { font-size: 13.5px; }
    .digital-copy h2 { font-size: 24px; }
    .gallery-mosaic { grid-template-rows: 150px 150px 150px; }
}
</style>
@endpush

@section('content')
<div class="page-content">

{{-- ============================================================
     SECTION 1 — ABOUT US
============================================================ --}}
<section class="about-hero">
    <div class="container">
        <div class="about-hero-grid">

            {{-- KIRI: gambar + card overlay --}}
            <div class="about-img-wrap">
                <img class="about-main-img"
                     src="{{ asset('images/redrose.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1558636508-e0db3814bd1d?w=600&q=80'"
                     alt="Kuesaena Cake">

                <div class="about-card-overlay">
                    <div class="about-card-badge">KUESAENA</div>
                    <p>Hadir sebagai sahabat dalam setiap perayaan — karena setiap momen berharga layak dirayakan dengan cita rasa terbaik.</p>
                </div>
            </div>

            {{-- KANAN: teks --}}
            <div class="about-hero-copy">
                <h2>ABOUT US</h2>
                <p>
                    KUESAENA merupakan toko kue asal Tasikmalaya yang menyediakan berbagai olahan kue dan dessert,
                    seperti birthday cake, wedding cake, engagement cake, dessert box, brownies, roti, tiramisu, serta cookies.
                    Kami hadir untuk melengkapi setiap momen kebahagiaan, baik untuk perayaan ulang tahun, pernikahan,
                    acara perusahaan, maupun sekadar berbagi manisnya hari kepada orang tersayang.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 2 — STORY / SEJARAH
============================================================ --}}
<section class="about-story">
    <div class="container">
        <div class="about-story-inner">

            {{-- Card teks kiri --}}
            <div class="story-card">
                <div class="story-card-inner">
                    <p>
                        Toko KUESAENA didirikan pada tahun 2021 di Tasikmalaya sebagai wujud semangat anak muda
                        untuk menghadirkan kue dan dessert berkualitas bagi semua kalangan. Berawal dari dapur
                        rumahan, KUESAENA terus berkembang hingga kini menjadi salah satu UMKM kuliner unggulan
                        yang dikenal dengan produk kreatif dan tampilan menarik.
                    </p>
                    <p>
                        Nama KUESAENA diambil dari filosofi "kue yang enak dan penuh makna" — mencerminkan
                        komitmen kami untuk terus menghadirkan kebahagiaan lewat cita rasa dan keindahan tampilan produk.
                    </p>
                </div>
            </div>

            {{-- Gambar kanan — overlap --}}
            <div class="story-img-wrap">
                <img src="{{ asset('images/bakingg.png') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1608198093002-ad4e005484ec?w=800&q=80'"
                     alt="Proses Pembuatan Kue">
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 3 — TRANSFORMASI DIGITAL
============================================================ --}}
<section class="about-digital">
    <div class="container">
        <div class="digital-grid">

            {{-- KIRI: gambar lingkaran + dot background --}}
            <div class="digital-img-side">
                {{-- Dot dekorasi --}}
                <div class="digital-dots">
                    @for($d = 0; $d < 42; $d++)
                        <span></span>
                    @endfor
                </div>
                <img class="digital-circle-img"
                     src="{{ asset('images/about-digital.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1587248720327-8eb72564be1e?w=600&q=80'"
                     alt="Transformasi Digital Kuesaena">
            </div>

            {{-- KANAN: teks --}}
            <div class="digital-copy">
                <h2>Transformasi Digital<br>dan Pengembangan</h2>
                <p>
                    Seiring berjalannya waktu, KUESAENA melakukan transformasi digital dengan mengembangkan
                    website manajemen toko berbasis web. Sistem ini membantu kami dalam manajemen inventori,
                    pengelolaan data pelanggan, serta pemesanan terintegrasi agar pelanggan dapat menikmati
                    layanan yang cepat dan efisien.
                </p>
                <p>
                    Kini, KUESAENA terus berinovasi untuk memperluas jangkauan pasar dan meningkatkan kualitas
                    layanan. Kami percaya bahwa melalui digitalisasi, UMKM lokal dapat tumbuh lebih kuat dan
                    membawa kebahagiaan ke lebih banyak orang.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 4 — GALLERY MOSAIC
============================================================ --}}
<section class="about-gallery">
    <div class="container">
        <div class="gallery-mosaic">

            {{-- Foto 1: tall kiri --}}
            <div class="gal-item gal-item-1">
                <img src="{{ asset('images/gallery-1.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1587248720327-8eb72564be1e?w=600&q=80'"
                     alt="Gallery 1">
            </div>

            {{-- Foto 2: top tengah --}}
            <div class="gal-item gal-item-2">
                <img src="{{ asset('images/gallery-2.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1562777717-dc6984f65a63?w=500&q=80'"
                     alt="Gallery 2">
            </div>

            {{-- Foto 3: top kanan --}}
            <div class="gal-item gal-item-3">
                <img src="{{ asset('images/gallery-3.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1571506165871-ee72a35bc9d4?w=500&q=80'"
                     alt="Gallery 3">
            </div>

            {{-- Foto 4: bottom tengah --}}
            <div class="gal-item gal-item-4">
                <img src="{{ asset('images/gallery-4.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=500&q=80'"
                     alt="Gallery 4">
            </div>

            {{-- Foto 5: bottom kanan --}}
            <div class="gal-item gal-item-5">
                <img src="{{ asset('images/gallery-5.jpg') }}"
                     onerror="this.src='https://images.unsplash.com/photo-1535141192574-5d4897c12636?w=500&q=80'"
                     alt="Gallery 5">
            </div>

        </div>
    </div>
</section>

</div>{{-- end page-content --}}
@endsection

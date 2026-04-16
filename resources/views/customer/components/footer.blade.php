<style>
/* ===== CONTACT SECTION ===== */
.contact-section {
    background: #EAF4F8;
    padding: 72px 0;
}

.contact-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 48px;
    flex-wrap: wrap;
}

.contact-copy .section-label {
    color: var(--brown-main);
}

.contact-copy h2 {
    font-size: clamp(22px, 3vw, 36px);
    color: var(--text-dark);
    margin-top: 8px;
    max-width: 400px;
    line-height: 1.3;
}

.contact-copy p {
    margin-top: 12px;
    font-size: 14px;
    color: var(--text-muted);
    max-width: 340px;
}

.contact-form-row {
    display: flex;
    align-items: center;
    gap: 0;
    min-width: 340px;
    max-width: 480px;
    flex: 1;
}

.contact-email-input {
    flex: 1;
    height: 52px;
    padding: 0 20px;
    border: 1.5px solid #C8DDE5;
    border-right: none;
    border-radius: 50px 0 0 50px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-dark);
    background: var(--white);
    outline: none;
    transition: border-color 0.25s;
}

.contact-email-input:focus {
    border-color: var(--brown-mid);
}

.contact-email-input::placeholder {
    color: #9DB3BC;
}

.contact-submit-btn {
    height: 52px;
    padding: 0 28px;
    background: var(--brown-dark);
    color: var(--white);
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.8px;
    border-radius: 0 50px 50px 0;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    font-family: 'DM Sans', sans-serif;
    white-space: nowrap;
}

.contact-submit-btn:hover {
    background: var(--brown-main);
}

/* ===== FOOTER ===== */
.site-footer {
    background: #3B1A08;
    color: var(--cream-main);
    padding: 64px 0 0;
}

.footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.3fr;
    gap: 48px;
    padding-bottom: 48px;
}

/* Brand column */
.footer-brand .brand-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.footer-brand .brand-logo {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.25);
    background: rgb(255, 255, 255);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--cream-main);
    overflow: hidden;
}

.footer-brand .brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.footer-brand .brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: var(--white);
    letter-spacing: 1px;
}

.footer-tagline {
    font-size: 14px;
    font-weight: 600;
    color: var(--cream-dark);
    margin-bottom: 10px;
}

.footer-desc {
    font-size: 13px;
    color: rgba(245,236,216,0.65);
    line-height: 1.8;
}

/* Footer columns */
.footer-col h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--cream-dark);
    margin-bottom: 20px;
}

.footer-col ul {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.footer-col ul li a {
    font-size: 14px;
    color: rgba(245,236,216,0.65);
    transition: color 0.2s ease;
}

.footer-col ul li a:hover {
    color: var(--cream-main);
    padding-left: 4px;
}

/* Contact column */
.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 14px;
}

.footer-contact-item i {
    color: var(--brown-light);
    font-size: 14px;
    margin-top: 2px;
    flex-shrink: 0;
    width: 16px;
}

.footer-contact-item span {
    font-size: 14px;
    color: rgba(245,236,216,0.7);
    line-height: 1.5;
}

/* Footer Bottom */
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 20px 0;
    text-align: center;
}

.footer-bottom p {
    font-size: 13px;
    color: rgba(245,236,216,0.45);
}

/* Responsive */
@media (max-width: 1024px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
}

@media (max-width: 640px) {
    .footer-grid { grid-template-columns: 1fr; gap: 28px; }
    .contact-inner { flex-direction: column; align-items: flex-start; }
    .contact-form-row { min-width: unset; width: 100%; }
    .contact-inner > * { width: 100%; }
}
</style>

{{-- ===== CONTACT / NEWSLETTER SECTION ===== --}}
<section class="contact-section">
    <div class="container">
        <div class="contact-inner">
            <div class="contact-copy">
                <p class="section-label">USER CONTACT</p>
                <h2>Contact Us for those interested.</h2>
                <p>Tertarik dengan produk kami? Hubungi kami dan dapatkan penawaran spesial untuk pesanan pertamamu.</p>
            </div>
            <div class="contact-form-row">
                <input type="email"
                       class="contact-email-input"
                       placeholder="Enter your email address">
                <button class="contact-submit-btn" type="button">SUBMIT</button>
            </div>
        </div>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Brand --}}
            <div class="footer-brand">
                <div class="brand-row">
                    <div class="brand-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Kuesaena">
                    </div>
                    <span class="brand-name">KUESAENA</span>
                </div>
                <p class="footer-tagline">Your Sweetness Start From Here</p>
                <p class="footer-desc">Berbagi Kebahagiaan, Satu Gigitan Manis pada Satu Waktu. Kami menghadirkan kebahagiaan sederhana melalui kreasi rasa yang dibuat dengan hati.</p>
            </div>

            {{-- Produk Kami --}}
            <div class="footer-col">
                <h4>Produk Kami</h4>
                <ul>
                    <li><a href="#">Kue Ulang Tahun</a></li>
                    <li><a href="#">Kue Kering &amp; Cookies</a></li>
                    <li><a href="#">Roti &amp; Pastry</a></li>
                    <li><a href="#">Kue Custom</a></li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div class="footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Pengiriman &amp; Pickup</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>

            {{-- Hubungi Kami --}}
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Manis No. 123, Jakarta</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>hello@kuesaena.com</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+62 812-3456-7890</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Buka: Senin–Minggu, 8.00–20.00 WIB</span>
                </div>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>@ Copyright 2025, All Rights Reserved by Kuesaena</p>
        </div>
    </div>
</footer>

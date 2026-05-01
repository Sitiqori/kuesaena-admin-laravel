{{--
    Testimonial Card Component
    Usage: @include('customer.components.testimonial-card', ['testimonial' => $item])

    $testimonial fields:
        - name    : nama reviewer
        - rating  : 1-5
        - review  : teks ulasan
        - avatar  : (optional) URL foto
--}}

@php
    $name   = $testimonial['name']   ?? 'Pelanggan';
    $rating = $testimonial['rating'] ?? 5;
    $review = $testimonial['review'] ?? '';
    $avatar = $testimonial['avatar'] ?? null;
@endphp

<div class="testi-card">
    <div class="testi-card__header">
        <div class="testi-avatar">
            @if($avatar)
                <img src="{{ $avatar }}" alt="{{ $name }}">
            @else
                <div class="testi-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>
        <div class="testi-meta">
            <span class="testi-name">{{ $name }}</span>
            <div class="testi-stars">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $rating ? 'filled' : '' }}"></i>
                @endfor
            </div>
        </div>
    </div>
    <p class="testi-review">{{ $review }}</p>
</div>

<style>
/* ===== TESTIMONIAL CARD ===== */
.testi-card {
    background: rgba(255,255,255,0.95);
    border-radius: var(--radius-lg);
    padding: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    backdrop-filter: blur(8px);
}

.testi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.25);
}

.testi-card__header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}

.testi-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--cream-dark);
    border: 2px solid rgba(91,45,14,0.15);
}

.testi-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testi-avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #D4B89A;
    color: var(--white);
    font-size: 20px;
}

.testi-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-dark);
    display: block;
    margin-bottom: 4px;
}

.testi-stars {
    display: flex;
    gap: 2px;
}

.testi-stars i {
    font-size: 13px;
    color: #DDD;
}

.testi-stars i.filled {
    color: #F59E0B;
}

.testi-review {
    font-size: 13px;
    color: var(--text-mid);
    line-height: 1.7;
}
</style>

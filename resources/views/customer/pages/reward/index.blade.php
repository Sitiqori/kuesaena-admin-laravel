@extends('customer.pages.profil.layout')

@push('styles')
<style>
.reward-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

@media (max-width: 900px) {
    .reward-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 640px) {
    .reward-grid { grid-template-columns: repeat(2, 1fr); }
}

.reward-card {
    background: #fff;
    border: 1.5px solid #ede0d0;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
}
.reward-card:hover {
    border-color: #C68B5A;
    box-shadow: 0 6px 20px rgba(91,45,14,0.13);
    transform: translateY(-3px);
}
.reward-card-thumb {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    display: block;
}
.reward-card-placeholder {
    width: 100%;
    aspect-ratio: 1 / 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
}
.reward-card-body {
    padding: 10px 12px 13px;
}
.reward-card-name {
    font-size: 13px;
    font-weight: 600;
    color: #1A0A00;
    line-height: 1.35;
    margin-bottom: 7px;
}
.reward-coin-row {
    display: flex;
    align-items: center;
    gap: 5px;
}
.coin-circle {
    width: 22px;
    height: 22px;
    background: #e8d5b7;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.coin-circle i { font-size: 9px; color: #7B3F18; }
.reward-coin-num { font-size: 14px; font-weight: 800; color: #3B1A08; }
.reward-coin-label { font-size: 12px; color: #8B6050; }

/* coin badge top-right */
.coin-badge-header {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #3B1A08;
    color: #fff;
    padding: 9px 16px;
    border-radius: 22px;
    font-size: 13px;
    font-weight: 700;
}
.coin-badge-header .cbh-icon {
    width: 26px; height: 26px;
    background: #e8d5b7;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.coin-badge-header .cbh-icon i { font-size: 11px; color: #7B3F18; }

/* Placeholder gradient map per index */
</style>
@endpush

@section('profil-content')

@php
    $user = Auth::user();
    $placeholderColors = [
        '#f9e4c8','#fde9d5','#e8f4e8','#d5e8f4',
        '#f4d5e8','#f4f4d5','#d5f4e8',
    ];
    $placeholderIcons = [
        'fa-birthday-cake','fa-cookie','fa-ice-cream',
        'fa-birthday-cake','fa-cookie','fa-ice-cream','fa-birthday-cake',
    ];
@endphp

{{-- ===== HEADER ===== --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #ede0d0; flex-wrap:wrap; gap:12px;">
    <h2 class="profil-section-title" style="margin:0; padding:0; border:none;">REWARD SAYA</h2>
    <div class="coin-badge-header">
        <div class="cbh-icon"><i class="fas fa-dollar-sign"></i></div>
        <span>{{ number_format($userCoins) }} Koin Tersedia</span>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert-success" style="margin-bottom:16px;"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px; display:flex; align-items:center; gap:8px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- ===== REWARD GRID ===== --}}
@if($rewards->isEmpty())
    <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:80px 24px; color:#8B6050;">
        <i class="fas fa-gift" style="font-size:48px; color:#d4bfa0; margin-bottom:16px;"></i>
        <p style="font-size:15px; font-weight:600; color:#4A2C10; margin-bottom:6px;">Belum ada reward tersedia</p>
        <p style="font-size:13px;">Terus belanja untuk mengumpulkan koin!</p>
    </div>
@else
    <div class="reward-grid">
        @foreach($rewards as $i => $reward)
        @php
            $bgColor  = $placeholderColors[$i % count($placeholderColors)];
            $iconName = $placeholderIcons[$i % count($placeholderIcons)];
            $canAfford = $userCoins >= $reward->cost_coins;
        @endphp
        <div class="reward-card"
             onclick="openRedeemModal(
                 {{ $reward->id }},
                 '{{ addslashes($reward->name) }}',
                 '{{ addslashes($reward->description ?? '') }}',
                 {{ $reward->cost_coins }},
                 '{{ $reward->image ? asset('storage/'.$reward->image) : '' }}'
             )"
             title="{{ $reward->name }}">

            {{-- Thumb --}}
            @if($reward->image)
                <img src="{{ asset('storage/' . $reward->image) }}" class="reward-card-thumb" alt="{{ $reward->name }}">
            @else
                <div class="reward-card-placeholder" style="background:{{ $bgColor }};">
                    <i class="fas {{ $iconName }}" style="color:#A0522D; opacity:0.7;"></i>
                </div>
            @endif

            {{-- Body --}}
            <div class="reward-card-body">
                <p class="reward-card-name">{{ $reward->name }}</p>
                <div class="reward-coin-row">
                    <div class="coin-circle"><i class="fas fa-dollar-sign"></i></div>
                    <span class="reward-coin-num">{{ number_format($reward->cost_coins) }}</span>
                    <span class="reward-coin-label">Koin</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- ===== MODAL REDEEM ===== --}}
<div id="modal-redeem" class="modal-overlay">
    <div class="modal-box" style="max-width:400px;">
        <h3 class="modal-title"><i class="fas fa-gift" style="color:#5C2D0E; margin-right:8px;"></i>Tukar Reward</h3>

        <div id="redeem-thumb-wrap" style="width:100%; height:160px; border-radius:12px; overflow:hidden; margin-bottom:16px; background:#f5ead8; display:flex; align-items:center; justify-content:center;">
            <img id="redeem-thumb-img" src="" alt="" style="width:100%; height:100%; object-fit:cover; display:none;">
            <i id="redeem-thumb-icon" class="fas fa-birthday-cake" style="font-size:48px; color:#C68B5A;"></i>
        </div>

        <p id="redeem-name" style="font-size:16px; font-weight:700; color:#1A0A00; margin-bottom:4px;"></p>
        <p id="redeem-desc" style="font-size:13px; color:#8B6050; margin-bottom:16px; line-height:1.6;"></p>

        <div style="background:#faf5ee; border-radius:10px; padding:14px 16px; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:10px; border-bottom:1px solid #ede0d0; margin-bottom:10px;">
                <span style="font-size:13px; color:#8B6050;">Koin dibutuhkan</span>
                <div style="display:flex; align-items:center; gap:6px;">
                    <div class="coin-circle"><i class="fas fa-dollar-sign"></i></div>
                    <span id="redeem-cost" style="font-size:15px; font-weight:700; color:#3B1A08;"></span>
                    <span style="font-size:12px; color:#8B6050;">Koin</span>
                </div>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; color:#8B6050;">Koin kamu</span>
                <div style="display:flex; align-items:center; gap:6px;">
                    <div class="coin-circle"><i class="fas fa-dollar-sign"></i></div>
                    <span style="font-size:15px; font-weight:700; color:{{ $userCoins > 0 ? '#27ae60' : '#8B6050' }};">{{ number_format($userCoins) }}</span>
                    <span style="font-size:12px; color:#8B6050;">Koin</span>
                </div>
            </div>
            <div id="redeem-insufficient" style="display:none; margin-top:10px; padding:8px 12px; background:#f8d7da; border-radius:8px; font-size:12px; color:#721c24;">
                <i class="fas fa-exclamation-circle" style="margin-right:4px;"></i>Koin kamu tidak cukup untuk reward ini.
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-ghost" onclick="closeModal('modal-redeem')">Batal</button>
            <form id="form-redeem" method="POST" style="display:inline;">
                @csrf
                <button type="submit" id="btn-redeem" class="btn-brown">
                    <i class="fas fa-exchange-alt" style="margin-right:6px;"></i>Tukar Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const userCoins = {{ $userCoins }};

function openRedeemModal(id, name, desc, cost, imgUrl) {
    const baseUrl = '{{ url("reward-saya") }}';
    document.getElementById('form-redeem').action = baseUrl + '/' + id + '/redeem';
    document.getElementById('redeem-name').textContent  = name;
    document.getElementById('redeem-desc').textContent  = desc || '';
    document.getElementById('redeem-cost').textContent  = cost.toLocaleString('id-ID');

    // Thumbnail
    const img  = document.getElementById('redeem-thumb-img');
    const icon = document.getElementById('redeem-thumb-icon');
    if (imgUrl) {
        img.src = imgUrl;
        img.style.display  = 'block';
        icon.style.display = 'none';
    } else {
        img.style.display  = 'none';
        icon.style.display = 'block';
    }

    // Koin check
    const insufficient = document.getElementById('redeem-insufficient');
    const btn = document.getElementById('btn-redeem');
    if (userCoins < cost) {
        insufficient.style.display = 'block';
        btn.disabled = true;
        btn.style.opacity = '0.45';
        btn.style.cursor  = 'not-allowed';
    } else {
        insufficient.style.display = 'none';
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor  = 'pointer';
    }

    openModal('modal-redeem');
}
</script>
@endpush

@endsection
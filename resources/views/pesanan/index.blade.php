@extends('layouts.partials.master')

@section('title', 'Manajemen Pesanan')
@section('page-title', 'Manajemen Pesanan')

@push('styles')
<style>
    .stats-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: #C19A6B;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-info h4 {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .stat-info .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }

    .tabs-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .tabs-header {
        display: flex;
        border-bottom: 2px solid #f0f0f0;
    }

    .tab-button {
        flex: 1;
        padding: 18px 20px;
        background: none;
        border: none;
        font-size: 15px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }

    .tab-button:hover {
        background: #f8f8f8;
    }

    .tab-button.active {
        color: #5C4033;
        border-bottom-color: #5C4033;
        background: #faf8f6;
    }

    .tab-content {
        display: none;
        padding: 25px;
    }

    .tab-content.active {
        display: block;
    }

    .orders-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
    }

    .order-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        gap: 15px;
        transition: all 0.3s;
        background: white;
    }

    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #5C4033;
    }

    .order-checkbox {
        display: flex;
        align-items: flex-start;
        padding-top: 5px;
    }

    .order-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .order-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .order-info {
        flex: 1;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .order-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .order-size {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }

    .order-note {
        font-size: 13px;
        color: #5C4033;
        margin-bottom: 8px;
        font-style: italic;
    }

    .order-address {
        font-size: 13px;
        color: #666;
    }

    .order-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-end;
    }

    .order-date {
        font-size: 12px;
        color: #999;
    }

    .order-price {
        font-size: 18px;
        font-weight: 700;
        color: #5C4033;
    }

    .order-customer {
        font-size: 13px;
        color: #666;
        margin-top: 4px;
    }

    .order-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-process {
        background: #2196F3;
        color: white;
    }

    .btn-process:hover {
        background: #1976D2;
    }

    .btn-complete {
        background: #4CAF50;
        color: white;
    }

    .btn-complete:hover {
        background: #388E3C;
    }

    .btn-cancel {
        background: #f44336;
        color: white;
    }

    .btn-cancel:hover {
        background: #d32f2f;
    }

    .btn-detail {
        background: #f5f5f5;
        color: #333;
    }

    .btn-detail:hover {
        background: #e0e0e0;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 15px;
        opacity: 0.3;
    }

    .empty-text {
        font-size: 16px;
        color: #666;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3e0;
        color: #e65100;
    }

    .status-processing {
        background: #e3f2fd;
        color: #1565c0;
    }

    .status-completed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    /* Modal Detail */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        overflow-y: auto;
    }

    .modal.show {
        display: flex;
    }

    .modal-dialog {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 700px;
        margin: 20px;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 600;
    }

    .close-modal {
        font-size: 28px;
        cursor: pointer;
        color: #999;
        line-height: 1;
    }

    .modal-body {
        padding: 20px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .detail-section {
        margin-bottom: 20px;
    }

    .detail-section h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #5C4033;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .detail-label {
        color: #666;
    }

    .detail-value {
        font-weight: 500;
        color: #333;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -22px;
        top: 8px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #5C4033;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: -17px;
        top: 20px;
        width: 2px;
        height: calc(100% - 8px);
        background: #e0e0e0;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    .timeline-time {
        font-size: 12px;
        color: #999;
        margin-bottom: 4px;
    }

    .timeline-content {
        font-size: 14px;
        color: #333;
    }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <h4>Pesanan Baru</h4>
            <div class="stat-value">{{ $newOrders->count() }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-info">
            <h4>Pesanan Diproses</h4>
            <div class="stat-value">{{ $processingOrders->count() }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✓</div>
        <div class="stat-info">
            <h4>Selesai Hari Ini</h4>
            <div class="stat-value">{{ $completedToday }}</div>
        </div>
    </div>
</div>


@if(session('success'))
<div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
    ✓ {{ session('success') }}
</div>
@endif

<!-- Tabs -->
<div class="tabs-container">
    <div class="tabs-header">
        <button class="tab-button active" onclick="switchTab('new')">
            Pesanan Baru
        </button>
        <button class="tab-button" onclick="switchTab('processing')">
            Pesanan Diproses
        </button>
    </div>

    <!-- Tab Content: Pesanan Baru -->
    <div class="tab-content active" id="tab-new">
        <div class="orders-grid" style="display:grid; grid-template-columns:1fr; gap:15px;">
            @forelse($newOrders as $order)
            <div class="order-card">
                <div class="order-checkbox">
                    <input type="checkbox" id="order-{{ $order->id }}">
                </div>

                @php $img = $order->orderItems->first()?->product?->image; @endphp
                <img src="{{ $img ? (str_starts_with($img, 'images/') ? asset($img) : asset('storage/'.$img)) : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80' }}"
                    alt="{{ $order->orderItems->first()?->product?->name ?? 'Produk tidak tersedia' }}"
                     class="order-image">

                <div class="order-info">
                    <div class="order-header">
                        <div>
                           <div class="order-title">{{ $order->orderItems->first()?->product?->name ?? 'Produk tidak tersedia' }}</div>
                            <div class="order-size">Size: {{ $order->orderItems->first()?->product?->code ?? '-' }}</div>
                            <div class="order-note">
                                Note: {{ $order->orderItems->first()?->product?->description ?? '-' }}
                            </div>
                            <div class="order-address">
                                Alamat: {{ $order->customer->address ?? 'Jalan Nanjak No.17 Kota Tasikmalaya' }}
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <button class="btn-action btn-process" onclick="updateStatus({{ $order->id }}, 'processing')">
                            <i class="fas fa-hourglass-half"></i> Proses
                        </button>
                        <button class="btn-action btn-detail" onclick="showOrderDetail({{ $order->id }})">
                            👁️ Detail
                        </button>
                        <button class="btn-action btn-cancel" onclick="updateStatus({{ $order->id }}, 'cancelled')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </div>
                </div>

                <div class="order-meta">
                    <div class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    <div class="order-price">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    <div class="order-customer">{{ $order->customer->name ?? 'Pelanggan' }}</div>
                    <span class="status-badge status-pending">Pending</span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-box"></i></div>
                <div class="empty-text">Tidak ada pesanan baru</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Tab Content: Pesanan Diproses -->
    <div class="tab-content" id="tab-processing">
        <div class="orders-grid" style="display:grid; grid-template-columns:1fr; gap:15px;">
            @forelse($processingOrders as $order)
            <div class="order-card">
                <div class="order-checkbox">
                    <input type="checkbox" id="order-{{ $order->id }}">
                </div>

                @php $img2 = $order->orderItems->first()?->product?->image; @endphp
                <img src="{{ $img2 ? (str_starts_with($img2, 'images/') ? asset($img2) : asset('storage/'.$img2)) : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&q=80' }}"
                    alt="{{ $order->orderItems->first()?->product?->name ?? 'Produk tidak tersedia' }}"
                    class="order-image">

                <div class="order-info">
                    <div class="order-header">
                        <div>
                            <div class="order-title">{{ $order->orderItems->first()?->product?->name ?? 'Produk tidak tersedia' }}</div>
                            <div class="order-size">Size: {{ $order->orderItems->first()?->product?->code ?? '-' }}</div>
                            <div class="order-note">
                                Note: {{ $order->orderItems->first()?->product?->description ?? '-' }}
                            </div>
                            <div class="order-address">
                                Alamat: {{ $order->customer->address ?? 'Jalan Nanjak No.17 Kota Tasikmalaya' }}
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <button class="btn-action btn-complete" onclick="updateStatus({{ $order->id }}, 'completed')">
                            ✓ Selesai
                        </button>
                        <button class="btn-action btn-detail" onclick="showOrderDetail({{ $order->id }})">
                            👁️ Detail
                        </button>
                        <button class="btn-action btn-cancel" onclick="updateStatus({{ $order->id }}, 'cancelled')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </div>
                </div>

                <div class="order-meta">
                    <div class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    <div class="order-price">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    <div class="order-customer">{{ $order->customer->name ?? 'Pelanggan' }}</div>
                    <span class="status-badge status-processing">Diproses</span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="empty-text">Tidak ada pesanan yang sedang diproses</div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
/* ── Toast ── */
#ps-toast-wrap { position:fixed; bottom:24px; right:24px; z-index:99999; display:flex; flex-direction:column; gap:10px; pointer-events:none; }
.ps-toast { display:flex; align-items:flex-start; gap:12px; background:#fff; border-radius:12px; padding:14px 18px; min-width:260px; max-width:340px; box-shadow:0 8px 30px rgba(0,0,0,0.13); pointer-events:all; transform:translateX(120%); opacity:0; transition:transform .35s cubic-bezier(.34,1.56,.64,1), opacity .3s ease; border-left:4px solid #5C2D0E; }
.ps-toast.show { transform:translateX(0); opacity:1; }
.ps-toast.hide { transform:translateX(120%); opacity:0; }
.ps-toast-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:14px; }
.ps-toast-icon.s { background:#f0fdf4; color:#16a34a; }
.ps-toast-icon.e { background:#fff5f5; color:#e74c3c; }
.ps-toast-icon.w { background:#fffbeb; color:#d97706; }
.ps-toast-body { flex:1; }
.ps-toast-title { font-size:13px; font-weight:700; color:#1A0A00; margin-bottom:2px; }
.ps-toast-msg   { font-size:12px; color:#6b7280; }
.ps-toast-close { background:none; border:none; cursor:pointer; color:#aaa; font-size:16px; flex-shrink:0; }

/* ── Confirm Overlay ── */
#ps-confirm-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:999998; align-items:center; justify-content:center; backdrop-filter:blur(2px); }
#ps-confirm-overlay.open { display:flex; }
#ps-confirm-box { background:#fff; border-radius:18px; padding:32px 28px 24px; width:360px; max-width:92vw; box-shadow:0 24px 60px rgba(0,0,0,0.18); text-align:center; transform:scale(0.92); opacity:0; transition:transform .22s cubic-bezier(.34,1.56,.64,1), opacity .18s ease; }
#ps-confirm-overlay.open #ps-confirm-box { transform:scale(1); opacity:1; }
#ps-confirm-icon-wrap { width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:22px; }
#ps-confirm-title { font-size:16px; font-weight:700; color:#1A0A00; margin-bottom:8px; }
#ps-confirm-msg   { font-size:13px; color:#6b7280; line-height:1.6; margin-bottom:22px; }
.ps-confirm-btns  { display:flex; gap:10px; justify-content:center; }
.ps-btn-cancel { padding:10px 26px; border-radius:20px; border:1.5px solid #ddd; background:#fff; font-size:14px; font-weight:500; cursor:pointer; color:#555; transition:all .2s; min-width:95px; }
.ps-btn-cancel:hover { border-color:#888; color:#222; }
.ps-btn-ok     { padding:10px 26px; border-radius:20px; border:none; background:#c0392b; color:#fff; font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; min-width:95px; }
.ps-btn-ok:hover { background:#a93226; }
.ps-btn-ok.brown { background:#3B1A08; }
.ps-btn-ok.brown:hover { background:#5C2D0E; }

/* ── Detail Modal ── */
#ps-detail-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:999997; align-items:center; justify-content:center; backdrop-filter:blur(2px); padding:20px; }
#ps-detail-overlay.open { display:flex; }
#ps-detail-box { background:#fff; border-radius:18px; width:100%; max-width:620px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 24px 60px rgba(0,0,0,0.18); transform:scale(0.92); opacity:0; transition:transform .22s cubic-bezier(.34,1.56,.64,1), opacity .18s ease; }
#ps-detail-overlay.open #ps-detail-box { transform:scale(1); opacity:1; }
.ps-detail-head { padding:20px 24px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center; }
.ps-detail-head h3 { font-size:17px; font-weight:700; color:#1A0A00; }
.ps-detail-close { width:32px; height:32px; border-radius:50%; border:none; background:#f5f5f5; cursor:pointer; font-size:18px; color:#666; display:flex; align-items:center; justify-content:center; }
.ps-detail-close:hover { background:#e0e0e0; }
.ps-detail-body { padding:20px 24px; overflow-y:auto; flex:1; }
.ps-section { margin-bottom:18px; }
.ps-section-title { font-size:12px; font-weight:700; color:#5C4033; text-transform:uppercase; letter-spacing:.5px; margin-bottom:10px; }
.ps-row { display:flex; justify-content:space-between; padding:7px 0; border-bottom:1px solid #f5f5f5; font-size:14px; }
.ps-row:last-child { border-bottom:none; }
.ps-row-label { color:#666; }
.ps-row-value { font-weight:500; color:#333; text-align:right; }
.ps-item-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f5f5; }
.ps-item-row:last-child { border-bottom:none; }
.ps-item-name { font-size:14px; font-weight:600; color:#333; }
.ps-item-qty  { font-size:12px; color:#999; }
.ps-item-price { font-size:14px; font-weight:600; color:#5C4033; }
.ps-total-row { display:flex; justify-content:space-between; padding:12px 0; font-size:15px; font-weight:700; color:#5C4033; border-top:2px solid #5C4033; margin-top:6px; }
</style>

<!-- Toast container -->
<div id="ps-toast-wrap"></div>

<!-- Confirm overlay -->
<div id="ps-confirm-overlay">
    <div id="ps-confirm-box">
        <div id="ps-confirm-icon-wrap"><i id="ps-confirm-icon" class="fas fa-question"></i></div>
        <div id="ps-confirm-title">Konfirmasi</div>
        <div id="ps-confirm-msg"></div>
        <div class="ps-confirm-btns">
            <button class="ps-btn-cancel" id="ps-btn-cancel">Batal</button>
            <button class="ps-btn-ok" id="ps-btn-ok">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<!-- Detail overlay -->
<div id="ps-detail-overlay">
    <div id="ps-detail-box">
        <div class="ps-detail-head">
            <h3>Detail Pesanan</h3>
            <button class="ps-detail-close" onclick="closeDetail()">&times;</button>
        </div>
        <div class="ps-detail-body" id="ps-detail-body"></div>
    </div>
</div>

<script>
// ── Toast ──
function psToast(title, msg, type) {
    var icons = { s:'<i class="fas fa-check"></i>', e:'<i class="fas fa-times"></i>', w:'<i class="fas fa-exclamation"></i>' };
    var borders = { s:'#16a34a', e:'#e74c3c', w:'#d97706' };
    var t = document.createElement('div');
    t.className = 'ps-toast';
    t.style.borderLeftColor = borders[type] || borders.s;
    t.innerHTML = '<div class="ps-toast-icon '+(type||'s')+'">'+(icons[type]||icons.s)+'</div>'
        + '<div class="ps-toast-body"><div class="ps-toast-title">'+title+'</div>'+(msg?'<div class="ps-toast-msg">'+msg+'</div>':'')+'</div>'
        + '<button class="ps-toast-close" onclick="this.closest(\'.ps-toast\').remove()">&times;</button>';
    document.getElementById('ps-toast-wrap').appendChild(t);
    requestAnimationFrame(function(){ requestAnimationFrame(function(){ t.classList.add('show'); }); });
    setTimeout(function(){ t.classList.remove('show'); t.classList.add('hide'); setTimeout(function(){ t.remove(); }, 400); }, 4000);
}

// ── Confirm ──
var _psResolve = null;
(function(){
    var ov  = document.getElementById('ps-confirm-overlay');
    var ok  = document.getElementById('ps-btn-ok');
    var can = document.getElementById('ps-btn-cancel');
    function close(r){ ov.classList.remove('open'); if(_psResolve){ _psResolve(r); _psResolve=null; } }
    ok.addEventListener('click',  function(){ close(true);  });
    can.addEventListener('click', function(){ close(false); });
    ov.addEventListener('click',  function(e){ if(e.target===ov) close(false); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape' && ov.classList.contains('open')) close(false); });
})();

function psConfirm(msg, opts) {
    opts = opts || {};
    var type = opts.type || 'danger';
    var iconMap   = { danger:'fa-trash-alt', warning:'fa-exclamation-triangle', info:'fa-question-circle' };
    var colorMap  = { danger:'#fff5f5', warning:'#fffbeb', info:'#fdf5ee' };
    var icColMap  = { danger:'#e74c3c', warning:'#d97706', info:'#5C2D0E' };
    var wrap = document.getElementById('ps-confirm-icon-wrap');
    var icon = document.getElementById('ps-confirm-icon');
    wrap.style.background = colorMap[type] || colorMap.danger;
    icon.className = 'fas ' + (iconMap[type] || iconMap.danger);
    icon.style.color = icColMap[type] || icColMap.danger;
    document.getElementById('ps-confirm-title').textContent = opts.title || 'Konfirmasi';
    document.getElementById('ps-confirm-msg').textContent   = msg;
    var btnOk = document.getElementById('ps-btn-ok');
    btnOk.textContent = opts.okText || 'Ya, Lanjutkan';
    btnOk.className = 'ps-btn-ok' + (type === 'info' ? ' brown' : '');
    document.getElementById('ps-btn-cancel').textContent = opts.cancelText || 'Batal';
    document.getElementById('ps-confirm-overlay').classList.add('open');
    return new Promise(function(resolve){ _psResolve = resolve; });
}

// ── Tab Switch ──
function switchTab(tab) {
    document.querySelectorAll('.tab-button').forEach(function(b){ b.classList.remove('active'); });
    event.target.classList.add('active');
    document.querySelectorAll('.tab-content').forEach(function(c){ c.classList.remove('active'); });
    document.getElementById('tab-' + tab).classList.add('active');
}

// ── Update Status ──
function updateStatus(orderId, status) {
    var msgs   = { processing:'Pesanan ini akan mulai diproses.', completed:'Tandai pesanan ini sebagai selesai?', cancelled:'Pesanan ini akan dibatalkan.' };
    var titles = { processing:'Proses Pesanan?', completed:'Selesaikan Pesanan?', cancelled:'Batalkan Pesanan?' };
    var types  = { processing:'info', completed:'info', cancelled:'danger' };
    var okTxts = { processing:'Ya, Proses', completed:'Ya, Selesai', cancelled:'Ya, Batalkan' };

    psConfirm(msgs[status] || 'Yakin melanjutkan?', {
        title:  titles[status]  || 'Konfirmasi',
        type:   types[status]   || 'info',
        okText: okTxts[status]  || 'Ya',
    }).then(function(ok) {
        if (!ok) return;
        fetch('{{ url('/pesanan') }}/' + orderId + '/update-status', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ status: status })
        })
        .then(function(r){ return r.json(); })
        .then(function(data) {
            if (data.success) {
                psToast('Berhasil', 'Status pesanan berhasil diperbarui.', 's');
                setTimeout(function(){ location.reload(); }, 1200);
            } else {
                psToast('Gagal', data.message || 'Gagal mengupdate status.', 'e');
            }
        })
        .catch(function() { psToast('Error', 'Terjadi kesalahan koneksi.', 'e'); });
    });
}

// ── Detail Pesanan ──
function showOrderDetail(orderId) {
    document.getElementById('ps-detail-body').innerHTML = '<div style="text-align:center;padding:40px;color:#999;"><i class="fas fa-spinner fa-spin" style="font-size:24px;"></i></div>';
    document.getElementById('ps-detail-overlay').classList.add('open');

    fetch('{{ url('/pesanan') }}/' + orderId, {
        headers: { 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' }
    })
    .then(function(r){ return r.json(); })
    .then(function(data) {
        if (!data.success) { psToast('Gagal', 'Tidak bisa mengambil detail pesanan.', 'e'); closeDetail(); return; }
        var o = data.order;
        var statusLabel = { pending:'Pesanan Baru', processing:'Sedang Diproses', completed:'Selesai', cancelled:'Dibatalkan' };
        var statusColor = { pending:'#e65100', processing:'#1565c0', completed:'#2e7d32', cancelled:'#c62828' };
        var statusBg    = { pending:'#fff3e0', processing:'#e3f2fd', completed:'#e8f5e9', cancelled:'#ffebee' };

        var itemsHtml = o.order_items.map(function(item) {
            var img = item.product && item.product.image ? 
                (item.product.image.indexOf('images/') === 0 ? '{{ asset('') }}' + item.product.image : '{{ asset('storage/') }}' + item.product.image)
                : 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=100&q=80';
            
            return '<div class="ps-item-row" style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid #f5f5f5;">'
                + '<img src="'+img+'" style="width:48px;height:48px;border-radius:6px;object-fit:cover;background:#f5f5f5;flex-shrink:0;">'
                + '<div style="flex:1;">'
                +   '<div class="ps-item-name" style="font-size:13px;font-weight:600;color:#333;margin-bottom:2px;">'+item.name+'</div>'
                +   '<div class="ps-item-qty" style="font-size:12px;color:#999;">'+item.quantity+' × Rp '+fmt(item.price)+'</div>'
                + '</div>'
                + '<div class="ps-item-price" style="font-size:13px;font-weight:700;color:#5C4033;">Rp '+fmt(item.subtotal)+'</div>'
                + '</div>';
        }).join('');

        var deliveryMethod = o.delivery_method || 'pickup';
        var cakeDetails = '';
        if (o.size || o.cake_flavor || o.notes) {
            cakeDetails = '<div class="ps-section" style="margin-bottom:18px;">'
                + '<div class="ps-section-title" style="font-size:12px;font-weight:700;color:#5C4033;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Detail Kue</div>'
                + (o.size ? '<div class="ps-row" style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f5f5f5;font-size:14px;"><span class="ps-row-label" style="color:#666;">Size</span><span class="ps-row-value" style="font-weight:500;color:#333;text-align:right;">'+o.size+'</span></div>' : '')
                + (o.cake_flavor ? '<div class="ps-row" style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f5f5f5;font-size:14px;"><span class="ps-row-label" style="color:#666;">Rasa Cake</span><span class="ps-row-value" style="font-weight:500;color:#333;text-align:right;">'+o.cake_flavor+'</span></div>' : '')
                + (o.notes ? '<div class="ps-row" style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:none;font-size:14px;"><span class="ps-row-label" style="color:#666;max-width:80px;">Catatan</span><span class="ps-row-value" style="font-weight:500;color:#5C4033;text-align:right;font-style:italic;max-width:200px;">'+o.notes+'</span></div>' : '')
                + '</div>';
        }

        // Buat list produk untuk Info Pesanan
        var productListHtml = '<div class="ps-row" style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:none;font-size:14px;align-items:flex-start;"><span class="ps-row-label" style="color:#666;">Produk Dipesan</span><span class="ps-row-value" style="font-weight:500;color:#333;text-align:right;max-width:220px;line-height:1.6;">'
            + o.order_items.map(function(item) { return '<span style="display:block;">• ' + item.name + ' (' + item.quantity + ')</span>'; }).join('')
            + '</span></div>';

        document.getElementById('ps-detail-body').innerHTML =
            '<div class="ps-section">'
            + '<div class="ps-section-title">Info Pesanan</div>'
            + '<div class="ps-row"><span class="ps-row-label">No. Pesanan</span><span class="ps-row-value">'+o.order_number+'</span></div>'
            + '<div class="ps-row"><span class="ps-row-label">Tanggal</span><span class="ps-row-value">'+o.created_at+'</span></div>'
            + '<div class="ps-row"><span class="ps-row-label">Status</span><span class="ps-row-value"><span style="background:'+statusBg[o.status]+';color:'+statusColor[o.status]+';padding:3px 10px;border-radius:10px;font-size:12px;font-weight:600;">'+( statusLabel[o.status]||o.status)+'</span></span></div>'
            + '<div class="ps-row"><span class="ps-row-label">Pengambilan</span><span class="ps-row-value">'+(deliveryMethod === 'pickup' ? 'Pick Up' : 'Delivery')+'</span></div>'
            + '<div class="ps-row"><span class="ps-row-label">Pembayaran</span><span class="ps-row-value">'+o.payment_method.toUpperCase()+'</span></div>'
            + productListHtml
            + '</div>'

            + cakeDetails

            + '<div class="ps-section">'
            + '<div class="ps-section-title">Informasi Pelanggan</div>'
            + '<div class="ps-row"><span class="ps-row-label">Nama</span><span class="ps-row-value">'+o.customer.name+'</span></div>'
            + '<div class="ps-row"><span class="ps-row-label">No. Telepon</span><span class="ps-row-value">'+o.customer.phone+'</span></div>'
            + '<div class="ps-row"><span class="ps-row-label">Alamat</span><span class="ps-row-value" style="max-width:260px;text-align:right;">'+o.customer.address+'</span></div>'
            + '</div>'

            + '<div class="ps-section">'
            + '<div class="ps-section-title">Produk Dipesan</div>'
            + itemsHtml
            + '</div>'

            + '<div class="ps-section">'
            + '<div class="ps-section-title">Ringkasan Pembayaran</div>'
            + '<div class="ps-row"><span class="ps-row-label">Subtotal</span><span class="ps-row-value">Rp '+fmt(o.subtotal)+'</span></div>'
            + (o.tax > 0 ? '<div class="ps-row"><span class="ps-row-label">PPN (11%)</span><span class="ps-row-value">Rp '+fmt(o.tax)+'</span></div>' : '')
            + '<div class="ps-total-row"><span>Total</span><span>Rp '+fmt(o.total)+'</span></div>'
            + '</div>';
    })
    .catch(function() {
        psToast('Error', 'Gagal mengambil detail pesanan.', 'e');
        closeDetail();
    });
}

function closeDetail() {
    document.getElementById('ps-detail-overlay').classList.remove('open');
}

function fmt(n) {
    return new Intl.NumberFormat('id-ID').format(n);
}

document.getElementById('ps-detail-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

// Flash session toast
@if(session('success')) psToast('Berhasil', @json(session('success')), 's'); @endif
@if(session('error'))   psToast('Gagal',    @json(session('error')),   'e'); @endif
</script>
@endpush

@extends('layouts.partials.master')

@section('title', 'Manajemen Pesanan')
@section('page-title', 'Manajemen Pesanan')

@push('styles')
<style>
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        <div class="orders-grid">
            @forelse($newOrders as $order)
            <div class="order-card">
                <div class="order-checkbox">
                    <input type="checkbox" id="order-{{ $order->id }}">
                </div>

                <img src="{{ $order->orderItems->first()->product->image ? asset('storage/'.$order->orderItems->first()->product->image) : asset('images/no-image.jpg') }}"
                     alt="{{ $order->orderItems->first()->product->name }}"
                     class="order-image">

                <div class="order-info">
                    <div class="order-header">
                        <div>
                            <div class="order-title">{{ $order->orderItems->first()->product->name }}</div>
                            <div class="order-size">Size: {{ $order->orderItems->first()->product->code }}</div>
                            <div class="order-note">
                                Note: {{ $order->orderItems->first()->product->description ?? 'ditambahkan kata - kata "Birthday ira 18"' }}
                            </div>
                            <div class="order-address">
                                Alamat: {{ $order->customer->address ?? 'Jalan Nanjak No.17 Kota Tasikmalaya' }}
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <button class="btn-action btn-process" onclick="updateStatus({{ $order->id }}, 'processing')">
                            ⏳ Proses
                        </button>
                        <button class="btn-action btn-detail" onclick="showOrderDetail({{ $order->id }})">
                            👁️ Detail
                        </button>
                        <button class="btn-action btn-cancel" onclick="updateStatus({{ $order->id }}, 'cancelled')">
                            ✕ Batalkan
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
                <div class="empty-icon">📦</div>
                <div class="empty-text">Tidak ada pesanan baru</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Tab Content: Pesanan Diproses -->
    <div class="tab-content" id="tab-processing">
        <div class="orders-grid">
            @forelse($processingOrders as $order)
            <div class="order-card">
                <div class="order-checkbox">
                    <input type="checkbox" id="order-{{ $order->id }}">
                </div>

                <img src="{{ $order->orderItems->first()->product->image ? asset('storage/'.$order->orderItems->first()->product->image) : asset('images/no-image.jpg') }}"
                     alt="{{ $order->orderItems->first()->product->name }}"
                     class="order-image">

                <div class="order-info">
                    <div class="order-header">
                        <div>
                            <div class="order-title">{{ $order->orderItems->first()->product->name }}</div>
                            <div class="order-size">Size: {{ $order->orderItems->first()->product->code }}</div>
                            <div class="order-note">
                                Note: {{ $order->orderItems->first()->product->description ?? 'ditambahkan kata - kata "Birthday ira 18"' }}
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
                            ✕ Batalkan
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
                <div class="empty-icon">⏳</div>
                <div class="empty-text">Tidak ada pesanan yang sedang diproses</div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Detail Pesanan</h3>
            <span class="close-modal" onclick="closeDetailModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Switch Tab
function switchTab(tab) {
    // Update buttons
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Update content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
}

// Update Order Status
function updateStatus(orderId, status) {
    const messages = {
        'processing': 'Apakah yakin memproses pesanan ini?',
        'completed': 'Apakah pesanan sudah selesai dan siap diambil?',
        'cancelled': 'Apakah yakin membatalkan pesanan ini?'
    };

    if (confirm(messages[status])) {
        fetch(`/pesanan/${orderId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengupdate status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengupdate status');
        });
    }
}

// Show Order Detail
function showOrderDetail(orderId) {
    fetch(`/pesanan/${orderId}`)
        .then(response => response.json())
        .then(data => {
            const order = data.order;

            let itemsHtml = '';
            order.order_items.forEach(item => {
                itemsHtml += `
                    <div class="detail-row">
                        <span class="detail-label">${item.product.name} (x${item.quantity})</span>
                        <span class="detail-value">Rp ${formatNumber(item.subtotal)}</span>
                    </div>
                `;
            });

            const statusClass = {
                'pending': 'status-pending',
                'processing': 'status-processing',
                'completed': 'status-completed',
                'cancelled': 'status-cancelled'
            };

            const statusText = {
                'pending': 'Pesanan Baru',
                'processing': 'Sedang Diproses',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };

            const content = `
                <div class="detail-section">
                    <h4>Informasi Pesanan</h4>
                    <div class="detail-row">
                        <span class="detail-label">No. Pesanan</span>
                        <span class="detail-value">${order.order_number}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal</span>
                        <span class="detail-value">${new Date(order.created_at).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="status-badge ${statusClass[order.status]}">${statusText[order.status]}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Informasi Pelanggan</h4>
                    <div class="detail-row">
                        <span class="detail-label">Nama</span>
                        <span class="detail-value">${order.customer.name}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">No. Telepon</span>
                        <span class="detail-value">${order.customer.phone}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Alamat</span>
                        <span class="detail-value">${order.customer.address}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Detail Produk</h4>
                    ${itemsHtml}
                </div>

                <div class="detail-section">
                    <h4>Ringkasan Pembayaran</h4>
                    <div class="detail-row">
                        <span class="detail-label">Subtotal</span>
                        <span class="detail-value">Rp ${formatNumber(order.subtotal)}</span>
                    </div>
                    ${order.tax > 0 ? `
                    <div class="detail-row">
                        <span class="detail-label">PPN (11%)</span>
                        <span class="detail-value">Rp ${formatNumber(order.tax)}</span>
                    </div>` : ''}
                    <div class="detail-row" style="border-top: 2px solid #5C4033; font-weight: 700; color: #5C4033;">
                        <span class="detail-label">Total</span>
                        <span class="detail-value">Rp ${formatNumber(order.total)}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value">${order.payment_method.toUpperCase()}</span>
                    </div>
                </div>
            `;

            document.getElementById('modalDetailContent').innerHTML = content;
            document.getElementById('detailModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil detail pesanan');
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeDetailModal();
    }
}
</script>
@endpush

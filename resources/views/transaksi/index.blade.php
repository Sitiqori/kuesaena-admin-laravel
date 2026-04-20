@extends('layouts.partials.master')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@push('styles')
<style>
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        font-size: 13px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .stat-info .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }

    .stat-value.green {
        color: #2e7d32;
    }

    .stat-value.blue {
        color: #1976d2;
    }

    .stat-value.purple {
        color: #7b1fa2;
    }

    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .filters-bar {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filter-date {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-date:hover {
        border-color: #5C4033;
        background: #faf8f6;
    }

    .search-box-wrapper {
        position: relative;
        flex: 1;
        min-width: 300px;
    }

    .search-box-wrapper input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8f8f8;
    }

    th {
        padding: 12px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
        white-space: nowrap;
    }

    td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
        white-space: nowrap;
    }

    tbody tr:hover {
        background: #f8f8f8;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        background: #5C4033;
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .btn-view {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-view:hover {
        background: #bbdefb;
    }

    .btn-print {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .btn-print:hover {
        background: #e1bee7;
    }

    .pagination-info {
        margin-top: 15px;
        font-size: 14px;
        color: #666;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination {
        display: flex;
        gap: 5px;
    }

    .page-btn {
        padding: 6px 12px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .page-btn.active {
        background: #5C4033;
        color: white;
        border-color: #5C4033;
    }

    .page-btn:hover:not(.active) {
        background: #f5f5f5;
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
        text-align: right;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #5C4033;
        color: white;
    }

    .btn-primary:hover {
        background: #4A3329;
    }

    .btn-secondary {
        background: white;
        border: 1px solid #ddd;
        color: #333;
    }

    .btn-secondary:hover {
        background: #f5f5f5;
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

    /* Date Filter Modal */
    .date-filter-modal {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 8px;
        z-index: 100;
        min-width: 300px;
        display: none;
    }

    .date-filter-modal.show {
        display: block;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-info">
            <h4>Total Transaksi</h4>
            <div class="stat-value">{{ $totalTransaksi }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <h4>Total Penjualan</h4>
            <div class="stat-value blue">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💸</div>
        <div class="stat-info">
            <h4>Laba Kotor</h4>
            <div class="stat-value purple">Rp {{ number_format($labaKotor, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="content-card">
    <!-- Filters Bar -->
    <div class="filters-bar">
        <div style="position: relative;">
            <div class="filter-date" onclick="toggleDateFilter()">
                <span>📅</span>
                <span id="dateFilterText">Filter tanggal</span>
            </div>
            <div class="date-filter-modal" id="dateFilterModal">
                <div class="form-group">
                    <label>Dari Tanggal</label>
                    <input type="date" id="dateFrom" onchange="applyDateFilter()">
                </div>
                <div class="form-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" id="dateTo" onchange="applyDateFilter()">
                </div>
                <button class="btn btn-primary" onclick="applyDateFilter()" style="width: 100%; margin-top: 10px;">
                    Terapkan Filter
                </button>
                <button class="btn btn-secondary" onclick="resetDateFilter()" style="width: 100%; margin-top: 8px;">
                    Reset
                </button>
            </div>
        </div>

        <div class="search-box-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari nama atau kode barang..." onkeyup="filterTransactions()">
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal/Jam</th>
                    <th>Kasir</th>
                    <th>Total Item</th>
                    <th>Total pembayaran</th>
                    <th>Metode bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr data-order-number="{{ strtolower($transaction->order_number) }}"
                    data-kasir="{{ strtolower($transaction->user->name) }}"
                    data-date="{{ $transaction->created_at->format('Y-m-d') }}">
                    <td>{{ $transaction->order_number }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->orderItems->sum('quantity') }}</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td>{{ strtoupper($transaction->payment_method) }}</td>
                    <td><span class="status-badge">Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="icon-btn btn-view" onclick="showDetail({{ $transaction->id }})" title="Lihat Detail">
                                👁️
                            </button>
                            <button class="icon-btn btn-print" onclick="printReceipt({{ $transaction->id }})" title="Cetak Struk">
                                🖨️
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">📋</div>
                            <div>Belum ada transaksi</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-info">
        <div>Menampilkan <span id="showingCount">{{ $transactions->count() }}</span> dari {{ $transactions->count() }} data</div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Detail Transaksi</h3>
            <span class="close-modal" onclick="closeDetailModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Content will be loaded dynamically -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDetailModal()">Tutup</button>
            <button class="btn btn-primary" onclick="printReceiptFromModal()">🖨️ Cetak Struk</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentOrderId = null;

// Toggle Date Filter
function toggleDateFilter() {
    const modal = document.getElementById('dateFilterModal');
    modal.classList.toggle('show');
}

// Apply Date Filter
function applyDateFilter() {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;

    if (dateFrom && dateTo) {
        document.getElementById('dateFilterText').textContent =
            `${formatDate(dateFrom)} - ${formatDate(dateTo)}`;
    } else if (dateFrom) {
        document.getElementById('dateFilterText').textContent = `Dari ${formatDate(dateFrom)}`;
    } else if (dateTo) {
        document.getElementById('dateFilterText').textContent = `Sampai ${formatDate(dateTo)}`;
    }

    filterTransactions();
    toggleDateFilter();
}

// Reset Date Filter
function resetDateFilter() {
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('dateFilterText').textContent = 'Filter tanggal';
    filterTransactions();
    toggleDateFilter();
}

// Format Date
function formatDate(dateString) {
    const date = new Date(dateString);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}

// Filter Transactions
function filterTransactions() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const rows = document.querySelectorAll('#transactionsTable tbody tr');

    let visibleCount = 0;

    rows.forEach(row => {
        if (row.cells.length === 1) return; // Skip empty state row

        const orderNumber = row.dataset.orderNumber || '';
        const kasir = row.dataset.kasir || '';
        const rowDate = row.dataset.date || '';

        const matchSearch = !search || orderNumber.includes(search) || kasir.includes(search);
        const matchDateFrom = !dateFrom || rowDate >= dateFrom;
        const matchDateTo = !dateTo || rowDate <= dateTo;

        if (matchSearch && matchDateFrom && matchDateTo) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('showingCount').textContent = visibleCount;
}

// Show Detail
function showDetail(orderId) {
    currentOrderId = orderId;

    fetch(`/transaksi/${orderId}`)
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

            const content = `
                <div class="detail-section">
                    <h4>Informasi Transaksi</h4>
                    <div class="detail-row">
                        <span class="detail-label">No. Transaksi</span>
                        <span class="detail-value">${order.order_number}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal & Waktu</span>
                        <span class="detail-value">${new Date(order.created_at).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kasir</span>
                        <span class="detail-value">${order.user.name}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="status-badge">Lunas</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Informasi Pelanggan</h4>
                    <div class="detail-row">
                        <span class="detail-label">Nama</span>
                        <span class="detail-value">${order.customer ? order.customer.name : 'Umum'}</span>
                    </div>
                    ${order.customer && order.customer.phone ? `
                    <div class="detail-row">
                        <span class="detail-label">No. Telepon</span>
                        <span class="detail-value">${order.customer.phone}</span>
                    </div>` : ''}
                    ${order.customer && order.customer.address ? `
                    <div class="detail-row">
                        <span class="detail-label">Alamat</span>
                        <span class="detail-value">${order.customer.address}</span>
                    </div>` : ''}
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
                    ${order.discount > 0 ? `
                    <div class="detail-row">
                        <span class="detail-label">Diskon</span>
                        <span class="detail-value">Rp ${formatNumber(order.discount)}</span>
                    </div>` : ''}
                    <div class="detail-row" style="border-top: 2px solid #5C4033; font-weight: 700; color: #5C4033; margin-top: 8px; padding-top: 12px;">
                        <span class="detail-label">Total Pembayaran</span>
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
            alert('Gagal mengambil detail transaksi');
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
    currentOrderId = null;
}

// Print Receipt
function printReceipt(orderId) {
    fetch(`/transaksi/${orderId}`)
        .then(response => response.json())
        .then(data => {
            generateReceipt(data.order);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mencetak struk');
        });
}

function printReceiptFromModal() {
    if (currentOrderId) {
        printReceipt(currentOrderId);
    }
}

function generateReceipt(order) {
    const printWindow = window.open('', '', 'width=300,height=600');

    let itemsHtml = '';
    order.order_items.forEach(item => {
        itemsHtml += `
            <tr>
                <td>${item.product.name}</td>
                <td style="text-align: center;">${item.quantity}</td>
                <td style="text-align: right;">Rp ${formatNumber(item.price)}</td>
                <td style="text-align: right;">Rp ${formatNumber(item.subtotal)}</td>
            </tr>
        `;
    });

    const ppnRow = order.tax > 0 ? `
        <tr>
            <td colspan="3">Sub-Total</td>
            <td style="text-align: right;">Rp ${formatNumber(order.subtotal)}</td>
        </tr>
        <tr>
            <td colspan="3">PPN (11%)</td>
            <td style="text-align: right;">Rp ${formatNumber(order.tax)}</td>
        </tr>
    ` : '';

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Struk Pembayaran</title>
            <style>
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    margin: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px dashed #000;
                    padding-bottom: 10px;
                }
                .header h2 {
                    margin: 5px 0;
                }
                .info {
                    margin-bottom: 15px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 5px 0;
                }
                th {
                    text-align: left;
                    border-bottom: 1px solid #000;
                }
                .total-section {
                    border-top: 2px dashed #000;
                    margin-top: 10px;
                    padding-top: 10px;
                }
                .total-row {
                    display: flex;
                    justify-content: space-between;
                    font-weight: bold;
                    font-size: 14px;
                    margin: 5px 0;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    border-top: 2px dashed #000;
                    padding-top: 10px;
                    font-size: 11px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>KUESAENA</h2>
                <p>Malky Production</p>
                <p>Perum Malky Mas Residence A, Bajobella No.No. 8A, Gapura Tasikmalaya</p>
                <p>No Telp: 0812-3387-2318-8</p>
            </div>

            <div class="info">
                <div>Tanggal: ${new Date(order.created_at).toLocaleDateString('id-ID')}</div>
                <div>Jam: ${new Date(order.created_at).toLocaleTimeString('id-ID')}</div>
                <div>No. Transaksi: ${order.order_number}</div>
                <div>Kasir: ${order.user.name}</div>
                <div>Pelanggan: ${order.customer ? order.customer.name : 'Umum'}</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHtml}
                </tbody>
            </table>

            <div class="total-section">
                ${ppnRow}
                <div class="total-row">
                    <span>Total</span>
                    <span>Rp ${formatNumber(order.total)}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 5px 0;">
                    <span>Bayar (${order.payment_method})</span>
                    <span>Rp ${formatNumber(order.total)}</span>
                </div>
            </div>

            <div class="footer">
                <p>Terimakasih Atas Kunjungannya</p>
                <p>---</p>
                <p>USB KAFE & Sosm1</p>
                <p>https://kuesaena.com/USB KAFE 1M-2507577777</p>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Close modals when clicking outside
window.onclick = function(event) {
    const detailModal = document.getElementById('detailModal');
    const dateFilterModal = document.getElementById('dateFilterModal');

    if (event.target === detailModal) {
        closeDetailModal();
    }

    if (!event.target.closest('.filter-date') && !event.target.closest('.date-filter-modal')) {
        dateFilterModal.classList.remove('show');
    }
}
</script>
@endpush

@extends('layouts.partials.master')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@push('styles')
<style>
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

    .charts-container {
        display: grid;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .chart-controls {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .month-selector {
        padding: 8px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        background: white;
    }

    .tab-buttons {
        display: flex;
        gap: 5px;
        background: #f5f5f5;
        padding: 4px;
        border-radius: 6px;
    }

    .tab-btn {
        padding: 6px 16px;
        border: none;
        background: transparent;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
    }

    .tab-btn.active {
        background: white;
        color: #5C4033;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .download-btn {
        padding: 8px 16px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
    }

    .download-btn:hover {
        background: #f5f5f5;
    }

    .chart-wrapper {
        height: 350px;
        position: relative;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    .total-revenue-box {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border: 2px solid #ff9800;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
    }

    .total-revenue-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 5px;
    }

    .total-revenue-amount {
        font-size: 28px;
        font-weight: 700;
        color: #e65100;
    }

    .filters-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .filter-group {
        flex: 1;
    }

    .filter-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
    }

    .date-filter {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        background: white;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .search-input {
        flex: 2;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
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
        padding: 10px 12px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e0e0e0;
        white-space: nowrap;
    }

    td {
        padding: 10px 12px;
        font-size: 13px;
        border-bottom: 1px solid #f0f0f0;
    }

    tbody tr:hover {
        background: #f8f8f8;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-listrik { background: #fff3e0; color: #e65100; }
    .badge-gaji { background: #e8f5e9; color: #2e7d32; }
    .badge-perlengkapan { background: #f3e5f5; color: #7b1fa2; }
    .badge-sewa { background: #e3f2fd; color: #1565c0; }

    .action-icons {
        display: flex;
        gap: 8px;
    }

    .icon-btn {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .btn-edit {
        background: #fff3e0;
        color: #e65100;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .top-products-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .product-item:hover {
        background: #f8f8f8;
        border-color: #5C4033;
    }

    .product-rank {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #C19A6B;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .product-rank.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #333;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.4);
    }

    .product-rank.silver {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #333;
    }

    .product-rank.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #e8a772 100%);
        color: white;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 2px;
    }

    .product-code {
        font-size: 12px;
        color: #999;
    }

    .product-stats {
        text-align: right;
    }

    .product-sold {
        font-size: 18px;
        font-weight: 700;
        color: #5C4033;
        margin-bottom: 2px;
    }

    .product-sold-label {
        font-size: 11px;
        color: #666;
    }

    canvas {
        max-height: 350px;
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
            <div class="stat-value">{{ $pesananBaru }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-info">
            <h4>Pesanan Diproses</h4>
            <div class="stat-value">{{ $pesananDiproses }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-info">
            <h4>Penjualan 1 Bulan</h4>
            <div class="stat-value">{{ $penjualanBulan }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div class="stat-info">
            <h4>Admin Aktif</h4>
            <div class="stat-value">{{ $adminAktif }}</div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="charts-container">
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Pendapatan Harian</h3>
            <div class="chart-controls">
                <select class="month-selector" id="monthSelector" onchange="updateChart()">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11" selected>November</option>
                    <option value="12">Desember</option>
                </select>
                <div class="tab-buttons">
                    <button class="tab-btn active" onclick="switchChartType('revenue')">Pendapatan</button>
                    <button class="tab-btn" onclick="switchChartType('expense')">Pengeluaran</button>
                    <button class="tab-btn" onclick="switchChartType('comparison')">Perbandingan</button>
                </div>
                <button class="download-btn" onclick="downloadReport()">
                    📥 Unduh Laporan
                </button>
            </div>
        </div>
        <div class="chart-wrapper">
            <canvas id="mainChart"></canvas>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Transactions Table -->
    <div class="content-card">
        <div class="total-revenue-box">
            <div class="total-revenue-label">Total pengeluaran</div>
            <div class="total-revenue-amount">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>

        <div class="filters-bar">
            <div class="filter-group">
                <select id="categoryFilter" onchange="filterExpenses()">
                    <option value="">Semua kategori</option>
                    <option value="Listrik">Listrik</option>
                    <option value="Gaji">Gaji</option>
                    <option value="Perlengkapan">Perlengkapan</option>
                    <option value="Sewa">Sewa</option>
                </select>
            </div>
            <input type="date" class="date-filter" id="dateFilter" onchange="filterExpenses()">
            <input type="text" class="search-input" id="searchInput" placeholder="Cari deskripsi pengeluaran..." onkeyup="filterExpenses()">
        </div>

        <div class="table-wrapper">
            <table id="expensesTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori pengeluaran</th>
                        <th>Deskripsi</th>
                        <th>Nominal</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr data-category="{{ strtolower($expense->category) }}"
                        data-description="{{ strtolower($expense->description) }}"
                        data-date="{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}">
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="category-badge badge-{{ strtolower($expense->category) }}">
                                {{ $expense->category }}
                            </span>
                        </td>
                        <td>{{ $expense->description }}</td>
                        <td style="color: #d32f2f; font-weight: 600;">
                            Rp {{ number_format($expense->amount, 0, ',', '.') }}
                        </td>
                        <td>{{ $expense->user->name }}</td>
                        <td>
                            <div class="action-icons">
                                <button class="icon-btn btn-edit">✏️</button>
                                <button class="icon-btn btn-delete">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                            Belum ada data pengeluaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 10px; font-size: 12px; color: #666;">
            Menampilkan 1 - {{ $expenses->count() }} dari {{ $expenses->count() }} data
        </div>
    </div>

    <!-- Top Products -->
    <div class="content-card">
        <h3 class="section-title">Produk Terlaris Bulan Ini</h3>

        <div class="top-products-list">
            @foreach($topProducts as $index => $product)
            <div class="product-item">
                <div class="product-rank {{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : ($index === 2 ? 'bronze' : '')) }}">
                    {{ $index + 1 }}
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-code">{{ $product->code }} | {{ $product->category->name }}</div>
                </div>
                <div class="product-stats">
                    <div class="product-sold">{{ $product->total_sold }}</div>
                    <div class="product-sold-label">ter jual</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
let mainChart = null;
let currentChartType = 'revenue';
let currentMonth = {{ date('n') }};

const chartData = @json($chartData);

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('monthSelector').value = currentMonth;
    initChart();
});

function initChart() {
    const ctx = document.getElementById('mainChart').getContext('2d');

    if (mainChart) {
        mainChart.destroy();
    }

    const data = getChartData();

    mainChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: currentChartType === 'comparison',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000) + 'k';
                        }
                    }
                }
            }
        }
    });
}

function getChartData() {
    const monthData = chartData[currentMonth] || {};

    if (currentChartType === 'revenue') {
        return {
            labels: monthData.labels || [],
            datasets: [{
                label: 'Pendapatan',
                data: monthData.revenue || [],
                backgroundColor: '#5C4033',
                borderRadius: 4,
            }]
        };
    } else if (currentChartType === 'expense') {
        return {
            labels: monthData.labels || [],
            datasets: [{
                label: 'Pengeluaran',
                data: monthData.expense || [],
                backgroundColor: '#dc3545',
                borderRadius: 4,
            }]
        };
    } else {
        return {
            labels: monthData.labels || [],
            datasets: [
                {
                    label: 'Pendapatan',
                    data: monthData.revenue || [],
                    backgroundColor: '#5C4033',
                    borderRadius: 4,
                },
                {
                    label: 'Pengeluaran',
                    data: monthData.expense || [],
                    backgroundColor: '#dc3545',
                    borderRadius: 4,
                }
            ]
        };
    }
}

function switchChartType(type) {
    currentChartType = type;

    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    initChart();
}

function updateChart() {
    currentMonth = parseInt(document.getElementById('monthSelector').value);
    initChart();
}

function downloadReport() {
    const month = document.getElementById('monthSelector').value;
    window.open(`/laporan/export-pdf?month=${month}`, '_blank');
}

// Filter Expenses
function filterExpenses() {
    const category = document.getElementById('categoryFilter').value.toLowerCase();
    const date = document.getElementById('dateFilter').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#expensesTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length === 1) return;

        const rowCategory = row.dataset.category || '';
        const rowDescription = row.dataset.description || '';
        const rowDate = row.dataset.date || '';

        const matchCategory = !category || rowCategory === category;
        const matchDate = !date || rowDate === date;
        const matchSearch = !search || rowDescription.includes(search);

        row.style.display = (matchCategory && matchDate && matchSearch) ? '' : 'none';
    });
}
</script>
@endpush

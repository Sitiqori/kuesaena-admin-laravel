@extends('layouts.partials.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

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

    .recent-orders {
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

    .order-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.3s;
    }

    .order-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-color: #5C4033;
    }

    .order-checkbox {
        display: flex;
        align-items: center;
    }

    .order-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .order-icon {
        width: 40px;
        height: 40px;
        background: #f5f5f5;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .order-info {
        flex: 1;
    }

    .order-name {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .order-details {
        font-size: 12px;
        color: #666;
    }

    .order-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .edit-btn {
        width: 32px;
        height: 32px;
        background: #fff3e0;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .edit-btn:hover {
        background: #ffe0b2;
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
        <div class="stat-icon">⏳</div>
        <div class="stat-info">
            <h4>Pesanan Diproses</h4>
            <div class="stat-value">{{ $pesananDiproses }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <h4>Total Pendapatan</h4>
            <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💸</div>
        <div class="stat-info">
            <h4>Total Pengeluaran</h4>
            <div class="stat-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="charts-container">
    <!-- Daily Revenue Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Pendapatan Harian</h3>
            <div class="chart-controls">
                <select class="month-selector" id="monthSelector" onchange="updateCharts()">
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
                    <button class="tab-btn active" data-chart="revenue" onclick="switchChart('revenue')">Pendapatan</button>
                    <button class="tab-btn" data-chart="expense" onclick="switchChart('expense')">Pengeluaran</button>
                    <button class="tab-btn" data-chart="comparison" onclick="switchChart('comparison')">Perbandingan</button>
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

<!-- Recent Orders -->
<div class="recent-orders">
    <h3 class="section-title">Pesanan Baru</h3>
    @forelse($recentOrders as $order)
    <div class="order-item">
        <div class="order-checkbox">
            <input type="checkbox" id="order-{{ $order->id }}">
        </div>
        <div class="order-icon">🍰</div>
        <div class="order-info">
            <div class="order-name">{{ $order->orderItems->first()->product->name }}</div>
            <div class="order-details">
                Size: {{ $order->orderItems->first()->product->code }}<br>
                Note: {{ $order->orderItems->first()->product->description ?? 'ditambahkan kata - kata "Birthday ira 18"' }}<br>
                Alamat: {{ $order->customer->address ?? 'Jalan Nanjak No.17 Kota Tasikmalaya' }}
            </div>
        </div>
        <div class="order-actions">
            <button class="edit-btn" onclick="window.location.href='{{ route('pesanan.index') }}'">✏️</button>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 40px; color: #999;">
        <div style="font-size: 60px; margin-bottom: 10px;">📦</div>
        <div>Tidak ada pesanan baru</div>
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
let mainChart = null;
let currentChart = 'revenue';
let currentMonth = {{ date('n') }};

// Data dari backend
const chartData = @json($chartData);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('monthSelector').value = currentMonth;
    initChart();
});

function initChart() {
    const ctx = document.getElementById('mainChart').getContext('2d');

    // Destroy existing chart
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
                    display: currentChart === 'comparison',
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            return label;
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

    if (currentChart === 'revenue') {
        return {
            labels: monthData.labels || [],
            datasets: [{
                label: 'Pendapatan',
                data: monthData.revenue || [],
                backgroundColor: '#5C4033',
                borderRadius: 4,
            }]
        };
    } else if (currentChart === 'expense') {
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

function switchChart(type) {
    currentChart = type;

    // Update active button
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-chart="${type}"]`).classList.add('active');

    initChart();
}

function updateCharts() {
    currentMonth = parseInt(document.getElementById('monthSelector').value);
    initChart();
}

function downloadReport() {
    const month = document.getElementById('monthSelector').value;
    window.open(`/dashboard/export-pdf?month=${month}`, '_blank');
}
</script>
@endpush

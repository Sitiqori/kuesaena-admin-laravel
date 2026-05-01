<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lengkap - {{ $monthName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #5C4033;
            padding-bottom: 12px;
        }

        .header h1 {
            margin: 0;
            color: #5C4033;
            font-size: 26px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: normal;
            color: #666;
        }

        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 25px;
        }

        .summary-card {
            border: 2px solid #5C4033;
            padding: 12px;
            text-align: center;
            border-radius: 5px;
        }

        .summary-card .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 6px;
        }

        .summary-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #5C4033;
        }

        .summary-card.profit {
            background: #e8f5e9;
            border-color: #2e7d32;
        }

        .summary-card.profit .value {
            color: #2e7d32;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin: 20px 0 12px 0;
            color: #5C4033;
            border-bottom: 2px solid #5C4033;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background-color: #5C4033;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        .top-products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-rank {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #C19A6B;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 13px;
            flex-shrink: 0;
        }

        .product-rank.gold {
            background: #ffd700;
            color: #333;
        }

        .product-rank.silver {
            background: #c0c0c0;
            color: #333;
        }

        .product-rank.bronze {
            background: #cd7f32;
            color: white;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .product-code {
            font-size: 9px;
            color: #666;
        }

        .product-sold {
            font-size: 14px;
            font-weight: bold;
            color: #5C4033;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KUESAENA</h1>
        <h2>Laporan Lengkap - {{ $monthName }}</h2>
    </div>

    <div class="info">
        <div class="info-row">
            <span><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</span>
            <span><strong>Jam:</strong> {{ date('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }}</span>
            <span><strong>Periode:</strong> {{ $monthName }}</span>
        </div>
    </div>

    <div class="section-title">RINGKASAN KEUANGAN</div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card profit">
            <div class="label">Laba Kotor</div>
            <div class="value">Rp {{ number_format($labaKotor, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="section-title">PRODUK TERLARIS TOP 10</div>

    <div class="top-products-grid">
        @foreach($topProducts as $index => $product)
        <div class="product-card">
            <div class="product-rank {{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : ($index === 2 ? 'bronze' : '')) }}">
                {{ $index + 1 }}
            </div>
            <div class="product-details">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-code">{{ $product->code }} | {{ $product->category->name }}</div>
            </div>
            <div class="product-sold">
                {{ $product->total_sold }} <br>
                <span style="font-size: 9px; font-weight: normal; color: #666;">terjual</span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="page-break"></div>

    <div class="section-title">DETAIL PENJUALAN</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">No. Transaksi</th>
                <th width="13%">Tanggal</th>
                <th width="12%">Kasir</th>
                <th width="15%">Pelanggan</th>
                <th width="8%">Item</th>
                <th width="10%">Metode</th>
                <th width="13%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->customer ? $order->customer->name : 'Umum' }}</td>
                <td>{{ $order->orderItems->sum('quantity') }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="section-title">DETAIL PENGELUARAN</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Kategori</th>
                <th width="35%">Deskripsi</th>
                <th width="15%">Nominal</th>
                <th width="15%">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $index => $expense)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $expense->date->format('d/m/Y H:i') }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ $expense->description }}</td>
                <td style="color: #d32f2f; font-weight: bold;">
                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                </td>
                <td>{{ $expense->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem KUESAENA</p>
        <p>© {{ date('Y') }} KUESAENA - Malky Production. All Rights Reserved.</p>
    </div>
</body>
</html>

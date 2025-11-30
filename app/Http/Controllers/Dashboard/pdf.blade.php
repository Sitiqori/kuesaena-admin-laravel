<!DOCTYPE html>
<html>
<head>
    <title>Laporan Dashboard - {{ $monthName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #5C4033;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #5C4033;
            font-size: 24px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: normal;
        }

        .info {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .summary-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-card h3 {
            margin: 0 0 10px 0;
            font-size: 13px;
            color: #666;
        }

        .summary-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #5C4033;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #5C4033;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            color: #5C4033;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-box {
            border: 1px solid #e0e0e0;
            padding: 12px;
            text-align: center;
            border-radius: 5px;
        }

        .stat-box .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-box .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KUESAENA</h1>
        <h2>Laporan Dashboard - {{ $monthName }}</h2>
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

    <div class="section-title">Ringkasan Keuangan</div>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Laba Kotor</div>
            <div class="value" style="color: #2e7d32;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="section-title">Detail Transaksi</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Transaksi</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Kasir</th>
                <th width="20%">Pelanggan</th>
                <th width="10%">Item</th>
                <th width="10%">Metode</th>
                <th width="10%">Total</th>
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

    <div class="section-title">Produk Terlaris</div>

    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="40%">Nama Produk</th>
                <th width="20%">Kode</th>
                <th width="15%">Terjual</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $productSales = [];
                foreach($orders as $order) {
                    foreach($order->orderItems as $item) {
                        $productId = $item->product_id;
                        if (!isset($productSales[$productId])) {
                            $productSales[$productId] = [
                                'name' => $item->product->name,
                                'code' => $item->product->code,
                                'quantity' => 0,
                                'total' => 0,
                            ];
                        }
                        $productSales[$productId]['quantity'] += $item->quantity;
                        $productSales[$productId]['total'] += $item->subtotal;
                    }
                }

                // Sort by quantity
                usort($productSales, function($a, $b) {
                    return $b['quantity'] - $a['quantity'];
                });

                // Take top 10
                $topProducts = array_slice($productSales, 0, 10);
            @endphp

            @foreach($topProducts as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['code'] }}</td>
                <td>{{ $product['quantity'] }} pcs</td>
                <td>Rp {{ number_format($product['total'], 0, ',', '.') }}</td>
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

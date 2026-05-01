<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ $monthName }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 30px; }

        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #5C4033; padding-bottom: 16px; }
        .header h1 { font-size: 20px; color: #5C4033; margin-bottom: 4px; }
        .header p { font-size: 11px; color: #888; }

        .summary { display: flex; gap: 12px; margin-bottom: 24px; }
        .summary-card { flex: 1; background: #f9f5f0; border: 1px solid #e8d5b7; border-radius: 6px; padding: 12px 16px; }
        .summary-card .label { font-size: 10px; color: #888; margin-bottom: 4px; }
        .summary-card .value { font-size: 16px; font-weight: 700; color: #3B1A08; }
        .summary-card.merah .value { color: #c0392b; }
        .summary-card.hijau .value { color: #27ae60; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background: #5C4033; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #f0e8df; font-size: 11px; }
        tr:nth-child(even) td { background: #faf5ee; }

        .section-title { font-size: 14px; font-weight: 700; color: #3B1A08; margin-bottom: 10px; border-left: 3px solid #5C4033; padding-left: 8px; }

        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 12px; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; }
        .badge-lunas { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>Laporan Penjualan Kuesaena</h1>
        <p>Periode: {{ $monthName }} &nbsp;|&nbsp; Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Summary Cards --}}
    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card merah">
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card hijau">
            <div class="label">Laba Kotor</div>
            <div class="value">Rp {{ number_format($labaKotor, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <p class="section-title">Detail Transaksi</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Item</th>
                <th>Metode Bayar</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $i => $order)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->customer->name ?? 'Umum' }}</td>
                <td>{{ $order->orderItems->sum('quantity') }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td><span class="badge badge-lunas">Lunas</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; color:#888; padding:20px;">Tidak ada transaksi bulan ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} Kuesaena Malky Production &mdash; Laporan ini digenerate otomatis oleh sistem
    </div>

</body>
</html>
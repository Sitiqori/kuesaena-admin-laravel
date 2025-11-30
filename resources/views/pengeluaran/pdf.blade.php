<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran - KUESAENA</title>
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

        .total-box {
            background: #ffebee;
            border: 2px solid #d32f2f;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .total-box .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .total-box .amount {
            font-size: 28px;
            font-weight: bold;
            color: #d32f2f;
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

        .category-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-listrik {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-gaji {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-perlengkapan {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-sewa {
            background: #e3f2fd;
            color: #1565c0;
        }

        .badge-lainnya {
            background: #f5f5f5;
            color: #666;
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

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .summary-card {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            border-radius: 5px;
        }

        .summary-card .cat-name {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-card .cat-amount {
            font-size: 14px;
            font-weight: bold;
            color: #d32f2f;
            margin-bottom: 3px;
        }

        .summary-card .cat-count {
            font-size: 9px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KUESAENA</h1>
        <h2>Laporan Pengeluaran</h2>
    </div>

    <div class="info">
        <div class="info-row">
            <span><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</span>
            <span><strong>Jam:</strong> {{ date('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }}</span>
            <span><strong>Total Data:</strong> {{ $expenses->count() }} transaksi</span>
        </div>
    </div>

    <div class="total-box">
        <div class="label">Total Pengeluaran</div>
        <div class="amount">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
    </div>

    <div class="section-title">Ringkasan per Kategori</div>

    <div class="summary-grid">
        @foreach(['Listrik', 'Gaji', 'Perlengkapan', 'Sewa', 'Lainnya'] as $cat)
        <div class="summary-card">
            <div class="cat-name">{{ $cat }}</div>
            <div class="cat-amount">
                Rp {{ number_format($byCategory[$cat]['total'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="cat-count">{{ $byCategory[$cat]['count'] ?? 0 }} transaksi</div>
        </div>
        @endforeach
    </div>

    <div class="section-title">Detail Pengeluaran</div>

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
                <td>
                    <span class="category-badge badge-{{ strtolower($expense->category) }}">
                        {{ $expense->category }}
                    </span>
                </td>
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

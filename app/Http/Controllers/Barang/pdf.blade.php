<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk - KUESAENA</title>
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

        .stock-low {
            color: #c62828;
            font-weight: bold;
        }

        .stock-out {
            color: #757575;
            font-weight: bold;
        }

        .stock-ok {
            color: #2e7d32;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .summary-row strong {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KUESAENA</h1>
        <h2>Daftar Produk</h2>
    </div>

    <div class="info">
        <div class="info-row">
            <span><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</span>
            <span><strong>Jam:</strong> {{ date('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }}</span>
            <span><strong>Total Produk:</strong> {{ $products->count() }} item</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="25%">Nama Produk</th>
                <th width="12%">Kategori</th>
                <th width="12%">HPP</th>
                <th width="12%">Harga Jual</th>
                <th width="8%">Stok</th>
                <th width="8%">Min. Stok</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>Rp {{ number_format($product->price * 0.7, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @if($product->stock == 0)
                        <span class="stock-out">{{ $product->stock }}</span>
                    @elseif($product->stock <= 3)
                        <span class="stock-low">{{ $product->stock }}</span>
                    @else
                        <span class="stock-ok">{{ $product->stock }}</span>
                    @endif
                </td>
                <td>3</td>
                <td>Aktif</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Produk:</strong></span>
            <span>{{ $products->count() }} item</span>
        </div>
        <div class="summary-row">
            <span><strong>Produk Stok Habis:</strong></span>
            <span>{{ $products->where('stock', 0)->count() }} item</span>
        </div>
        <div class="summary-row">
            <span><strong>Produk Stok Rendah (≤3):</strong></span>
            <span>{{ $products->where('stock', '<=', 3)->where('stock', '>', 0)->count() }} item</span>
        </div>
        <div class="summary-row">
            <span><strong>Total Nilai Stok:</strong></span>
            <span>Rp {{ number_format($products->sum(function($p) { return $p->stock * $p->price; }), 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem KUESAENA</p>
        <p>© {{ date('Y') }} KUESAENA - Malky Production. All Rights Reserved.</p>
    </div>
</body>
</html>

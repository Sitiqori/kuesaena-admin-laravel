@extends('layouts.partials.master')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
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

    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .search-box-wrapper{
    position: relative;
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 10px;
    }

    .search-box-wrapper input {
        border: none;
        outline: none;
        width: 100%;
        font-size: 14px;
    }

    .search-box-wrapper i {
        position: absolute;
        right: 15px;
        font-size: 18px;
        color: #7a7a7a;
    }

    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter-group {
        flex: 1;
    }

    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-box-wrapper {
        position: relative;
        flex: 2;
    }

    .search-box-wrapper input {
        padding-left: 40px;
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
    }

    td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    tbody tr:hover {
        background: #f8f8f8;
    }

    .stock-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
    }

    .stock-low {
        background: #ffebee;
        color: #c62828;
    }

    .stock-ok {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .stock-out {
        background: #fafafa;
        color: #757575;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
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

    .btn-edit {
        background: #fff3e0;
        color: #e65100;
    }

    .btn-edit:hover {
        background: #ffe0b2;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #ffcdd2;
    }

    .pagination-info {
        margin-top: 15px;
        font-size: 14px;
        color: #666;
    }

    /* Modal Styles */
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
        max-width: 600px;
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
        font-weight: bold;
        cursor: pointer;
        color: #999;
        line-height: 1;
    }

    .modal-body {
        padding: 20px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .image-preview {
        width: 100%;
        height: 200px;
        border: 2px dashed #ddd;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
        overflow: hidden;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .image-preview-placeholder {
        text-align: center;
        color: #999;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div></div>
    <div class="header-actions">
        <button class="btn btn-secondary" onclick="exportPDF()">
            📥 Ekspor PDF
        </button>
        <button class="btn btn-primary" onclick="openAddModal()">
            ➕ Tambah Barang
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    ✓ {{ session('success') }}
</div>
@endif

@php
    $lowStockCount = $products->where('stock', '<=', 3)->where('stock', '>', 0)->count();
@endphp

@if($lowStockCount > 0)
<div class="alert alert-warning">
    ⚠️ {{ $lowStockCount }} barang memiliki stok di bawah minimum
</div>
@endif

<div class="content-card">
    <div class="filters">
        <div class="filter-group">
            <select id="categoryFilter" onchange="filterProducts()">
                <option value="">Semua kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-box-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari nama atau kode barang..." onkeyup="filterProducts()">
        </div>


    </div>

    <div class="table-wrapper">
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Kode barang</th>
                    <th>Nama barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>HPP</th>
                    <th>Harga jual</th>
                    <th>Stok</th>
                    <th>Min. stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}" data-code="{{ strtolower($product->code) }}">
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>Pcs</td>
                    <td>Rp {{ number_format($product->price * 0.7, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock == 0)
                            <span class="stock-badge stock-out">0</span>
                        @elseif($product->stock <= 3)
                            <span class="stock-badge stock-low">{{ $product->stock }}</span>
                        @else
                            <span class="stock-badge stock-ok">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>3</td>
                    <td><span class="status-badge">Aktif</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="icon-btn btn-edit" onclick="openEditModal({{ $product->id }})" title="Edit">
                                ✏️
                            </button>
                            <button class="icon-btn btn-delete" onclick="deleteProduct({{ $product->id }})" title="Hapus">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 40px; color: #999;">
                        Belum ada produk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-info">
        Menampilkan {{ $products->count() }} dari {{ $products->count() }} data
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div id="productModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Barang</h3>
            <span class="close-modal" onclick="closeProductModal()">&times;</span>
        </div>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="productId" name="product_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Kode Barang *</label>
                        <input type="text" name="code" id="code" required placeholder="BC-01">
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category_id" id="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Barang *</label>
                    <input type="text" name="name" id="name" required placeholder="Matcha Chocolate">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga Modal (HPP)</label>
                        <input type="number" name="hpp" id="hpp" placeholder="70000">
                    </div>
                    <div class="form-group">
                        <label>Harga Jual *</label>
                        <input type="number" name="price" id="price" required placeholder="100000">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Stok *</label>
                        <input type="number" name="stock" id="stock" required placeholder="10" min="0">
                    </div>
                    <div class="form-group">
                        <label>Stok Minimum</label>
                        <input type="number" name="min_stock" id="min_stock" value="3" placeholder="3" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="description" placeholder="Deskripsi produk..."></textarea>
                </div>

                <div class="form-group">
                    <label>Foto Produk</label>
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                    <div class="image-preview" id="imagePreview">
                        <div class="image-preview-placeholder">
                            <div style="font-size: 40px; margin-bottom: 10px;">📷</div>
                            <div>Upload foto produk</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeProductModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter Products
function filterProducts() {
    const category = document.getElementById('categoryFilter').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#productsTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length === 1) return; // Skip empty row

        const rowCategory = row.dataset.category;
        const rowName = row.dataset.name;
        const rowCode = row.dataset.code;

        const matchCategory = !category || rowCategory === category;
        const matchSearch = !search || rowName.includes(search) || rowCode.includes(search);

        row.style.display = matchCategory && matchSearch ? '' : 'none';
    });
}

// Open Add Modal
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Barang';
    document.getElementById('productForm').action = '{{ route("barang.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    document.getElementById('imagePreview').innerHTML = `
        <div class="image-preview-placeholder">
            <div style="font-size: 40px; margin-bottom: 10px;">📷</div>
            <div>Upload foto produk</div>
        </div>
    `;
    document.getElementById('productModal').classList.add('show');
}

// Open Edit Modal
function openEditModal(id) {
    fetch(`/barang/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Barang';
            document.getElementById('productForm').action = `/barang/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('productId').value = data.id;
            document.getElementById('code').value = data.code;
            document.getElementById('name').value = data.name;
            document.getElementById('category_id').value = data.category_id;
            document.getElementById('hpp').value = data.hpp || Math.round(data.price * 0.7);
            document.getElementById('price').value = data.price;
            document.getElementById('stock').value = data.stock;
            document.getElementById('min_stock').value = data.min_stock || 3;
            document.getElementById('description').value = data.description || '';

            if (data.image) {
                document.getElementById('imagePreview').innerHTML = `
                    <img src="/storage/${data.image}" alt="${data.name}">
                `;
            } else {
                document.getElementById('imagePreview').innerHTML = `
                    <div class="image-preview-placeholder">
                        <div style="font-size: 40px; margin-bottom: 10px;">📷</div>
                        <div>Upload foto produk</div>
                    </div>
                `;
            }

            document.getElementById('productModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data produk');
        });
}

// Close Modal
function closeProductModal() {
    document.getElementById('productModal').classList.remove('show');
}

// Preview Image
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = `
                <img src="${e.target.result}" alt="Preview">
            `;
        };
        reader.readAsDataURL(file);
    }
}

// Delete Product
function deleteProduct(id) {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/barang/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Export PDF
function exportPDF() {
    window.open('/barang/export-pdf', '_blank');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target === modal) {
        closeProductModal();
    }
}
</script>
@endpush

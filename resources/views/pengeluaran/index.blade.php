@extends('layouts.partials.master')

@section('title',    'Pengeluaran')
@section('page-title', 'Pengeluaran')

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

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .total-banner {
        background: linear-gradient(135deg, #ffebee 0%, #fff3e0 100%);
        border: 2px solid #ff5252;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
    }

    .total-banner-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
    }

    .total-banner-amount {
        font-size: 32px;
        font-weight: 700;
        color: #d32f2f;
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

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
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
    }

    tbody tr:hover {
        background: #f8f8f8;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
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
</style>
@endpush

@section('content')
<div class="page-header">
    <div></div>
    <div class="header-actions">
        <button class="btn btn-secondary" onclick="exportPDF()">
            🖨️ Cetak Pengeluaran
        </button>
        <button class="btn btn-primary" onclick="openAddModal()">
            ➕ Tambah Pengeluaran
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    ✓ {{ session('success') }}
</div>
@endif

<!-- Total Banner -->
<div class="total-banner">
    <div class="total-banner-label">Total pengeluaran</div>
    <div class="total-banner-amount">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
</div>

<div class="content-card">
    <!-- Filters Bar -->
    <div class="filters-bar">
        <div class="filter-group">
            <select id="categoryFilter" onchange="filterExpenses()">
                <option value="">Semua kategori</option>
                <option value="Listrik">Listrik</option>
                <option value="Gaji">Gaji</option>
                <option value="Perlengkapan">Perlengkapan</option>
                <option value="Sewa">Sewa</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="filter-group">
            <input type="date" id="dateFilter" onchange="filterExpenses()" placeholder="Filter periode">
        </div>
        <div class="search-box-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari deskripsi pengeluaran..." onkeyup="filterExpenses()">
        </div>
    </div>

    <!-- Table -->
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
                    data-date="{{ $expense->date }}">
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="category-badge badge-{{ strtolower($expense->category) }}">
                            {{ $expense->category }}
                        </span>
                    </td>
                    <td>{{ $expense->description }}</td>
                    <td style="color: #d32f2f; font-weight: 600;">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td>{{ $expense->user->name }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="icon-btn btn-edit" onclick="editExpense({{ $expense->id }})" title="Edit">
                                ✏️
                            </button>
                            <button class="icon-btn btn-delete" onclick="deleteExpense({{ $expense->id }})" title="Hapus">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">💸</div>
                            <div>Belum ada data pengeluaran</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-info">
        Menampilkan <span id="showingCount">{{ $expenses->count() }}</span> dari {{ $expenses->count() }} data
    </div>
</div>

<!-- Add/Edit Expense Modal -->
<div id="expenseModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Pengeluaran</h3>
            <span class="close-modal" onclick="closeExpenseModal()">&times;</span>
        </div>
        <form id="expenseForm" method="POST">
            @csrf
            <input type="hidden" id="expenseId" name="expense_id">
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal *</label>
                        <input type="datetime-local" name="date" id="date" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category" id="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Listrik">Listrik</option>
                            <option value="Gaji">Gaji</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                            <option value="Sewa">Sewa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nominal *</label>
                    <input type="number" name="amount" id="amount" required placeholder="850000" min="0">
                </div>

                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="description" id="description" required placeholder="Bayar listrik bulan desember"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeExpenseModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter Expenses
function filterExpenses() {
    const category = document.getElementById('categoryFilter').value.toLowerCase();
    const date = document.getElementById('dateFilter').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#expensesTable tbody tr');

    let visibleCount = 0;

    rows.forEach(row => {
        if (row.cells.length === 1) return; // Skip empty state row

        const rowCategory = row.dataset.category || '';
        const rowDescription = row.dataset.description || '';
        const rowDate = row.dataset.date || '';

        const matchCategory = !category || rowCategory === category;
        const matchDate = !date || rowDate.startsWith(date);
        const matchSearch = !search || rowDescription.includes(search);

        if (matchCategory && matchDate && matchSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('showingCount').textContent = visibleCount;
}

// Open Add Modal
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Pengeluaran';
    document.getElementById('expenseForm').action = '{{ route("pengeluaran.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('expenseForm').reset();
    document.getElementById('expenseId').value = '';

    // Set default datetime to now
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('date').value = now.toISOString().slice(0, 16);

    document.getElementById('expenseModal').classList.add('show');
}

// Edit Expense
function editExpense(id) {
    fetch(`/pengeluaran/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Pengeluaran';
            document.getElementById('expenseForm').action = `/pengeluaran/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('expenseId').value = data.id;

            // Parse date to datetime-local format
            const date = new Date(data.date);
            date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
            document.getElementById('date').value = date.toISOString().slice(0, 16);

            document.getElementById('category').value = data.category;
            document.getElementById('amount').value = data.amount;
            document.getElementById('description').value = data.description;

            document.getElementById('expenseModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data pengeluaran');
        });
}

// Close Modal
function closeExpenseModal() {
    document.getElementById('expenseModal').classList.remove('show');
}

// Delete Expense
function deleteExpense(id) {
    if (confirm('Yakin ingin menghapus pengeluaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pengeluaran/${id}`;
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
    const category = document.getElementById('categoryFilter').value;
    const date = document.getElementById('dateFilter').value;

    let url = '/pengeluaran/export-pdf?';
    if (category) url += `category=${category}&`;
    if (date) url += `date=${date}`;

    window.open(url, '_blank');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('expenseModal');
    if (event.target === modal) {
        closeExpenseModal();
    }
}
</script>
@endpush

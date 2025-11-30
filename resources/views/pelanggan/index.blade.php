@extends('layouts.partials.master')

@section('title', 'Manajemen Pelanggan')
@section('page-title', 'Manajemen Pelanggan')

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
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }

    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .content-header {
        margin-bottom: 20px;
    }

    .content-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .search-box-wrapper {
        position: relative;
        max-width: 400px;
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

    .customers-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .customer-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
    }

    .customer-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #5C4033;
    }

    .customer-checkbox {
        display: flex;
        align-items: center;
    }

    .customer-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .customer-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #C19A6B 0%, #8B6F47 100%);
        color: white;
        font-size: 24px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .customer-info {
        flex: 1;
    }

    .customer-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .customer-contact {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }

    .customer-address {
        font-size: 13px;
        color: #999;
    }

    .customer-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .customer-stats {
        text-align: right;
        margin-right: 15px;
    }

    .customer-stats-label {
        font-size: 12px;
        color: #999;
        margin-bottom: 4px;
    }

    .customer-stats-value {
        font-size: 18px;
        font-weight: 700;
        color: #5C4033;
    }

    .btn-action {
        padding: 10px 18px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-history {
        background: #5C4033;
        color: white;
    }

    .btn-history:hover {
        background: #4A3329;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
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
        max-width: 900px;
        margin: 20px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
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
        overflow-y: auto;
        flex: 1;
    }

    .customer-detail-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #f8f8f8;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .customer-detail-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C19A6B 0%, #8B6F47 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 600;
    }

    .customer-detail-info h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .customer-detail-contact {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }

    .order-history-section h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #5C4033;
    }

    .order-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 12px;
        transition: all 0.3s;
    }

    .order-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .order-number {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .order-date {
        font-size: 13px;
        color: #999;
    }

    .order-items-list {
        margin-bottom: 10px;
    }

    .order-product {
        font-size: 13px;
        color: #666;
        padding: 4px 0;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .order-total {
        font-size: 16px;
        font-weight: 700;
        color: #5C4033;
    }

    .order-payment {
        font-size: 13px;
        color: #666;
    }

    .no-orders {
        text-align: center;
        padding: 40px;
        color: #999;
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
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-info">
            <h4>Total Pelanggan</h4>
            <div class="stat-value">{{ $totalPelanggan }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🛒</div>
        <div class="stat-info">
            <h4>Total Pembelian</h4>
            <div class="stat-value">{{ $totalPembelian }}</div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    ✓ {{ session('success') }}
</div>
@endif

<div class="content-card">
    <div class="content-header">
        <h3>Data Pelanggan</h3>
        <div class="search-box-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari nama, telepon, atau alamat..." onkeyup="filterCustomers()">
        </div>
    </div>

    <div class="customers-list" id="customersList">
        @forelse($customers as $customer)
        <div class="customer-card" data-name="{{ strtolower($customer->name) }}"
             data-phone="{{ strtolower($customer->phone) }}"
             data-address="{{ strtolower($customer->address) }}">
            <div class="customer-checkbox">
                <input type="checkbox" id="customer-{{ $customer->id }}">
            </div>

            <div class="customer-avatar">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>

            <div class="customer-info">
                <div class="customer-name">{{ $customer->name }}</div>
                <div class="customer-contact">📞 {{ $customer->phone }}</div>
                <div class="customer-address">📍 {{ $customer->address }}</div>
            </div>

            <div class="customer-actions">
                <div class="customer-stats">
                    <div class="customer-stats-label">Total Pesanan</div>
                    <div class="customer-stats-value">{{ $customer->orders_count }}</div>
                </div>

                <button class="btn-action btn-history" onclick="showCustomerHistory({{ $customer->id }})">
                    📋 Riwayat Pesanan
                </button>

                <button class="icon-btn btn-edit" onclick="editCustomer({{ $customer->id }})" title="Edit">
                    ✏️
                </button>

                <button class="icon-btn btn-delete" onclick="deleteCustomer({{ $customer->id }})" title="Hapus">
                    🗑️
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div>Belum ada data pelanggan</div>
        </div>
        @endforelse
    </div>
</div>

<!-- Customer History Modal -->
<div id="historyModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Riwayat Pesanan</h3>
            <span class="close-modal" onclick="closeHistoryModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalHistoryContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div id="editModal" class="modal">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-header">
            <h3>Edit Data Pelanggan</h3>
            <span class="close-modal" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="editCustomerForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Nama</label>
                    <input type="text" name="name" id="editName" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">No. Telepon</label>
                    <input type="text" name="phone" id="editPhone" required
                           style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Alamat</label>
                    <textarea name="address" id="editAddress" rows="3"
                              style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #e0e0e0; display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-action" onclick="closeEditModal()"
                        style="background: white; border: 1px solid #ddd; color: #333;">
                    Batal
                </button>
                <button type="submit" class="btn-action btn-history">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter Customers
function filterCustomers() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.customer-card');

    cards.forEach(card => {
        const name = card.dataset.name || '';
        const phone = card.dataset.phone || '';
        const address = card.dataset.address || '';

        if (name.includes(search) || phone.includes(search) || address.includes(search)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Show Customer History
function showCustomerHistory(customerId) {
    fetch(`/pelanggan/${customerId}`)
        .then(response => response.json())
        .then(data => {
            const customer = data.customer;

            let ordersHtml = '';
            if (customer.orders && customer.orders.length > 0) {
                customer.orders.forEach(order => {
                    let itemsHtml = '';
                    order.order_items.forEach(item => {
                        itemsHtml += `
                            <div class="order-product">
                                • ${item.product.name} (x${item.quantity}) - Rp ${formatNumber(item.subtotal)}
                            </div>
                        `;
                    });

                    ordersHtml += `
                        <div class="order-item">
                            <div class="order-item-header">
                                <div class="order-number">${order.order_number}</div>
                                <div class="order-date">${new Date(order.created_at).toLocaleDateString('id-ID')}</div>
                            </div>
                            <div class="order-items-list">
                                ${itemsHtml}
                            </div>
                            <div class="order-footer">
                                <div class="order-total">Rp ${formatNumber(order.total)}</div>
                                <div class="order-payment">${order.payment_method.toUpperCase()}</div>
                            </div>
                        </div>
                    `;
                });
            } else {
                ordersHtml = '<div class="no-orders">Belum ada riwayat pesanan</div>';
            }

            const content = `
                <div class="customer-detail-header">
                    <div class="customer-detail-avatar">
                        ${customer.name.charAt(0).toUpperCase()}
                    </div>
                    <div class="customer-detail-info">
                        <h2>${customer.name}</h2>
                        <div class="customer-detail-contact">📞 ${customer.phone}</div>
                        <div class="customer-detail-contact">📍 ${customer.address}</div>
                    </div>
                </div>

                <div class="order-history-section">
                    <h4>Riwayat Pesanan (${customer.orders.length})</h4>
                    ${ordersHtml}
                </div>
            `;

            document.getElementById('modalHistoryContent').innerHTML = content;
            document.getElementById('historyModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data pelanggan');
        });
}

function closeHistoryModal() {
    document.getElementById('historyModal').classList.remove('show');
}

// Edit Customer
function editCustomer(customerId) {
    fetch(`/pelanggan/${customerId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editName').value = data.name;
            document.getElementById('editPhone').value = data.phone;
            document.getElementById('editAddress').value = data.address || '';
            document.getElementById('editCustomerForm').action = `/pelanggan/${customerId}`;
            document.getElementById('editModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data pelanggan');
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

// Delete Customer
function deleteCustomer(customerId) {
    if (confirm('Yakin ingin menghapus pelanggan ini? Riwayat pesanan akan tetap tersimpan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/pelanggan/${customerId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const historyModal = document.getElementById('historyModal');
    const editModal = document.getElementById('editModal');

    if (event.target === historyModal) {
        closeHistoryModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
}
</script>
@endpush

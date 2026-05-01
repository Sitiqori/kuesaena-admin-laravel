@extends('layouts.partials.master')

@section('title', 'Kasir')
@section('page-title', 'Kasir')

@push('styles')
<style>
    .kasir-container {
        display: flex;
        gap: 20px;
        height: calc(100vh - 200px);
    }

    .products-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .search-filter {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .search-box-kasir {
        position: relative;
        margin-bottom: 15px;
    }

    .search-box-kasir input {
        width: 100%;
        padding: 12px 40px 12px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .search-box-kasir i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .category-tabs {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .category-tab {
        padding: 8px 20px;
        border: none;
        background: #f5f5f5;
        color: #666;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .category-tab:hover {
        background: #e0e0e0;
    }

    .category-tab.active {
        background: #5C4033;
        color: white;
    }

    .products-grid {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .products-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }

    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .product-image {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .product-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(92, 64, 51, 0.9);
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .product-info {
        padding: 12px;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-code {
        font-size: 11px;
        color: #999;
        margin-bottom: 8px;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        font-size: 15px;
        font-weight: 700;
        color: #5C4033;
    }

    .product-stock {
        font-size: 11px;
        color: #666;
    }

    .add-btn {
        width: 32px;
        height: 32px;
        background: #5C4033;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s;
    }

    .add-btn:hover {
        background: #4A3329;
        transform: scale(1.1);
    }

    .cart-section {
        width: 380px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }

    .cart-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
    }

    .cart-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
    }

    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-cart-icon {
        font-size: 60px;
        margin-bottom: 10px;
        opacity: 0.3;
    }

    .cart-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .cart-item-image {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .cart-item-price {
        font-size: 13px;
        color: #5C4033;
        font-weight: 600;
    }

    .cart-item-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .qty-btn {
        width: 24px;
        height: 24px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px;
        font-size: 13px;
    }

    .remove-btn {
        margin-left: auto;
        color: #ff4444;
        cursor: pointer;
        font-size: 18px;
    }

    .cart-summary {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
    }

    .ppn-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding: 12px;
        background: #f8f8f8;
        border-radius: 6px;
    }

    .ppn-toggle label {
        font-size: 14px;
        font-weight: 500;
    }

    .toggle-switch {
        position: relative;
        width: 50px;
        height: 26px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #5C4033;
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .summary-row.total {
        font-size: 16px;
        font-weight: 700;
        color: #5C4033;
        padding-top: 10px;
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
    }

    .checkout-btn {
        width: 100%;
        padding: 16px;
        background: #5C4033;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 15px;
    }

    .checkout-btn:hover {
        background: #4A3329;
    }

    .checkout-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
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
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .modal-header h2 {
        font-size: 20px;
        font-weight: 700;
    }

    .close-modal {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
        line-height: 1;
    }

    .form-group-modal {
        margin-bottom: 20px;
    }

    .form-group-modal label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
    }

    .form-group-modal input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    .payment-method {
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-method:hover {
        border-color: #5C4033;
    }

    .payment-method.active {
        border-color: #5C4033;
        background: #f8f5f3;
    }

    .payment-method-icon {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .payment-method-label {
        font-size: 13px;
        font-weight: 500;
    }

    .total-display {
        background: #f8f5f3;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .total-display-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 5px;
    }

    .total-display-amount {
        font-size: 24px;
        font-weight: 700;
        color: #5C4033;
    }

    .quick-amount {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-top: 10px;
    }

    .quick-amount-btn {
        padding: 10px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
    }

    .quick-amount-btn:hover {
        background: #f5f5f5;
    }

    .change-display {
        background: #e8f5e9;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .change-display-label {
        font-size: 13px;
        color: #2e7d32;
        margin-bottom: 5px;
    }

    .change-display-amount {
        font-size: 20px;
        font-weight: 700;
        color: #1b5e20;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-secondary {
        flex: 1;
        padding: 14px;
        background: white;
        border: 2px solid #5C4033;
        color: #5C4033;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary {
        flex: 1;
        padding: 14px;
        background: #5C4033;
        border: none;
        color: white;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="kasir-container">
    <!-- Products Section -->
    <div class="products-section">
        <!-- Search & Filter -->
        <div class="search-filter">
            <div class="search-box-kasir">
                <input type="text" id="searchProduct" placeholder="Cari produk (F2)">
                <i>🔍</i>
            </div>
            <div class="category-tabs">
                <button class="category-tab active" data-category="all">Semua produk</button>
                @foreach($categories as $category)
                <button class="category-tab" data-category="{{ $category->id }}">{{ $category->name }}</button>
                @endforeach
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            <div class="products-wrapper" id="productsWrapper">
                @foreach($products as $product)
                <div class="product-card" data-category="{{ $product->category_id }}"
                     onclick="addToCart({{ json_encode($product) }})">
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.jpg') }}"
                         alt="{{ $product->name }}" class="product-image">
                    <span class="product-badge">{{ $product->category->name }}</span>
                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-code">{{ $product->code }}</div>
                        <div class="product-footer">
                            <div>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-stock">Stok: {{ $product->stock }}</div>
                            </div>
                            <button class="add-btn" onclick="event.stopPropagation(); addToCart({{ json_encode($product) }})">+</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="cart-section">
        <div class="cart-header">
            <h3>Ringkasan Pembayaran</h3>
            <div style="font-size: 13px; color: #666;">Item Dipilih: <span id="itemCount">0</span></div>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <p>Keranjang masih kosong</p>
            </div>
        </div>

        <div class="cart-summary">
            <div class="ppn-toggle">
                <label>PPN 11%</label>
                <label class="toggle-switch">
                    <input type="checkbox" id="ppnToggle">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="summary-row">
                <span>Sub total</span>
                <span id="subtotalAmount">Rp 0</span>
            </div>
            <div class="summary-row" id="ppnRow" style="display: none;">
                <span>PPN (11%)</span>
                <span id="ppnAmount">Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total pembayaran</span>
                <span id="totalAmount">Rp 0</span>
            </div>

            <button class="checkout-btn" id="checkoutBtn" onclick="openPaymentModal()" disabled>
                Bayar (F9)
            </button>

            <button class="checkout-btn" style="background: #dc3545; margin-top: 10px;" onclick="clearCart()">
                Hapus keranjang
            </button>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Pembayaran</h2>
            <span class="close-modal" onclick="closePaymentModal()">&times;</span>
        </div>

        <form id="paymentForm">
            <div class="form-group-modal">
                <label>Nama</label>
                <input type="text" id="customerName" placeholder="Qori" value="Umum">
            </div>

            <div class="form-group-modal">
                <label>Alamat</label>
                <input type="text" id="customerAddress" placeholder="Perum Arrasy D4">
            </div>

            <div class="total-display">
                <div class="total-display-label">Total yang harus dibayar:</div>
                <div class="total-display-amount" id="modalTotalAmount">Rp 0</div>
            </div>

            <div class="form-group-modal">
                <label>Metode pembayaran</label>
                <div class="payment-methods">
                    <div class="payment-method active" data-method="cash">
                        <div class="payment-method-icon">💵</div>
                        <div class="payment-method-label">Tunai</div>
                    </div>
                    <div class="payment-method" data-method="qris">
                        <div class="payment-method-icon">📱</div>
                        <div class="payment-method-label">QRIS</div>
                    </div>
                    <div class="payment-method" data-method="debit">
                        <div class="payment-method-icon">💳</div>
                        <div class="payment-method-label">Debit</div>
                    </div>
                </div>
            </div>

            <div class="form-group-modal" id="cashPaymentSection">
                <label>Jumlah bayar</label>
                <input type="text" id="paymentAmount" placeholder="Rp 50.000" oninput="calculateChange()">
                <div class="quick-amount">
                    <button type="button" class="quick-amount-btn" onclick="setQuickAmount(50000)">Rp 50.000</button>
                    <button type="button" class="quick-amount-btn" onclick="setQuickAmount(100000)">Rp 100.000</button>
                    <button type="button" class="quick-amount-btn" onclick="setQuickAmount(150000)">Rp 150.000</button>
                    <button type="button" class="quick-amount-btn" onclick="setQuickAmount(200000)">Rp 200.000</button>
                </div>
                <div class="change-display" id="changeDisplay" style="display: none;">
                    <div class="change-display-label">Kembalian:</div>
                    <div class="change-display-amount" id="changeAmount">Rp 0</div>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="printWithoutSave()">
                    🖨️ Simpan tanpa cetak resi
                </button>
                <button type="button" class="btn-primary" onclick="processPayment()">
                    🖨️ Simpan & Cetak resi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let cart = [];
let selectedPaymentMethod = 'cash';

// Category Filter
document.querySelectorAll('.category-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        const category = this.dataset.category;
        const products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            if (category === 'all' || product.dataset.category === category) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
});

// Search Product
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const products = document.querySelectorAll('.product-card');

    products.forEach(product => {
        const name = product.querySelector('.product-name').textContent.toLowerCase();
        const code = product.querySelector('.product-code').textContent.toLowerCase();

        if (name.includes(search) || code.includes(search)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});

// Add to Cart
function addToCart(product) {
    const existingItem = cart.find(item => item.id === product.id);

    if (existingItem) {
        if (existingItem.quantity < product.stock) {
            existingItem.quantity++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            code: product.code,
            price: product.price,
            image: product.image,
            stock: product.stock,
            quantity: 1
        });
    }

    renderCart();
}

// Render Cart
function renderCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    const itemCount = document.getElementById('itemCount');

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <p>Keranjang masih kosong</p>
            </div>
        `;
        itemCount.textContent = '0';
        document.getElementById('checkoutBtn').disabled = true;
    } else {
        let html = '';
        let totalItems = 0;

        cart.forEach((item, index) => {
            totalItems += item.quantity;
            const imageSrc = item.image ? '{{ asset("storage") }}/' + item.image : '{{ asset("images/no-image.jpg") }}';

            html += `
                <div class="cart-item">
                    <img src="${imageSrc}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">Rp ${formatNumber(item.price)}</div>
                        <div class="cart-item-controls">
                            <button class="qty-btn" onclick="decreaseQty(${index})">-</button>
                            <input type="number" class="qty-input" value="${item.quantity}"
                                   onchange="updateQty(${index}, this.value)" min="1" max="${item.stock}">
                            <button class="qty-btn" onclick="increaseQty(${index})">+</button>
                            <span class="remove-btn" onclick="removeFromCart(${index})">🗑️</span>
                        </div>
                    </div>
                </div>
            `;
        });

        cartItemsDiv.innerHTML = html;
        itemCount.textContent = totalItems;
        document.getElementById('checkoutBtn').disabled = false;
    }

    calculateTotal();
}

// Update Quantity
function increaseQty(index) {
    if (cart[index].quantity < cart[index].stock) {
        cart[index].quantity++;
        renderCart();
    } else {
        alert('Stok tidak mencukupi!');
    }
}

function decreaseQty(index) {
    if (cart[index].quantity > 1) {
        cart[index].quantity--;
        renderCart();
    }
}

function updateQty(index, value) {
    const qty = parseInt(value);
    if (qty > 0 && qty <= cart[index].stock) {
        cart[index].quantity = qty;
        renderCart();
    } else {
        alert('Jumlah tidak valid!');
        renderCart();
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

function clearCart() {
    if (confirm('Yakin ingin menghapus semua item?')) {
        cart = [];
        renderCart();
    }
}

// Calculate Total
function calculateTotal() {
    const ppnEnabled = document.getElementById('ppnToggle').checked;
    let subtotal = 0;

    cart.forEach(item => {
        subtotal += item.price * item.quantity;
    });

    const ppn = ppnEnabled ? subtotal * 0.11 : 0;
    const total = subtotal + ppn;

    document.getElementById('subtotalAmount').textContent = 'Rp ' + formatNumber(subtotal);
    document.getElementById('ppnAmount').textContent = 'Rp ' + formatNumber(ppn);
    document.getElementById('totalAmount').textContent = 'Rp ' + formatNumber(total);

    document.getElementById('ppnRow').style.display = ppnEnabled ? 'flex' : 'none';
}

document.getElementById('ppnToggle').addEventListener('change', calculateTotal);

// Payment Modal
function openPaymentModal() {
    const total = calculateFinalTotal();
    document.getElementById('modalTotalAmount').textContent = 'Rp ' + formatNumber(total);
    document.getElementById('paymentModal').classList.add('show');
    document.getElementById('paymentAmount').value = '';
    document.getElementById('changeDisplay').style.display = 'none';
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('show');
}

// Payment Method Selection
document.querySelectorAll('.payment-method').forEach(method => {
    method.addEventListener('click', function() {
        document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
        this.classList.add('active');
        selectedPaymentMethod = this.dataset.method;

        if (selectedPaymentMethod === 'cash') {
            document.getElementById('cashPaymentSection').style.display = 'block';
        } else {
            document.getElementById('cashPaymentSection').style.display = 'none';
        }
    });
});

function setQuickAmount(amount) {
    document.getElementById('paymentAmount').value = 'Rp ' + formatNumber(amount);
    calculateChange();
}

function calculateChange() {
    const paymentInput = document.getElementById('paymentAmount').value.replace(/[^0-9]/g, '');
    const payment = parseInt(paymentInput) || 0;
    const total = calculateFinalTotal();
    const change = payment - total;

    if (change >= 0) {
        document.getElementById('changeDisplay').style.display = 'block';
        document.getElementById('changeAmount').textContent = 'Rp ' + formatNumber(change);
    } else {
        document.getElementById('changeDisplay').style.display = 'none';
    }
}

function calculateFinalTotal() {
    const ppnEnabled = document.getElementById('ppnToggle').checked;
    let subtotal = 0;

    cart.forEach(item => {
        subtotal += item.price * item.quantity;
    });

    const ppn = ppnEnabled ? subtotal * 0.11 : 0;
    return subtotal + ppn;
}

// Process Payment
function processPayment() {
    const customerName = document.getElementById('customerName').value || 'Umum';
    const customerAddress = document.getElementById('customerAddress').value || '-';
    const total = calculateFinalTotal();

    if (selectedPaymentMethod === 'cash') {
        const paymentInput = document.getElementById('paymentAmount').value.replace(/[^0-9]/g, '');
        const payment = parseInt(paymentInput) || 0;

        if (payment < total) {
            alert('Jumlah pembayaran kurang!');
            return;
        }
    }

    // Prepare order data
    const orderData = {
        customer_name: customerName,
        customer_address: customerAddress,
        payment_method: selectedPaymentMethod,
        ppn_enabled: document.getElementById('ppnToggle').checked,
        items: cart,
        _token: '{{ csrf_token() }}'
    };

    // Send to server
    fetch('{{ route("kasir.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Print receipt
            printReceipt(data.order);

            // Clear cart
            cart = [];
            renderCart();
            closePaymentModal();

            alert('Transaksi berhasil!');
        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pembayaran');
    });
}

function printWithoutSave() {
    // Same as processPayment but without printing
    processPayment();
}

// Print Receipt
function printReceipt(order) {
    const printWindow = window.open('', '', 'width=300,height=600');

    let itemsHtml = '';
    order.items.forEach(item => {
        itemsHtml += `
            <tr>
                <td>${item.name}</td>
                <td style="text-align: center;">${item.quantity}</td>
                <td style="text-align: right;">Rp ${formatNumber(item.price)}</td>
                <td style="text-align: right;">Rp ${formatNumber(item.subtotal)}</td>
            </tr>
        `;
    });

    const ppnRow = order.tax > 0 ? `
        <tr>
            <td colspan="3">Sub-Total</td>
            <td style="text-align: right;">Rp ${formatNumber(order.subtotal)}</td>
        </tr>
        <tr>
            <td colspan="3">PPN (11%)</td>
            <td style="text-align: right;">Rp ${formatNumber(order.tax)}</td>
        </tr>
    ` : '';

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Struk Pembayaran</title>
            <style>
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    margin: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                    border-bottom: 2px dashed #000;
                    padding-bottom: 10px;
                }
                .header h2 {
                    margin: 5px 0;
                }
                .info {
                    margin-bottom: 15px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 5px 0;
                }
                th {
                    text-align: left;
                    border-bottom: 1px solid #000;
                }
                .total-section {
                    border-top: 2px dashed #000;
                    margin-top: 10px;
                    padding-top: 10px;
                }
                .total-row {
                    display: flex;
                    justify-content: space-between;
                    font-weight: bold;
                    font-size: 14px;
                    margin: 5px 0;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    border-top: 2px dashed #000;
                    padding-top: 10px;
                    font-size: 11px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>KUESAENA</h2>
                <p>Malky Production</p>
                <p>Perum Malky Mas Residence A, Bajobella No.No. 8A, Gapura Tasikmalaya</p>
                <p>No Telp: 0812-3387-2318-8</p>
            </div>

            <div class="info">
                <div>Tanggal: ${new Date().toLocaleDateString('id-ID')}</div>
                <div>Jam: ${new Date().toLocaleTimeString('id-ID')}</div>
                <div>No. Transaksi: ${order.order_number}</div>
                <div>Kasir: {{ auth()->user()->name }}</div>
                <div>Pelanggan: ${order.customer_name}</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemsHtml}
                </tbody>
            </table>

            <div class="total-section">
                ${ppnRow}
                <div class="total-row">
                    <span>Total</span>
                    <span>Rp ${formatNumber(order.total)}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 5px 0;">
                    <span>Bayar (${order.payment_method})</span>
                    <span>Rp ${formatNumber(order.payment_amount || order.total)}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin: 5px 0;">
                    <span>Kembalian</span>
                    <span>Rp ${formatNumber(order.change || 0)}</span>
                </div>
            </div>

            <div class="footer">
                <p>Terimakasih Atas Kunjungannya</p>
                <p>---</p>
                <p>USB KAFE & Sosm1</p>
                <p>https://kuesaena.com/USB KAFE 1M-2507577777</p>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

// Helper Functions
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Keyboard Shortcuts
document.addEventListener('keydown', function(e) {
    // F2 - Focus search
    if (e.key === 'F2') {
        e.preventDefault();
        document.getElementById('searchProduct').focus();
    }

    // F9 - Checkout
    if (e.key === 'F9') {
        e.preventDefault();
        if (cart.length > 0) {
            openPaymentModal();
        }
    }

    // ESC - Close modal
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});
</script>
@endpush

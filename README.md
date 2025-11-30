# KUESAENA - Sistem Manajemen Toko Kue

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Sistem manajemen toko kue berbasis web yang modern dan lengkap. Dibangun dengan Laravel 11, sistem ini menyediakan fitur Point of Sale (POS), manajemen inventori, tracking pesanan, laporan penjualan, dan banyak lagi.

## 📸 Screenshots
### POS/Kasir


## ✨ Fitur Utama

### 🔐 Authentication & Authorization
- Login/Register dengan validasi
- Multi-role system (Admin & Kasir)
- Auto redirect berdasarkan role
- Session management & CSRF protection

### 📊 Dashboard Admin
- 4 kartu statistik real-time
- Grafik interaktif dengan 3 mode tampilan
- Filter data per bulan (12 bulan)
- Recent orders display
- Export laporan PDF

### 💰 Point of Sale (POS/Kasir)
- Product grid dengan filter kategori
- Shopping cart interaktif
- Toggle PPN 11%
- Multi metode pembayaran (Cash, QRIS, Debit)
- Auto calculate kembalian
- Print struk otomatis
- Keyboard shortcuts (F2, F9, ESC)
- Real-time stock validation

### 📦 Manajemen Barang & Stok
- CRUD produk lengkap
- Upload gambar produk
- Filter & search produk
- Stock alert (warning untuk stok rendah)
- Export data ke PDF
- Track stok minimum

### 📋 Manajemen Pesanan
- Dual tabs: Pesanan Baru & Diproses
- Status workflow (Pending → Processing → Completed)
- Detail modal untuk setiap pesanan
- Update status pesanan
- Track progress pembuatan

### 📜 Riwayat Transaksi
- List semua transaksi completed
- Filter by tanggal
- Search transaksi
- Detail modal lengkap
- Reprint struk kapan saja

### 👥 Manajemen Pelanggan
- Auto-create dari transaksi kasir
- History pesanan per customer
- CRUD data pelanggan
- Search & filter
- Skip "Umum" customer

### 💸 Manajemen Pengeluaran
- CRUD expenses lengkap
- 5 kategori pengeluaran (Listrik, Gaji, Perlengkapan, Sewa, Lainnya)
- Triple filter (kategori, tanggal, search)
- Color-coded badges
- Export PDF dengan summary

### 👤 Manajemen Admin/User
- List semua users (Admin & Kasir)
- Change role dynamically
- Activate/Deactivate users
- User statistics (transaksi & penjualan)
- Cannot deactivate own account
- Detail modal per user

### 📈 Laporan Penjualan
- 4 statistics cards
- Chart interaktif (Pendapatan, Pengeluaran, Perbandingan)
- **TOP 10 Produk Terlaris** dengan medals (🥇🥈🥉)
- Detail pengeluaran dengan filter
- Export PDF lengkap (multi-page)
- Filter per bulan

## 🛠️ Tech Stack

- **Framework:** Laravel 11.x
- **PHP:** 8.2+
- **Database:** MySQL 8.0
- **Frontend:** Blade Templates, Vanilla JavaScript
- **Charts:** Chart.js 4.4.0
- **PDF Generator:** DomPDF (barryvdh/laravel-dompdf)
- **Icons:** Emoji (dapat diganti dengan Font Awesome)

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (optional, untuk asset compilation)
- Web Server (Apache/Nginx)

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/kuesaena.git
cd kuesaena
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kuesaena
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Database Setup

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=DemoProductSeeder
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Run Development Server

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## 👤 Default Login

### Admin
- **Email:** owner@gmail.com
- **Password:** Coba1234

### Kasir
- **Email:** (daftar )
- **Password:** 

## 📁 Project Structure

```
kuesaena/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Dashboard/
│   │   │   ├── Kasir/
│   │   │   ├── Barang/
│   │   │   ├── Pesanan/
│   │   │   ├── Transaksi/
│   │   │   ├── Pelanggan/
│   │   │   ├── Pengeluaran/
│   │   │   ├── Laporan/
│   │   │   └── ManajemenAdmin/
│   │   └── Middleware/
│   │       └── IsAdmin.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Customer.php
│       ├── Order.php
│       ├── OrderItem.php
│       └── Expense.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       ├── layouts/
│       ├── dashboard/
│       ├── kasir/
│       ├── barang/
│       ├── pesanan/
│       ├── transaksi/
│       ├── pelanggan/
│       ├── pengeluaran/
│       ├── laporan/
│       └── manajemen-admin/
└── routes/
    └── web.php
```

## 🗄️ Database Schema

### Users
- id, name, email, password, role, is_active, office

### Categories
- id, name, description

### Products
- id, category_id, name, code, stock, price, image, description

### Customers
- id, name, phone, address

### Orders
- id, customer_id, user_id, order_number, subtotal, tax, discount, total, payment_method, status

### Order Items
- id, order_id, product_id, quantity, price, subtotal

### Expenses
- id, user_id, category, amount, description, date

## 🎯 Key Features Detail

### Role-Based Access Control

**Admin Access:**
- Dashboard dengan analytics
- Semua menu & fitur
- Manajemen user
- Laporan lengkap
- Pengeluaran
- Kategori

**Kasir Access:**
- Kasir/POS
- Barang & Stok
- Pesanan
- Riwayat Transaksi
- Manajemen Pelanggan

### POS Workflow

```
1. Pilih produk → Add to cart
2. Review cart items
3. Toggle PPN (optional)
4. Klik "Bayar"
5. Isi nama customer
6. Pilih metode pembayaran
7. Input jumlah bayar (jika Cash)
8. Auto calculate kembalian
9. Cetak struk
10. Order saved dengan status "completed"
```

### Order Status Flow

```
Pending → Processing → Completed
   ↓
Cancelled
```

### PDF Exports

1. **Dashboard PDF** - Summary bulanan
2. **Barang PDF** - Daftar produk + stock
3. **Pengeluaran PDF** - Detail expenses + summary
4. **Laporan PDF** - Comprehensive report (penjualan + pengeluaran + top products)


## 🔒 Security Features

- ✅ CSRF Protection on all forms
- ✅ Password hashing dengan bcrypt
- ✅ SQL Injection prevention (Eloquent ORM)
- ✅ XSS Protection
- ✅ Role-based middleware
- ✅ Session management
- ✅ Input validation on all forms

## 📱 Responsive Design

Sistem fully responsive dan dapat diakses dari:
- 💻 Desktop
- 📱 Tablet
- 📱 Mobile

## 🐛 Known Issues & Limitations

1. **Expense tracking** menggunakan placeholder data untuk chart. Untuk production, integrate dengan model Expense yang real.
2. **Stock history** belum diimplementasi. Saat ini hanya track stock saat ini.
3. **Multi-image upload** untuk produk belum tersedia (1 gambar per produk).
4. **Email notifications** belum diimplementasi.
5. **Barcode scanning** belum tersedia.

## 🔮 Future Enhancements

- [ ] Barcode generator & scanner
- [ ] Multi-image upload untuk produk
- [ ] Email notifications (order status, low stock)
- [ ] WhatsApp integration
- [ ] Loyalty points system
- [ ] Advanced analytics & forecasting
- [ ] Mobile app (React Native)
- [ ] Multi-branch support
- [ ] API untuk integrasi external
- [ ] Backup & restore database

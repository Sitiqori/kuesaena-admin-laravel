<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\Customer\AboutController;
use App\Http\Controllers\Customer\CustomerPesananController;
use App\Http\Controllers\Customer\CustomerRewardController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\KeranjangController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\ProfilController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Kategori\KategoriController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\ManajemenAdmin\AdminController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Pengeluaran\PengeluaranController;
use App\Http\Controllers\Pesanan\PesananController;
use App\Http\Controllers\Transaksi\RiwayatTransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ROOT
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        if (Auth::user()->role === 'kasir') {
            return redirect()->route('kasir.index');
        }
    }
    return app(HomeController::class)->index();
})->name('customer.home');

// CUSTOMER PUBLIC

Route::get('/menu', [ProductController::class, 'index'])->name('customer.menu');

Route::get('/about',[AboutController::class, 'index'])->name('customer.about');
Route::get('/produk/{id}',[ProductController::class,'show'])->name('customer.product.show');

// AUTH
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// PROTECTED
Route::middleware(['auth'])->group(function () {

    // KERANJANG
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/hapus-semua', [KeranjangController::class, 'hapusSemua'])->name('keranjang.hapusSemua');

    // PROFIL CUSTOMER
    Route::get('/profil', [ProfilController::class, 'index'])->name('customer.profil');
    Route::post('/profil', [ProfilController::class, 'updateProfil'])->name('customer.profil.update');
    Route::post('/profil/photo', [ProfilController::class, 'updatePhoto'])->name('customer.profil.update.photo');
    Route::get('/profil/alamat', [ProfilController::class, 'alamat'])->name('customer.profil.alamat');
    Route::post('/profil/alamat', [ProfilController::class, 'alamatStore'])->name('customer.profil.alamat.store');
    Route::put('/profil/alamat/{id}', [ProfilController::class, 'alamatUpdate'])->name('customer.profil.alamat.update');
    Route::delete('/profil/alamat/{id}', [ProfilController::class, 'alamatDestroy'])->name('customer.profil.alamat.destroy');
    Route::get('/profil/password', [ProfilController::class, 'password'])->name('customer.profil.password');
    Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('customer.profil.password.update');
    Route::get('/profil/notifikasi', [ProfilController::class, 'notifikasi'])->name('customer.profil.notifikasi');
    Route::post('/profil/notifikasi', [ProfilController::class, 'updateNotifikasi'])->name('customer.profil.notifikasi.update');
    Route::get('/profil/privasi', [ProfilController::class, 'privasi'])->name('customer.profil.privasi');
    Route::delete('/profil/privasi/hapus-akun', [ProfilController::class, 'deleteAccount'])->name('customer.profil.privasi.hapus');
    // PESANAN CUSTOMER
    Route::get('/pesanan-saya', [CustomerPesananController::class, 'index'])->name('customer.pesanan');
    Route::get('/pesanan-saya/{id}', [CustomerPesananController::class, 'show'])->name('customer.pesanan.show');

    // REWARD CUSTOMER
    Route::get('/reward-saya', [CustomerRewardController::class, 'index'])->name('customer.reward');
    Route::post('/reward-saya/{id}/redeem', [CustomerRewardController::class, 'redeem'])->name('customer.reward.redeem');

    // ADMIN ONLY
    Route::middleware(['is.admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf');
        Route::resource('kategori', KategoriController::class);
        Route::get('/pengeluaran/export-pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export-pdf');
        Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
        Route::resource('pengeluaran', PengeluaranController::class)->except(['edit']);
        Route::put('/manajemen-admin/{id}/change-role', [AdminController::class, 'changeRole'])->name('manajemen-admin.change-role');
        Route::post('/manajemen-admin/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('manajemen-admin.toggle-status');
        Route::resource('manajemen-admin', AdminController::class);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    });

    // ADMIN & KASIR
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/process', [KasirController::class, 'process'])->name('kasir.process');
    Route::get('/barang/export-pdf', [BarangController::class, 'exportPdf'])->name('barang.export-pdf');
    Route::resource('barang', BarangController::class);
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::resource('pelanggan', PelangganController::class)->except(['edit']);
    Route::post('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::resource('pesanan', PesananController::class);
    Route::get('/transaksi', [RiwayatTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [RiwayatTransaksiController::class, 'show'])->name('transaksi.show');
});

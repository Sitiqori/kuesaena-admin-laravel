<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Kategori\KategoriController;
use App\Http\Controllers\Barang\BarangController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Pesanan\PesananController;
use App\Http\Controllers\Transaksi\RiwayatTransaksiController;
use App\Http\Controllers\Pengeluaran\PengeluaranController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\ManajemenAdmin\AdminController;
use App\Http\Controllers\Customer\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================
// ROOT (SMART REDIRECT)
// ==========================
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        if (Auth::user()->role === 'kasir') {
            return redirect()->route('kasir.index');
        }
    }
    // kalau belum login → tampilkan landing page kamu
    return app(HomeController::class)->index();
})->name('home');

// ==========================
// CUSTOMER (PUBLIC)
// ==========================
Route::get('/menu', function () {
    return view('customer.pages.home');
})->name('customer.menu');

Route::get('/about', function () {
    return view('customer.pages.home');
})->name('customer.about');

// ==========================
// AUTH (Guest only)
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// ==========================
// LOGOUT
// ==========================
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================
// PROTECTED (LOGIN)
// ==========================
Route::middleware(['auth'])->group(function () {

    // ===== ADMIN ONLY =====
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

    // ===== ADMIN & KASIR =====
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

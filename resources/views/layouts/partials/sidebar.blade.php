<aside class="sidebar">
    <div class="logo" style="text-align: center; padding: 20px 0;">
        <img src="{{ asset('images/logo.png') }}" alt="KUESAENA Malky Production" style="max-width:150px;">
    </div>


    <nav class="menu">
        @if(auth()->user()->role == 'admin')
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="icon-home"></i>
                <span>Admin Dashboard</span>
            </a>
        @endif

        <a href="{{ route('kasir.index') }}" class="{{ request()->routeIs('kasir.*') ? 'active' : '' }}">
            <i class="icon-cash"></i>
            <span>Kasir</span>
        </a>

        <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <i class="icon-box"></i>
            <span>Barang & Stok</span>
        </a>

        {{-- <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="icon-tag"></i>
            <span>Kategori</span>
        </a> --}}

        <a href="{{ route('pesanan.index') }}" class="{{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
            <i class="icon-cart"></i>
            <span>Pesanan</span>
        </a>

        <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="icon-history"></i>
            <span>Riwayat Transaksi</span>
        </a>

        @if(auth()->user()->role == 'admin')
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="icon-chart"></i>
                <span>Laporan Penjualan</span>
            </a>

            <a href="{{ route('pengeluaran.index') }}" class="{{ request()->routeIs('pengeluaran.*') ? 'active' : '' }}">
                <i class="icon-wallet"></i>
                <span>Pengeluaran</span>
            </a>
        @endif

        <a href="{{ route('pelanggan.index') }}" class="{{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
            <i class="icon-users"></i>
            <span>Manajemen Pelanggan</span>
        </a>

        @if(auth()->user()->role == 'admin')


            <a href="{{ route('manajemen-admin.index') }}" class="{{ request()->routeIs('manajemen-admin.*') ? 'active' : '' }}">
                <i class="icon-admin"></i>
                <span>Manajemen Admin</span>
            </a>
        @endif
    </nav>
</aside>

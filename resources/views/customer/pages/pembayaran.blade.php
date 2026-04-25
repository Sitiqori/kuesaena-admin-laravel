@extends('customer.layouts.app')

@section('title', 'Pilih Pembayaran - Kuesaena')

@push('styles')
<style>
.page-content { padding-top: 80px; background: #f9f5f0; min-height: 100vh; }
.pembayaran-wrapper { max-width: 700px; margin: 0 auto; padding: 40px 20px 60px; }
.pembayaran-card { background: #fff; border-radius: 12px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 20px; }
.pembayaran-card h2 { font-size: 18px; font-weight: 700; color: #1A0A00; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f0e8df; }
.metode-list { display: flex; flex-direction: column; gap: 12px; }
.metode-item { display: flex; align-items: center; gap: 16px; padding: 14px 18px; border: 2px solid #f0e8df; border-radius: 10px; cursor: pointer; transition: all 0.2s; background: #fff; }
.metode-item:hover { border-color: #C68B5A; background: #fdf8f3; }
.metode-item.selected { border-color: #3B1A08; background: #fdf8f3; }
.metode-icon { width: 48px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 20px; background: #f9f5f0; flex-shrink: 0; }
.metode-nama { font-weight: 600; font-size: 15px; color: #1A0A00; flex: 1; }
.metode-radio { width: 18px; height: 18px; accent-color: #3B1A08; }
.total-section { display: flex; justify-content: space-between; align-items: center; padding: 16px 0 0; border-top: 1px solid #f0e8df; margin-top: 8px; }
.total-label { font-size: 15px; color: #4A2C10; }
.total-nilai { font-size: 20px; font-weight: 700; color: #3B1A08; }
.btn-actions { display: flex; justify-content: space-between; margin-top: 24px; }
.btn-kembali { background: #3B1A08; color: #fff; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; }
.btn-kembali:hover { background: #5C2D0E; color: #fff; }
.btn-bayar { background: #3B1A08; color: #fff; padding: 12px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: all 0.2s; }
.btn-bayar:hover { background: #5C2D0E; }
.btn-bayar:disabled { background: #C68B5A; cursor: not-allowed; }
.alert-error { background: #ffebee; color: #c62828; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
</style>
@endpush

@section('content')
<div class="page-content">
<div class="pembayaran-wrapper">

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pembayaran.proses') }}" method="POST" id="form-bayar">
        @csrf

        {{-- Hidden fields supaya data checkout tidak hilang --}}
        <input type="hidden" name="delivery_method" value="{{ session('checkout_data.delivery_method', 'pickup') }}">
        <input type="hidden" name="cake_flavor" value="{{ session('checkout_data.cake_flavor') }}">
        <input type="hidden" name="size" value="{{ session('checkout_data.size') }}">
        <input type="hidden" name="notes" value="{{ session('checkout_data.notes') }}">
        <input type="hidden" name="address_id" value="{{ session('checkout_data.address_id') }}">

        <div class="pembayaran-card">
            <h2>Opsi Pembayaran</h2>

            <div class="metode-list">
                @php
                $metodes = [
                    ['value' => 'qris',         'label' => 'QRIS',         'icon' => '▪️'],
                    ['value' => 'shopee_pay',    'label' => 'Shopee Pay',   'icon' => '🛍️'],
                    ['value' => 'dana',          'label' => 'Dana',         'icon' => '💙'],
                    ['value' => 'gopay',         'label' => 'Gopay',        'icon' => '💚'],
                    ['value' => 'ovo',           'label' => 'OVO',          'icon' => '💜'],
                    ['value' => 'cod',           'label' => 'COD',          'icon' => '💵'],
                    ['value' => 'kartu_kredit',  'label' => 'Kartu Kredit', 'icon' => '💳'],
                    ['value' => 'transfer_bank', 'label' => 'Transfer Bank','icon' => '🏦'],
                ];
                @endphp

                @foreach($metodes as $m)
                <label class="metode-item" id="label-{{ $m['value'] }}" onclick="pilihMetode('{{ $m['value'] }}')">
                    <div class="metode-icon">{{ $m['icon'] }}</div>
                    <span class="metode-nama">{{ $m['label'] }}</span>
                    <input type="radio" name="payment_method" value="{{ $m['value'] }}"
                           class="metode-radio" id="radio-{{ $m['value'] }}">
                </label>
                @endforeach
            </div>

            <div class="total-section">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-nilai">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="btn-actions">
            <a href="{{ route('checkout') }}" class="btn-kembali">Kembali</a>
            <button type="submit" class="btn-bayar" id="btn-bayar" disabled>Bayar</button>
        </div>

    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
function pilihMetode(value) {
    document.querySelectorAll('.metode-item').forEach(el => el.classList.remove('selected'));
    document.getElementById('label-' + value).classList.add('selected');
    document.getElementById('radio-' + value).checked = true;
    document.getElementById('btn-bayar').disabled = false;
}
</script>
@endpush
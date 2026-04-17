@extends('customer.pages.profil.layout')

@section('profil-content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid #ede0d0;">
    <h2 class="profil-section-title" style="margin:0; padding:0; border:none;">ALAMAT</h2>
    <button onclick="openModal('modal-tambah')" class="btn-brown" style="font-size:13px; padding:10px 20px;">
        Tambah Alamat Baru
    </button>
</div>

@forelse($addresses as $addr)
<div class="address-card">
    <div class="address-card-header">
        <input type="radio" name="selected_addr" style="accent-color:#5C2D0E;" {{ $loop->first ? 'checked' : '' }}>
        <span class="address-label">{{ $addr->label }}</span>
    </div>
    <p class="address-text">
        {{ $addr->address }}<br>
        @if($addr->kelurahan || $addr->kecamatan)
            Kelurahan: {{ $addr->kelurahan }} &nbsp; Kecamatan: {{ $addr->kecamatan }}<br>
        @endif
        @if($addr->kota || $addr->provinsi)
            Kota/Kabupaten: {{ $addr->kota }} &nbsp; Provinsi: {{ $addr->provinsi }}
            @if($addr->kode_pos) &nbsp; Kode Pos: {{ $addr->kode_pos }} @endif
        @endif
    </p>
    @if($addr->catatan)
        <p class="address-text"><strong>Catatan : </strong>{{ $addr->catatan }}</p>
    @endif
    @if($addr->phone)
        <p class="address-text">{{ $addr->phone }}</p>
    @endif
    <div class="address-actions">
        <button onclick="openEditModal({{ $addr->id }}, '{{ addslashes($addr->label) }}', '{{ addslashes($addr->address) }}', '{{ addslashes($addr->kelurahan) }}', '{{ addslashes($addr->kecamatan) }}', '{{ addslashes($addr->kota) }}', '{{ addslashes($addr->provinsi) }}', '{{ addslashes($addr->kode_pos) }}', '{{ addslashes($addr->catatan) }}', '{{ addslashes($addr->phone) }}')" class="btn-brown" style="font-size:13px; padding:8px 18px;">Edit</button>
    </div>
</div>
@empty
<div style="text-align:center; padding:56px 24px; color:#8B6050;">
    <i class="fas fa-map-marker-alt" style="font-size:36px; margin-bottom:16px; display:block; color:#C68B5A;"></i>
    <p style="font-size:15px; font-weight:600; margin-bottom:6px; color:#4A2C10;">Belum ada alamat tersimpan</p>
    <p style="font-size:13px;">Tambahkan alamat pengiriman untuk mempercepat proses pemesanan.</p>
</div>
@endforelse


{{-- ===== MODAL TAMBAH ALAMAT ===== --}}
<div id="modal-tambah" class="modal-overlay">
    <div class="modal-box">
        <h3 class="modal-title"><i class="fas fa-map-marker-alt" style="color:#5C2D0E; margin-right:8px;"></i>Tambah Alamat Baru</h3>
        <form action="{{ route('customer.profil.alamat.store') }}" method="POST">
            @csrf
            <div class="modal-field">
                <label class="modal-label">Label (Rumah / Kantor / dll)</label>
                <input type="text" name="label" class="modal-input" placeholder="cth: Rumah" required>
            </div>
            <div class="modal-field">
                <label class="modal-label">Alamat Lengkap</label>
                <textarea name="address" class="modal-input" rows="3" placeholder="Jl. Contoh No. 123, RT/RW..." required style="resize:none;"></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div class="modal-field">
                    <label class="modal-label">Kelurahan</label>
                    <input type="text" name="kelurahan" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Kota / Kabupaten</label>
                    <input type="text" name="kota" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Provinsi</label>
                    <input type="text" name="provinsi" class="modal-input">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div class="modal-field">
                    <label class="modal-label">Kode Pos</label>
                    <input type="text" name="kode_pos" class="modal-input" placeholder="cth: 17520">
                </div>
                <div class="modal-field">
                    <label class="modal-label">No. Telepon</label>
                    <input type="text" name="phone" class="modal-input" placeholder="+62...">
                </div>
            </div>
            <div class="modal-field">
                <label class="modal-label">Catatan (opsional)</label>
                <input type="text" name="catatan" class="modal-input" placeholder="cth: *Dekat Masjid Hijau">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" onclick="closeModal('modal-tambah')">Batal</button>
                <button type="submit" class="btn-brown">Simpan Alamat</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT ALAMAT ===== --}}
<div id="modal-edit" class="modal-overlay">
    <div class="modal-box">
        <h3 class="modal-title"><i class="fas fa-edit" style="color:#5C2D0E; margin-right:8px;"></i>Edit Alamat</h3>
        <form id="form-edit-alamat" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-field">
                <label class="modal-label">Label</label>
                <input type="text" name="label" id="edit-label" class="modal-input" required>
            </div>
            <div class="modal-field">
                <label class="modal-label">Alamat Lengkap</label>
                <textarea name="address" id="edit-address" class="modal-input" rows="3" required style="resize:none;"></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div class="modal-field">
                    <label class="modal-label">Kelurahan</label>
                    <input type="text" name="kelurahan" id="edit-kelurahan" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Kecamatan</label>
                    <input type="text" name="kecamatan" id="edit-kecamatan" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Kota / Kabupaten</label>
                    <input type="text" name="kota" id="edit-kota" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">Provinsi</label>
                    <input type="text" name="provinsi" id="edit-provinsi" class="modal-input">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div class="modal-field">
                    <label class="modal-label">Kode Pos</label>
                    <input type="text" name="kode_pos" id="edit-kode_pos" class="modal-input">
                </div>
                <div class="modal-field">
                    <label class="modal-label">No. Telepon</label>
                    <input type="text" name="phone" id="edit-phone" class="modal-input">
                </div>
            </div>
            <div class="modal-field">
                <label class="modal-label">Catatan</label>
                <input type="text" name="catatan" id="edit-catatan" class="modal-input">
            </div>
            <div class="modal-footer">
                <form id="form-hapus-alamat" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-red" onclick="return confirm('Hapus alamat ini?')">Hapus</button>
                </form>
                <button type="button" class="btn-ghost" onclick="closeModal('modal-edit')">Batal</button>
                <button type="submit" form="form-edit-alamat" class="btn-brown">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}

function openEditModal(id, label, address, kelurahan, kecamatan, kota, provinsi, kode_pos, catatan, phone) {
    const baseUrl = '{{ url("profil/alamat") }}';
    document.getElementById('form-edit-alamat').action = baseUrl + '/' + id;
    document.getElementById('form-hapus-alamat').action = baseUrl + '/' + id;
    document.getElementById('edit-label').value     = label;
    document.getElementById('edit-address').value   = address;
    document.getElementById('edit-kelurahan').value = kelurahan;
    document.getElementById('edit-kecamatan').value = kecamatan;
    document.getElementById('edit-kota').value      = kota;
    document.getElementById('edit-provinsi').value  = provinsi;
    document.getElementById('edit-kode_pos').value  = kode_pos;
    document.getElementById('edit-catatan').value   = catatan;
    document.getElementById('edit-phone').value     = phone;
    openModal('modal-edit');
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
</script>
@endpush

@endsection

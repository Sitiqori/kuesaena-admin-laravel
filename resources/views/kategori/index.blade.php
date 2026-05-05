@extends('layouts.partials.master')
@section('title', 'Manajemen Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div style="display:flex; justify-content:flex-end; margin-bottom:20px;">
    <button onclick="openAddModal()" style="padding:10px 20px; background:#5C4033; color:white; border:none; border-radius:6px; cursor:pointer; font-size:14px;">➕ Tambah Kategori</button>
</div>

<div style="background:white; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1); padding:20px;">
    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#f8f8f8;">
            <tr>
                <th style="padding:12px; text-align:left; border-bottom:2px solid #e0e0e0;">Nama Kategori</th>
                <th style="padding:12px; text-align:left; border-bottom:2px solid #e0e0e0;">Deskripsi</th>
                <th style="padding:12px; text-align:left; border-bottom:2px solid #e0e0e0;">Jumlah Produk</th>
                <th style="padding:12px; text-align:left; border-bottom:2px solid #e0e0e0;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:12px;">{{ $cat->name }}</td>
                <td style="padding:12px;">{{ $cat->description ?? '-' }}</td>
                <td style="padding:12px;">{{ $cat->products_count }}</td>
                <td style="padding:12px;">
                    <button onclick="openEditModal({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->description }}')" style="padding:6px 12px; background:#fff3e0; color:#e65100; border:none; border-radius:4px; cursor:pointer;">✏️</button>
                    <button onclick="deleteKategori({{ $cat->id }})" style="padding:6px 12px; background:#ffebee; color:#c62828; border:none; border-radius:4px; cursor:pointer;">🗑️</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; padding:40px; color:#999;">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="katModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; width:90%; max-width:500px; padding:30px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 id="modalTitle" style="font-size:18px; font-weight:600;">Tambah Kategori</h3>
            <span onclick="closeModal()" style="font-size:28px; cursor:pointer; color:#999;">&times;</span>
        </div>
        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:14px; font-weight:500; margin-bottom:8px;">Nama Kategori *</label>
            <input type="text" id="katName" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
        </div>
        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:14px; font-weight:500; margin-bottom:8px;">Deskripsi</label>
            <textarea id="katDesc" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px; min-height:80px;"></textarea>
        </div>
        <div style="display:flex; gap:10px; justify-content:flex-end;">
            <button onclick="closeModal()" style="padding:10px 20px; background:white; border:1px solid #ddd; border-radius:6px; cursor:pointer;">Batal</button>
            <button onclick="saveKategori()" style="padding:10px 20px; background:#5C4033; color:white; border:none; border-radius:6px; cursor:pointer;">Simpan</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let editId = null;

function openAddModal() {
    editId = null;
    document.getElementById('modalTitle').textContent = 'Tambah Kategori';
    document.getElementById('katName').value = '';
    document.getElementById('katDesc').value = '';
    document.getElementById('katModal').style.display = 'flex';
}

function openEditModal(id, name, desc) {
    editId = id;
    document.getElementById('modalTitle').textContent = 'Edit Kategori';
    document.getElementById('katName').value = name;
    document.getElementById('katDesc').value = desc === 'null' ? '' : desc;
    document.getElementById('katModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('katModal').style.display = 'none';
}

function katToast(title, msg, type) {
    var existing = document.getElementById('kat-toast-wrap');
    if (!existing) {
        existing = document.createElement('div');
        existing.id = 'kat-toast-wrap';
        existing.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:10px;pointer-events:none;';
        document.body.appendChild(existing);
    }
    var colors = { s:'#16a34a', e:'#e74c3c', w:'#d97706' };
    var icons  = { s:'fa-check', e:'fa-times', w:'fa-exclamation' };
    var t = document.createElement('div');
    t.style.cssText = 'display:flex;align-items:center;gap:12px;background:#fff;border-radius:12px;padding:14px 18px;min-width:260px;max-width:340px;box-shadow:0 8px 30px rgba(0,0,0,0.13);pointer-events:all;border-left:4px solid '+(colors[type]||colors.s)+';transform:translateX(120%);opacity:0;transition:transform .35s cubic-bezier(.34,1.56,.64,1),opacity .3s ease;';
    t.innerHTML = '<i class="fas '+(icons[type]||icons.s)+'" style="color:'+(colors[type]||colors.s)+'"></i>'
        + '<div><div style="font-size:13px;font-weight:700;color:#1A0A00;">'+title+'</div>'+(msg?'<div style="font-size:12px;color:#6b7280;">'+msg+'</div>':'')+'</div>';
    existing.appendChild(t);
    requestAnimationFrame(function(){ requestAnimationFrame(function(){ t.style.transform='translateX(0)'; t.style.opacity='1'; }); });
    setTimeout(function(){ t.style.transform='translateX(120%)'; t.style.opacity='0'; setTimeout(function(){ t.remove(); }, 400); }, 3500);
}

function saveKategori() {
    const name = document.getElementById('katName').value.trim();
    const desc = document.getElementById('katDesc').value;

    if (!name) { katToast('Validasi', 'Nama kategori harus diisi.', 'w'); return; }

    const url = editId ? '{{ url('/kategori') }}/' + editId : '{{ url('/kategori') }}';
    const body = new URLSearchParams({ name, description: desc, _token: '{{ csrf_token() }}' });
    if (editId) body.append('_method', 'PUT');

    fetch(url, { method: 'POST', body })
        .then(r => r.json())
        .then(data => {
            if (data.success) { closeModal(); katToast('Berhasil', 'Kategori berhasil disimpan.', 's'); setTimeout(() => location.reload(), 1200); }
            else katToast('Gagal', data.message || 'Terjadi kesalahan.', 'e');
        })
        .catch(() => katToast('Error', 'Gagal menghubungi server.', 'e'));
}

function deleteKategori(id) {
    // UI confirm modal inline
    var ov = document.createElement('div');
    ov.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:999999;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(2px);';
    ov.innerHTML = '<div style="background:#fff;border-radius:18px;padding:32px 28px 24px;width:340px;max-width:92vw;box-shadow:0 24px 60px rgba(0,0,0,.18);text-align:center;">'
        + '<div style="width:56px;height:56px;border-radius:50%;background:#fff5f5;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:22px;"><i class="fas fa-trash-alt" style="color:#e74c3c;"></i></div>'
        + '<div style="font-size:16px;font-weight:700;color:#1A0A00;margin-bottom:8px;">Hapus Kategori?</div>'
        + '<div style="font-size:13px;color:#6b7280;margin-bottom:22px;">Kategori ini akan dihapus secara permanen.</div>'
        + '<div style="display:flex;gap:10px;justify-content:center;">'
        + '<button id="kat-cancel-btn" style="padding:10px 26px;border-radius:20px;border:1.5px solid #ddd;background:#fff;font-size:14px;font-weight:500;cursor:pointer;min-width:90px;">Batal</button>'
        + '<button id="kat-ok-btn" style="padding:10px 26px;border-radius:20px;border:none;background:#c0392b;color:#fff;font-size:14px;font-weight:600;cursor:pointer;min-width:90px;">Ya, Hapus</button>'
        + '</div></div>';
    document.body.appendChild(ov);
    ov.querySelector('#kat-cancel-btn').onclick = function(){ ov.remove(); };
    ov.addEventListener('click', function(e){ if(e.target===ov) ov.remove(); });
    ov.querySelector('#kat-ok-btn').onclick = function() {
        ov.remove();
        fetch('{{ url('/kategori') }}/' + id, {
            method: 'POST',
            body: new URLSearchParams({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
        }).then(r => r.json()).then(data => {
            if (data.success) { katToast('Berhasil', 'Kategori berhasil dihapus.', 's'); setTimeout(() => location.reload(), 1200); }
            else katToast('Gagal', data.message || 'Gagal menghapus.', 'e');
        }).catch(() => katToast('Error', 'Gagal menghubungi server.', 'e'));
    };
}
</script>
@endpush
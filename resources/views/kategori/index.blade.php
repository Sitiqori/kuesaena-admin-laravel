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

function saveKategori() {
    const name = document.getElementById('katName').value;
    const desc = document.getElementById('katDesc').value;

    if (!name) { alert('Nama kategori harus diisi'); return; }

    const url = editId ? `/kategori/${editId}` : '/kategori';
    const body = new URLSearchParams({ name, description: desc, _token: '{{ csrf_token() }}' });
    if (editId) body.append('_method', 'PUT');

    fetch(url, { method: 'POST', body })
        .then(r => r.json())
        .then(data => {
            if (data.success) { closeModal(); location.reload(); }
            else alert(data.message);
        });
}

function deleteKategori(id) {
    if (!confirm('Yakin hapus kategori ini?')) return;
    fetch(`/kategori/${id}`, {
        method: 'POST',
        body: new URLSearchParams({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
    }).then(r => r.json()).then(data => {
        if (data.success) location.reload();
        else alert(data.message);
    });
}
</script>
@endpush
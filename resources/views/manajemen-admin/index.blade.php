@extends('layouts.partials.master')

@section('title', 'Manajemen Admin')
@section('page-title', 'Manajemen Admin')

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

    .users-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .user-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s;
    }

    .user-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #5C4033;
    }

    .user-card.inactive {
        opacity: 0.6;
        background: #f5f5f5;
    }

    .user-checkbox {
        display: flex;
        align-items: center;
    }

    .user-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .user-avatar {
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

    .user-info {
        flex: 1;
    }

    .user-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .user-contact {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }

    .user-meta {
        font-size: 13px;
        color: #999;
    }

    .user-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .role-admin {
        background: #5C4033;
        color: white;
    }

    .role-kasir {
        background: #e3f2fd;
        color: #1565c0;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-inactive {
        background: #ffebee;
        color: #c62828;
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

    .btn-detail {
        background: #5C4033;
        color: white;
    }

    .btn-detail:hover {
        background: #4A3329;
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
        max-width: 600px;
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

    .user-detail-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #f8f8f8;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .user-detail-avatar {
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

    .user-detail-info h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .user-detail-meta {
        display: flex;
        gap: 10px;
        margin-bottom: 4px;
    }

    .detail-section {
        margin-bottom: 25px;
    }

    .detail-section h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #5C4033;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-label {
        color: #666;
        font-size: 14px;
    }

    .detail-value {
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .action-buttons-modal {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex: 1;
    }

    .btn-primary {
        background: #5C4033;
        color: white;
    }

    .btn-primary:hover {
        background: #4A3329;
    }

    .btn-warning {
        background: #ff9800;
        color: white;
    }

    .btn-warning:hover {
        background: #f57c00;
    }

    .btn-danger {
        background: #f44336;
        color: white;
    }

    .btn-danger:hover {
        background: #d32f2f;
    }

    .btn-success {
        background: #4caf50;
        color: white;
    }

    .btn-success:hover {
        background: #388e3c;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
    }

    .form-group select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div class="stat-info">
            <h4>Admin Aktif</h4>
            <div class="stat-value">{{ $adminAktif }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-info">
            <h4>Total Admin</h4>
            <div class="stat-value">{{ $totalAdmin }}</div>
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
        <h3>Data Admin</h3>
    </div>

    <div class="users-list">
        @forelse($users as $user)
        <div class="user-card {{ $user->is_active ? '' : 'inactive' }}">
            <div class="user-checkbox">
                <input type="checkbox" id="user-{{ $user->id }}">
            </div>

            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="user-info">
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-contact">📧 {{ $user->email }}</div>
                <div class="user-meta">
                    Kantor: {{ $user->office ?? 'Cabang Ciawi' }}
                </div>
            </div>

            <div class="user-actions">
                <span class="role-badge role-{{ strtolower($user->role) }}">
                    {{ ucfirst($user->role) }}
                </span>
                <span class="status-badge status-{{ $user->is_active ? 'active' : 'inactive' }}">
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <button class="btn-action btn-detail" onclick="showUserDetail({{ $user->id }})">
                    Detail
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">👥</div>
            <div>Belum ada data user</div>
        </div>
        @endforelse
    </div>
</div>

<!-- User Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Detail User</h3>
            <span class="close-modal" onclick="closeDetailModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalDetailContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div id="roleModal" class="modal">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Ubah Role</h3>
            <span class="close-modal" onclick="closeRoleModal()">&times;</span>
        </div>
        <form id="roleForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Role Baru</label>
                    <select name="role" id="newRole" required>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #e0e0e0; display: flex; gap: 10px;">
                <button type="button" class="btn btn-warning" onclick="closeRoleModal()" style="flex: none; padding: 10px 20px;">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    Ubah Role
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentUserId = null;

// Show User Detail
function showUserDetail(userId) {
    currentUserId = userId;

    fetch(`/manajemen-admin/${userId}`)
        .then(response => response.json())
        .then(data => {
            const user = data.user;

            const content = `
                <div class="user-detail-header">
                    <div class="user-detail-avatar">
                        ${user.name.charAt(0).toUpperCase()}
                    </div>
                    <div class="user-detail-info">
                        <h2>${user.name}</h2>
                        <div class="user-detail-meta">
                            <span class="role-badge role-${user.role.toLowerCase()}">${user.role.toUpperCase()}</span>
                            <span class="status-badge status-${user.is_active ? 'active' : 'inactive'}">
                                ${user.is_active ? 'Aktif' : 'Nonaktif'}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Informasi Akun</h4>
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">${user.email}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Role</span>
                        <span class="detail-value">${user.role.toUpperCase()}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">${user.is_active ? 'Aktif' : 'Nonaktif'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kantor</span>
                        <span class="detail-value">${user.office || 'Cabang Ciawi'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Bergabung</span>
                        <span class="detail-value">${new Date(user.created_at).toLocaleDateString('id-ID')}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Statistik</h4>
                    <div class="detail-row">
                        <span class="detail-label">Total Transaksi</span>
                        <span class="detail-value">${user.orders_count || 0}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Penjualan</span>
                        <span class="detail-value">Rp ${formatNumber(user.total_sales || 0)}</span>
                    </div>
                </div>

                <div class="action-buttons-modal">
                    <button class="btn btn-warning" onclick="openRoleModal(${userId}, '${user.role}')">
                        🔄 Ubah Role
                    </button>
                    ${user.is_active ?
                        `<button class="btn btn-danger" onclick="toggleUserStatus(${userId}, false)">
                            🚫 Nonaktifkan
                        </button>` :
                        `<button class="btn btn-success" onclick="toggleUserStatus(${userId}, true)">
                            ✓ Aktifkan
                        </button>`
                    }
                </div>
            `;

            document.getElementById('modalDetailContent').innerHTML = content;
            document.getElementById('detailModal').classList.add('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data user');
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
    currentUserId = null;
}

// Open Role Modal
function openRoleModal(userId, currentRole) {
    currentUserId = userId;
    document.getElementById('roleForm').action = `/manajemen-admin/${userId}/change-role`;
    document.getElementById('newRole').value = currentRole;

    closeDetailModal();
    document.getElementById('roleModal').classList.add('show');
}

function closeRoleModal() {
    document.getElementById('roleModal').classList.remove('show');
}

// Toggle User Status
function toggleUserStatus(userId, activate) {
    const message = activate ?
        'Yakin ingin mengaktifkan user ini?' :
        'Yakin ingin menonaktifkan user ini?';

    if (confirm(message)) {
        fetch(`/manajemen-admin/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ is_active: activate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Close modals when clicking outside
window.onclick = function(event) {
    const detailModal = document.getElementById('detailModal');
    const roleModal = document.getElementById('roleModal');

    if (event.target === detailModal) {
        closeDetailModal();
    }
    if (event.target === roleModal) {
        closeRoleModal();
    }
}
</script>
@endpush

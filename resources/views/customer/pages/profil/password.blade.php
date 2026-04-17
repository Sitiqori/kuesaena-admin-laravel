@extends('customer.pages.profil.layout')

@section('profil-content')

<h2 class="profil-section-title">UBAH PASSWORD</h2>

<div style="background:#f5ead8; border-radius:16px; padding:32px; max-width:500px;">
    <form action="{{ route('customer.profil.password.update') }}" method="POST">
        @csrf

        @if($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:13px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="margin-bottom:20px;">
            <label style="font-size:14px; font-weight:600; display:block; margin-bottom:8px; color:#1A0A00;">
                Masukkan kata sandi baru
            </label>
            <div style="position:relative;">
                <input
                    type="password"
                    name="new_password"
                    id="new_password"
                    placeholder="Masukkan kata sandi baru"
                    style="width:100%; padding:14px 48px 14px 18px; border:none; border-radius:12px; background:#fff; font-size:14px; font-family:'DM Sans',sans-serif; outline:none; color:#1A0A00;"
                >
                <button type="button" onclick="togglePwd('new_password','eye1')" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#8B6050;">
                    <i class="fas fa-eye" id="eye1"></i>
                </button>
            </div>
        </div>

        <div style="margin-bottom:28px;">
            <label style="font-size:14px; font-weight:600; display:block; margin-bottom:8px; color:#1A0A00;">
                Masukkan ulang kata sandi
            </label>
            <div style="position:relative;">
                <input
                    type="password"
                    name="new_password_confirmation"
                    id="confirm_password"
                    placeholder="Masukkan ulang kata sandi"
                    style="width:100%; padding:14px 48px 14px 18px; border:none; border-radius:12px; background:#fff; font-size:14px; font-family:'DM Sans',sans-serif; outline:none; color:#1A0A00;"
                >
                <button type="button" onclick="togglePwd('confirm_password','eye2')" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#8B6050;">
                    <i class="fas fa-eye" id="eye2"></i>
                </button>
            </div>
        </div>

        <div style="text-align:right;">
            <button type="submit" class="btn-brown">Konfirmasi</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush

@endsection

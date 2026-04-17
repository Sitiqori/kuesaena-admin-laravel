@extends('customer.pages.profil.layout')

@section('profil-content')

@php $user = Auth::user(); @endphp

<h2 class="profil-section-title">PROFIL</h2>

<form action="{{ route('customer.profil.update') }}" method="POST" style="max-width: 620px;">
    @csrf

    {{-- Errors --}}
    @if($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:13px;">
            <ul style="margin:0;padding-left:16px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-field-row">
        <label class="form-field-label">Username</label>
        <input type="text" name="username" class="form-input" value="{{ old('username', $user->username) }}" placeholder="Username">
    </div>

    <div class="form-field-row">
        <label class="form-field-label">Nama</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap" required>
    </div>

    <div class="form-field-row">
        <label class="form-field-label">Email</label>
        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="Email" required>
    </div>

    <div class="form-field-row">
        <label class="form-field-label">Nomor Telp.</label>
        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="+62...">
    </div>

    <div class="form-field-row">
        <label class="form-field-label">Tanggal Lahir</label>
        <div style="display:flex; gap:8px;">
            <input
                type="number"
                name="birth_day"
                class="form-input"
                style="width:64px; text-align:center; padding:13px 6px;"
                placeholder="DD"
                min="1" max="31"
                value="{{ old('birth_day', $user->birth_date ? $user->birth_date->day : '') }}"
            >
            <select name="birth_month" class="form-select" style="flex:1;">
                <option value="">Bulan</option>
                @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                    <option value="{{ $num }}" {{ old('birth_month', $user->birth_date ? $user->birth_date->month : '') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
            <input
                type="number"
                name="birth_year"
                class="form-input"
                style="width:84px; text-align:center; padding:13px 6px;"
                placeholder="YYYY"
                min="1900" max="{{ date('Y') }}"
                value="{{ old('birth_year', $user->birth_date ? $user->birth_date->year : '') }}"
            >
        </div>
    </div>

    <div class="form-field-row">
        <label class="form-field-label">Jenis Kelamin</label>
        <div style="display:flex; gap:28px; align-items:center;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px;">
                <input type="radio" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }} style="accent-color:#5C2D0E;">
                Laki - Laki
            </label>
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px;">
                <input type="radio" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }} style="accent-color:#5C2D0E;">
                Perempuan
            </label>
        </div>
    </div>

    <div style="margin-top: 28px; text-align: right;">
        <button type="submit" class="btn-brown">Edit</button>
    </div>
</form>

@endsection

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('kasir.index');
        }

        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'kasir', // Default role adalah kasir
        ]);

        // Auto login setelah register
        Auth::login($user);

        // Redirect ke halaman kasir karena role default adalah kasir
        return redirect()->route('kasir.index')->with('success', 'Akun berhasil dibuat!');
    }
}

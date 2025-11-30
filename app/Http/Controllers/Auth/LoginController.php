<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        public function index()
    {
        // Jika sudah login, redirect sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }

    protected function redirectBasedOnRole()
    {
        if (Auth::user()->role === 'admin') {
        return redirect()->route('dashboard');
    }

    if (Auth::user()->role === 'kasir') {
        return redirect()->route('kasir.index');
    }

    return redirect('/');
    }
}

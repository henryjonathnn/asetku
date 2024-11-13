<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba melakukan autentikasi
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil
            $user = Auth::user();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}

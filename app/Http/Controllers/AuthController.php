<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('Auth.login');
    }

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
            return redirect()->intended('/aset')->with('success', 'Login berhasil!');
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

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }

    public function settings()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('auth.settings', compact('users'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user->username = $request->username;

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
        ]);

        Log::info('Request data:', $request->all());

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            Log::info('User created:', $user->toArray());

            return back()->with('success', 'User baru berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_username' => 'required|unique:users,username,' . $user->id,
            'edit_password' => 'nullable|min:6',
        ]);

        $user->name = $request->edit_name;
        $user->username = $request->edit_username;
        if ($request->filled('edit_password')) {
            $user->password = Hash::make($request->edit_password);
        }
        $user->save();

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri']);
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}

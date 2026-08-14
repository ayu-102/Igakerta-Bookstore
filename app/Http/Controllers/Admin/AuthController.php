<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.books.index');
        }
        return view('admin.login');
    }

    // Proses Autentikasi Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.books.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Ubah dari route('admin.login') menjadi route('login')
        return redirect()->route('login');
    }
}

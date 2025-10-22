<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login dinamis berdasarkan role
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Bisa login pakai username atau email
        $loginField = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$loginField => $request->name, 'password' => $request->password])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek apakah user punya role
            if (!$user->role) {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'name' => 'Akses Anda belum memiliki role. Hubungi admin.',
                ]);
            }

            // ✅ Simpan informasi role ke session (opsional)
            session(['user_role' => $user->role->name]);

            // ✅ Redirect ke dashboard umum
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang, ' . ($user->role->display_name ?? $user->role->name) . '!');
        }

        return back()->withErrors([
            'name' => 'Username atau password salah.',
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    // // Proses login
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'name' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         // redirect sesuai role
    //         $user = Auth::user();
    //         if ($user->role === 'it_admin') {
    //             return redirect('/dashboard');
    //         } else {
    //             return redirect('/dashboard');
    //         }
    //     }

    //     return back()->withErrors([
    //         'name' => 'name atau password salah.',
    //     ]);
    // }

    // // Logout
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/login');
    // }
}

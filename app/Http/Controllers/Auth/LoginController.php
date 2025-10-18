<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // protected function authenticated($request, $user)
    // {
    //     if ($user->role === 'it_admin') {
    //         return redirect('/dashboard/admin');
    //     }

    //     return redirect('/dashboard/hotel');
    // }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // redirect sesuai role
            $user = Auth::user();
            if ($user->role === 'it_admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/dashboard');
            }
        }

        return back()->withErrors([
            'name' => 'name atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

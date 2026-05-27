<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* ================= LOGIN ================= */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /* ================= REGISTER ================= */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'     => 'required|string|max:255|unique:users',
            'name'     => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'email'     => $request->email,
            'name'     => $request->name,
            'password' => bcrypt($request->password),
            'role_id'   => 2, //1 : admin, 2 : user
        ]);

        Auth::attempt($request->only('email', 'password'));
        return redirect('/');
    }

    /* ================= LOGOUT ================= */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

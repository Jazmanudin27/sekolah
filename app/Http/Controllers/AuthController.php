<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            }
            return redirect()->route('dashboard', ['school_slug' => $user->school->slug]);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard')->with('success', 'Selamat datang Super Admin!');
            }

            if ($user->role === 'admin_alumni') {
                return redirect()->route('admin.dashboard', ['school_slug' => $user->school->slug])->with('success', 'Selamat datang di Panel Admin!');
            }

            return redirect()->route('dashboard', ['school_slug' => $user->school->slug])->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            }
            return redirect()->route('dashboard', ['school_slug' => $user->school->slug]);
        }
        
        $schools = School::orderBy('name')->get();
        return view('auth.register', compact('schools'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'angkatan' => 'required|integer|min:1970|max:2027',
            'jurusan' => 'required|string|max:100',
            'tahun_lulus' => 'required|integer|min:1970|max:2027',
            'domisili' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kontak_whatsapp' => 'required|string|max:20',
        ]);

        User::create([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'tahun_lulus' => $request->tahun_lulus,
            'domisili' => $request->domisili,
            'pekerjaan' => $request->pekerjaan,
            'kontak_whatsapp' => $request->kontak_whatsapp,
            'status_verifikasi' => false, // requires admin verification
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi dari Admin sebelum dapat masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.home')->with('success', 'Logout berhasil.');
    }
}

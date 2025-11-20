<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak ditemukan.',
            ])->onlyInput('username');
        }

        // Cek jika user tidak aktif
        if (!$user->is_active) {
            return back()->withErrors([
                'username' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->onlyInput('username');
        }

        // Attempt login MANUAL tanpa menggunakan Auth::attempt()
        if ($user && password_verify($request->password, $user->password)) {
            // Login berhasil
            Auth::login($user, $request->filled('remember'));
            
            // Update last login
            $user->update(['last_login' => now()]);
            
            $request->session()->regenerate();

            // Redirect berdasarkan level user
            return $this->authenticated($request, $user);
        }

        // Login gagal
        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle response after user authenticated
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect berdasarkan level user
        switch ($user->level) {
            case 'admin':
            case 'kesiswaan':
            case 'kepala_sekolah':
                return redirect()->route('admin.dashboard');
            case 'guru':
            case 'bk':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect('/dashboard');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
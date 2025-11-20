<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'level' => 'required|in:guru,siswa', // sesuaikan dengan kebutuhan
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'password' => Hash::make($validated['password']),
            'level' => $validated['level'],
            'is_active' => true, // atau false jika butuh verifikasi
            'can_verify' => false, // default false
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
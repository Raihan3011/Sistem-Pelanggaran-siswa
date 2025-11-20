<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,guru,kepsek,kesiswaan,wali_kelas,bk,orang_tua,siswa'],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->role,
            'is_active' => true,
        ]);

        // Auto-create siswa record if role is siswa
        if ($request->role === 'siswa') {
            \App\Models\Siswa::create([
                'user_id' => $user->user_id,
                'nis' => str_pad($user->user_id, 6, '0', STR_PAD_LEFT),
                'nisn' => date('Y') . str_pad($user->user_id, 6, '0', STR_PAD_LEFT),
                'nama_siswa' => $request->name,
                'jenis_kelamin' => 'L',
                'tempat_lahir' => '-',
                'tanggal_lahir' => now()->subYears(15),
                'alamat' => '-',
                'no_telp' => '-',
                'kelas_id' => null,
                'foto' => null,
            ]);
        }

        // Auto-create orang_tua record if role is orang_tua
        if ($request->role === 'orang_tua') {
            \App\Models\OrangTua::create([
                'user_id' => $user->user_id,
                'siswa_id' => null,
                'hubungan' => 'Wali',
                'nama_orang_tua' => $request->name,
                'pekerjaan' => '-',
                'pendidikan' => null,
                'no_telp' => '-',
                'alamat' => '-',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect to dashboard (will be handled by DashboardController based on role)
        return redirect(route('dashboard', absolute: false));
    }
}

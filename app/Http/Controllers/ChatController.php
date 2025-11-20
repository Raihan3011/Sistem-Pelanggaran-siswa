<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->level === 'orang_tua') {
            $orangTua = OrangTua::where('user_id', $user->user_id)->first();
            if (!$orangTua) return redirect()->route('dashboard')->with('error', 'Data orang tua tidak ditemukan');
            
            $siswa = $orangTua->siswa;
            if (!$siswa || !$siswa->kelas) return redirect()->route('dashboard')->with('error', 'Data siswa tidak ditemukan');
            
            $waliKelasId = $siswa->kelas->wali_kelas_id;
            if (!$waliKelasId) return redirect()->route('dashboard')->with('error', 'Wali kelas belum ditentukan');
            
            $waliKelas = User::where('user_id', $waliKelasId)->first();
            if (!$waliKelas) return redirect()->route('dashboard')->with('error', 'Wali kelas tidak ditemukan');
            
            $waliKelasList = collect([$waliKelas]);
            return view('chat.index', compact('waliKelasList'));
        }
        
        if ($user->level === 'wali_kelas') {
            $orangTuaList = Siswa::whereHas('kelas', function($q) use ($user) {
                    $q->where('wali_kelas_id', $user->user_id);
                })
                ->with(['orangTua.user'])
                ->get()
                ->pluck('orangTua')
                ->flatten()
                ->pluck('user')
                ->filter()
                ->unique('user_id');
            
            return view('chat.index', compact('orangTuaList'));
        }
        
        return redirect()->route('dashboard');
    }

    public function show($userId)
    {
        $user = Auth::user();
        $lawan = User::findOrFail($userId);
        
        $chats = Chat::where(function($q) use ($user, $userId) {
            $q->where('pengirim_id', $user->user_id)->where('penerima_id', $userId);
        })->orWhere(function($q) use ($user, $userId) {
            $q->where('pengirim_id', $userId)->where('penerima_id', $user->user_id);
        })->orderBy('created_at', 'asc')->get();
        
        Chat::where('pengirim_id', $userId)
            ->where('penerima_id', $user->user_id)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
        
        return view('chat.show', compact('chats', 'lawan'));
    }

    public function store(Request $request)
    {
        $request->validate(['penerima_id' => 'required', 'pesan' => 'required']);
        
        Chat::create([
            'pengirim_id' => Auth::id(),
            'penerima_id' => $request->penerima_id,
            'pesan' => $request->pesan
        ]);
        
        return redirect()->back();
    }
}

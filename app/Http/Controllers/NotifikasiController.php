<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('notifikasi.index', compact('notifikasi'));
    }
    
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('notifikasi_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        $notifikasi->update(['dibaca' => true]);
        
        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }
    
    public function markAllAsRead()
    {
        Notifikasi::where('user_id', auth()->id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
            
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}

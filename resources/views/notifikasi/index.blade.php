@extends('layouts.admin')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')
@section('page-description', 'Daftar notifikasi untuk Anda')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Daftar Notifikasi</h3>
        @if($notifikasi->where('dibaca', false)->count() > 0)
        <form action="{{ route('notifikasi.read-all') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-all"></i> Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    @forelse($notifikasi as $n)
    <div style="background: {{ $n->dibaca ? '#f8fafc' : '#fff' }}; border-left: 4px solid {{ $n->dibaca ? '#e5e7eb' : '#3b82f6' }}; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <i class="bi bi-{{ $n->tipe == 'pelanggaran' ? 'exclamation-triangle' : ($n->tipe == 'sanksi' ? 'shield-exclamation' : ($n->tipe == 'prestasi' ? 'trophy' : 'bell')) }}" style="font-size: 1.2rem; color: {{ $n->tipe == 'pelanggaran' ? '#ef4444' : ($n->tipe == 'sanksi' ? '#f59e0b' : ($n->tipe == 'prestasi' ? '#10b981' : '#3b82f6')) }};"></i>
                    <h4 style="margin: 0; font-size: 1.1rem; font-weight: 600;">{{ $n->judul }}</h4>
                    @if(!$n->dibaca)
                    <span style="background: #3b82f6; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem;">Baru</span>
                    @endif
                </div>
                <p style="margin: 0 0 8px 0; color: #666;">{{ $n->pesan }}</p>
                <small style="color: #999;">{{ $n->created_at->diffForHumans() }}</small>
            </div>
            <div style="display: flex; gap: 10px;">
                @if(!$n->dibaca)
                <form action="{{ route('notifikasi.read', $n->notifikasi_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                        <i class="bi bi-check"></i>
                    </button>
                </form>
                @endif
                @if($n->tipe == 'pelanggaran' && $n->referensi_id)
                <a href="{{ route('pelanggaran.show', $n->referensi_id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">
                    <i class="bi bi-eye"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 40px; color: #666;">
        <i class="bi bi-bell-slash" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
        <p>Belum ada notifikasi</p>
    </div>
    @endforelse
</div>
@endsection

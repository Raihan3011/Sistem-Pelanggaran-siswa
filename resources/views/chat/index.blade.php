@extends('layouts.admin')

@section('content')
<style>
    .chat-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    .chat-header h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }
    .chat-header p {
        margin: 10px 0 0 0;
        opacity: 0.9;
    }
    .contact-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-color: #667eea;
        text-decoration: none;
    }
    .contact-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
        margin-right: 20px;
        flex-shrink: 0;
    }
    .contact-info {
        flex: 1;
    }
    .contact-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }
    .contact-role {
        color: #718096;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .contact-arrow {
        color: #667eea;
        font-size: 24px;
        transition: transform 0.3s ease;
    }
    .contact-card:hover .contact-arrow {
        transform: translateX(5px);
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .empty-state i {
        font-size: 80px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }
    .empty-state h3 {
        color: #2d3748;
        margin-bottom: 10px;
    }
    .empty-state p {
        color: #718096;
    }
</style>

<div class="container-fluid">
    <div class="chat-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <i class="bi bi-chat-dots-fill" style="font-size: 2.5rem;"></i>
            <div>
                <h2>{{ isset($waliKelasList) ? 'Chat dengan Wali Kelas' : 'Chat dengan Orang Tua' }}</h2>
                <p>Pilih kontak untuk memulai percakapan</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if(isset($waliKelasList))
                @forelse($waliKelasList as $waliKelas)
                    <a href="{{ route('chat.show', $waliKelas->user_id) }}" class="contact-card">
                        <div style="display: flex; align-items: center;">
                            <div class="contact-avatar">
                                {{ strtoupper(substr($waliKelas->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="contact-info">
                                <div class="contact-name">{{ $waliKelas->nama_lengkap }}</div>
                                <div class="contact-role">
                                    <i class="bi bi-person-badge"></i>
                                    Wali Kelas
                                </div>
                            </div>
                            <i class="bi bi-chevron-right contact-arrow"></i>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-chat-x"></i>
                        <h3>Wali Kelas Tidak Ditemukan</h3>
                        <p>Belum ada wali kelas yang terdaftar untuk kelas Anda</p>
                    </div>
                @endforelse
            @else
                @forelse($orangTuaList as $orangTua)
                    <a href="{{ route('chat.show', $orangTua->user_id) }}" class="contact-card">
                        <div style="display: flex; align-items: center;">
                            <div class="contact-avatar">
                                {{ strtoupper(substr($orangTua->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="contact-info">
                                <div class="contact-name">{{ $orangTua->nama_lengkap }}</div>
                                <div class="contact-role">
                                    <i class="bi bi-person-hearts"></i>
                                    Orang Tua Siswa
                                </div>
                            </div>
                            <i class="bi bi-chevron-right contact-arrow"></i>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h3>Tidak Ada Orang Tua</h3>
                        <p>Belum ada orang tua siswa yang terdaftar di kelas Anda</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</div>
@endsection

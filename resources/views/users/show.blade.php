@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-description', 'Informasi lengkap pengguna')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>Informasi Pengguna</h3>
        <a href="{{ route('users.index') }}" class="btn btn-danger">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Username</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                {{ $user->username }}
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Nama Lengkap</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                {{ $user->nama_lengkap }}
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Level</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.9rem; background: #3b82f6; color: white;">
                    {{ $user->level_text }}
                </span>
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Status</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.9rem; background: {{ $user->is_active ? '#10b981' : '#ef4444' }}; color: white;">
                    {{ $user->status_text }}
                </span>
            </div>
        </div>

        @if($user->email)
        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Email</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                {{ $user->email }}
            </div>
        </div>
        @endif

        <div>
            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #374151;">Tanggal Dibuat</label>
            <div style="padding: 10px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;">
                {{ $user->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    @php
        $kelasAmpu = \App\Models\Kelas::where('wali_kelas_id', $user->user_id)->first();
        $waliKelasData = \App\Models\WaliKelas::where('user_id', $user->user_id)->first();
        $pelanggaranCount = \DB::table('pelanggaran')->where('guru_pencatat', $user->user_id)->count();
        $sanksiCount = \DB::table('sanksi')->where('guru_penanggung_jawab', $user->user_id)->count();
    @endphp

    @if($user->level == 'wali_kelas' || $kelasAmpu || $waliKelasData)
    <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 15px; color: #374151;">Informasi Wali Kelas</h4>
        <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 15px;">
            @if($waliKelasData)
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div>
                        <strong>NIP:</strong> {{ $waliKelasData->nip }}
                    </div>
                    <div>
                        <strong>Bidang Studi:</strong> {{ $waliKelasData->bidang_studi }}
                    </div>
                    <div>
                        <strong>Jenis Kelamin:</strong> {{ $waliKelasData->jenis_kelamin_text }}
                    </div>
                    <div>
                        <strong>No. Telepon:</strong> {{ $waliKelasData->no_telp ?? '-' }}
                    </div>
                </div>
            @endif
            @if($kelasAmpu)
                <div style="margin-top: 10px;">
                    <strong>Kelas yang Diampu:</strong> 
                    <span style="padding: 4px 8px; background: #10b981; color: white; border-radius: 4px; font-size: 0.9rem;">
                        {{ $kelasAmpu->tingkat }} {{ $kelasAmpu->jurusan }} {{ $kelasAmpu->rombel }}
                    </span>
                </div>
            @else
                <div style="margin-top: 10px; color: #dc3545;">
                    <strong>Status:</strong> Belum memiliki kelas
                </div>
            @endif
        </div>
    </div>
    @endif

    @if($pelanggaranCount > 0 || $sanksiCount > 0)
    <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 15px; color: #374151;">Aktivitas</h4>
        <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px; padding: 15px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <strong>Pelanggaran Dicatat:</strong> {{ $pelanggaranCount }} kasus
                </div>
                <div>
                    <strong>Sanksi Ditangani:</strong> {{ $sanksiCount }} kasus
                </div>
            </div>
        </div>
    </div>
    @endif

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-danger">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
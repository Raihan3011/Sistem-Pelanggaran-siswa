@extends('layouts.admin')

@section('title', 'Detail Prestasi')
@section('page-title', 'Detail Prestasi')
@section('page-description', 'Informasi lengkap prestasi siswa')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('prestasi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Nama Siswa</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->siswa->nama_siswa }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Kelas</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->siswa->kelas->nama_kelas }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Nama Penghargaan</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->penghargaan }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Tingkat</label>
            <p style="margin: 5px 0 15px;"><span class="badge badge-primary">{{ $prestasi->tingkat }}</span></p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Point</label>
            <p style="margin: 5px 0 15px;"><span class="badge badge-success">{{ $prestasi->point }} Poin</span></p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Tanggal Prestasi</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->tanggal->format('d F Y') }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Status Verifikasi</label>
            <p style="margin: 5px 0 15px;">
                <span class="badge badge-{{ $prestasi->status_verifikasi == 'Terverifikasi' ? 'success' : ($prestasi->status_verifikasi == 'Pending' ? 'warning' : 'danger') }}">
                    {{ $prestasi->status_verifikasi }}
                </span>
            </p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Guru Pencatat</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->guruPencatat->name }}</p>
        </div>

        <div style="grid-column: 1 / -1;">
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Keterangan</label>
            <p style="margin: 5px 0 15px;">{{ $prestasi->keterangan ?? '-' }}</p>
        </div>

        @if($prestasi->bukti_dokumen)
        <div style="grid-column: 1 / -1;">
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Bukti Dokumen</label>
            <div style="margin-top: 10px;">
                <img src="{{ asset('storage/' . $prestasi->bukti_dokumen) }}" alt="Bukti Dokumen" style="max-width: 400px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            </div>
        </div>
        @endif
    </div>

    @if(in_array(auth()->user()->level, ['admin', 'kesiswaan']))
    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('prestasi.edit', $prestasi->prestasi_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('prestasi.destroy', $prestasi->prestasi_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
    @endif
</div>

<style>
    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .badge-primary {
        background: rgba(29, 78, 216, 0.1);
        color: #1d4ed8;
    }
    .badge-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .badge-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    .badge-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
</style>
@endsection

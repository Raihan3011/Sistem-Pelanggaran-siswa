@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Guru')
@section('page-description', 'Informasi lengkap guru')

@section('content')
<div class="content-card">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('guru.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Nama Lengkap</label>
            <p style="margin: 5px 0 15px;">{{ $guru->name }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Email</label>
            <p style="margin: 5px 0 15px;">{{ $guru->email }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">NIP</label>
            <p style="margin: 5px 0 15px;">{{ $guru->nip ?? '-' }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">No. Telepon</label>
            <p style="margin: 5px 0 15px;">{{ $guru->no_telepon ?? '-' }}</p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Level</label>
            <p style="margin: 5px 0 15px;">
                <span class="badge badge-{{ $guru->level == 'kesiswaan' ? 'primary' : ($guru->level == 'wali_kelas' ? 'success' : 'info') }}">
                    {{ ucfirst(str_replace('_', ' ', $guru->level)) }}
                </span>
            </p>
        </div>

        <div>
            <label style="font-weight: 600; color: #666; font-size: 0.9rem;">Terdaftar Sejak</label>
            <p style="margin: 5px 0 15px;">{{ $guru->created_at->format('d F Y') }}</p>
        </div>
    </div>

    <div style="margin-top: 30px; display: flex; gap: 10px;">
        <a href="{{ route('guru.edit', $guru->user_id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form action="{{ route('guru.destroy', $guru->user_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    </div>
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
    .badge-info {
        background: rgba(8, 145, 178, 0.1);
        color: #0891b2;
    }
</style>
@endsection
